<?php
require_once 'auth/config.php';

class AssessmentController extends Controller {
    public function index() {
        $this->view('assessment');
    }
    public function results() {
        $this->view('results');
    }
    public function save() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            exit;
        }

        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Not logged in']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['scores']) || !isset($data['holland_code'])) {
            echo json_encode(['success' => false, 'error' => 'Missing data']);
            exit;
        }

        $user_id = intval($_SESSION['user_id']);
        $scores = json_encode($data['scores']);
        $holland_code = $data['holland_code'];

        $conn = getDB();

        $stmt = $conn->prepare("INSERT INTO assessment_results (user_id, scores, holland_code) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $scores, $holland_code);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Assessment saved successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to save assessment']);
        }

        $stmt->close();
        $conn->close();
    }

    public function getLatestAssessment() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        $user_id = isLoggedIn() ? intval($_SESSION['user_id']) : 0;

        if ($user_id === 0) {
            echo json_encode(['success' => false, 'is_logged_in' => false, 'error' => 'Not logged in']);
            exit;
        }

        $conn = getDB();
        $stmt = $conn->prepare("SELECT holland_code, scores, taken_at FROM assessment_results WHERE user_id = ? ORDER BY taken_at DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            $scores = json_decode($row['scores'], true);
            echo json_encode([
                'success' => true,
                'is_logged_in' => true,
                'holland_code' => $row['holland_code'],
                'scores' => $scores,
                'taken_at' => $row['taken_at']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'is_logged_in' => true,
                'error' => 'No assessment found'
            ]);
        }

        $stmt->close();
        $conn->close();
    }

    public function getDegrees() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        $user_id = isLoggedIn() ? intval($_SESSION['user_id']) : 0;
        
        $conn = getDB();

        if ($user_id > 0) {
            $sql = "SELECT d.*, IF(usd.id IS NOT NULL, 1, 0) as is_saved,
                           GROUP_CONCAT(CONCAT(c.short_name, '::', c.profile_url) SEPARATOR '|') as campuses_list
                    FROM degrees d 
                    LEFT JOIN user_saved_degrees usd ON d.id = usd.degree_id AND usd.user_id = $user_id
                    LEFT JOIN college_degrees cd ON d.id = cd.degree_id
                    LEFT JOIN colleges c ON cd.college_id = c.id
                    GROUP BY d.id";
        } else {
            $sql = "SELECT d.*, 0 as is_saved,
                           GROUP_CONCAT(CONCAT(c.short_name, '::', c.profile_url) SEPARATOR '|') as campuses_list
                    FROM degrees d
                    LEFT JOIN college_degrees cd ON d.id = cd.degree_id
                    LEFT JOIN colleges c ON cd.college_id = c.id
                    GROUP BY d.id";
        }

        $result = $conn->query($sql);
        $degrees = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['is_saved'] = (bool)$row['is_saved'];
                
                // Parse campuses_list
                $campuses = [];
                if (!empty($row['campuses_list'])) {
                    $pairs = explode('|', $row['campuses_list']);
                    foreach ($pairs as $pair) {
                        $parts = explode('::', $pair);
                        if (count($parts) === 2) {
                            $campuses[] = [
                                'name' => $parts[0],
                                'url' => str_replace('.html', '', $parts[1])
                            ];
                        }
                    }
                }
                $row['campuses'] = $campuses;
                
                $map = json_decode(file_get_contents('image_map.json'), true);
                $img = 'assets/images/placeholder.jpg';
                if($map) {
                    foreach ($map as $k => $v) {
                        if (stripos($row['title'], $k) !== false) {
                            $img = '/riasec/' . $v;
                            break;
                        }
                    }
                }
                $row['image_url'] = $img;
                
                $degrees[] = $row;
            }
        }
        $conn->close();
        echo json_encode($degrees);
    }

    public function getRecommendedDegrees() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        $user_id = isLoggedIn() ? intval($_SESSION['user_id']) : 0;

        if ($user_id === 0) {
            echo json_encode([]);
            exit;
        }

        $conn = getDB();

        $stmt = $conn->prepare("SELECT holland_code, scores FROM assessment_results WHERE user_id = ? ORDER BY taken_at DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $latest = $res->fetch_assoc();
        $stmt->close();

        if (!$latest || empty($latest['scores'])) {
            echo json_encode([]);
            $conn->close();
            exit;
        }

        $scores = json_decode($latest['scores'], true);
        arsort($scores);
        $topTraits = array_keys(array_slice($scores, 0, 3));

        $sql = "SELECT d.*, IF(usd.id IS NOT NULL, 1, 0) as is_saved,
                       GROUP_CONCAT(CONCAT(c.short_name, '::', c.profile_url) SEPARATOR '|') as campuses_list
                FROM degrees d 
                LEFT JOIN user_saved_degrees usd ON d.id = usd.degree_id AND usd.user_id = $user_id
                LEFT JOIN college_degrees cd ON d.id = cd.degree_id
                LEFT JOIN colleges c ON cd.college_id = c.id
                GROUP BY d.id";

        $result = $conn->query($sql);
        $recommended = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['is_saved'] = (bool)$row['is_saved'];
                
                $campuses = [];
                if (!empty($row['campuses_list'])) {
                    $pairs = explode('|', $row['campuses_list']);
                    foreach ($pairs as $pair) {
                        $parts = explode('::', $pair);
                        if (count($parts) === 2) {
                            $campuses[] = [
                                'name' => $parts[0],
                                'url' => str_replace('.html', '', $parts[1])
                            ];
                        }
                    }
                }
                
                $match_score = 0;
                $degree_hc = $row['holland_code'] ?? '';
                if ($degree_hc) {
                    if (isset($topTraits[0]) && strpos($degree_hc, $topTraits[0]) !== false) $match_score += 50;
                    if (isset($topTraits[1]) && strpos($degree_hc, $topTraits[1]) !== false) $match_score += 30;
                    if (isset($topTraits[2]) && strpos($degree_hc, $topTraits[2]) !== false) $match_score += 10;
                }
                
                if ($match_score > 0) {
                    $recommended[] = [
                        'id' => $row['id'],
                        'title' => $row['title'],
                        'fit' => min(99, 45 + $match_score),
                        'isPublic' => ($row['category'] !== 'private'),
                        'tuition' => 'Varies',
                        'scholarship' => 'Check Eligibility',
                        'desc' => $row['description'],
                        'reason' => 'This perfectly aligns with your core traits.',
                        'campusCount' => count($campuses),
                        'campuses' => $campuses,
                        'showDropdown' => false,
                        'score' => $match_score,
                        'holland_code' => $degree_hc
                    ];
                }
            }
        }

        usort($recommended, function($a, $b) {
            return $b['score'] - $a['score'];
        });

        // Deduplicate by ID
        $unique_recommended = [];
        $seen = [];
        foreach ($recommended as $rec) {
            if (!isset($seen[$rec['id']])) {
                $seen[$rec['id']] = true;
                $unique_recommended[] = $rec;
            }
        }

        $unique_recommended = array_slice($unique_recommended, 0, 3);

        $conn->close();
        echo json_encode($unique_recommended);
    }

    public function getDegree() {
        header('Content-Type: application/json');
        if (!isset($_GET['id'])) {
            echo json_encode(['error' => 'No ID provided']);
            exit;
        }

        require_once 'auth/config.php';
        $conn = getDB();
        $id = intval($_GET['id']);

        $stmt = $conn->prepare("SELECT * FROM degrees WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $degree = $result->fetch_assoc();
            $map = json_decode(file_get_contents('image_map.json'), true);
            $img = 'assets/images/placeholder.jpg';
            if($map) {
                foreach ($map as $k => $v) {
                    if (stripos($degree['title'], $k) !== false) {
                        $img = '/riasec/' . $v;
                        break;
                    }
                }
            }
            $degree['image_url'] = $img;

            // Get associated colleges
            $stmt2 = $conn->prepare(
                "SELECT c.* FROM colleges c
                 INNER JOIN college_degrees cd ON c.id = cd.college_id
                 WHERE cd.degree_id = ?"
            );
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $colleges_result = $stmt2->get_result();
            $colleges = [];
            while ($row = $colleges_result->fetch_assoc()) {
                $colleges[] = $row;
            }
            $degree['colleges'] = $colleges;
            $stmt2->close();

            echo json_encode($degree);
        } else {
            echo json_encode(['error' => 'Course not found']);
        }

        $stmt->close();
        $conn->close();
    }

    public function getCollege() {
        header('Content-Type: application/json');
        if (!isset($_GET['id'])) {
            echo json_encode(['error' => 'No ID provided']);
            exit;
        }
        require_once 'auth/config.php';
        $conn = getDB();
        $short_name = $_GET['id'];
        
        $stmt = $conn->prepare("SELECT * FROM colleges WHERE short_name = ?");
        $stmt->bind_param("s", $short_name);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($res->num_rows > 0) {
            $college = $res->fetch_assoc();
            if (isset($college['requirements']) && !empty($college['requirements'])) {
                $college['requirements'] = json_decode($college['requirements'], true);
            }
            
            $stmt2 = $conn->prepare("SELECT d.* FROM degrees d INNER JOIN college_degrees cd ON d.id = cd.degree_id WHERE cd.college_id = ?");
            $stmt2->bind_param("i", $college['id']);
            $stmt2->execute();
            $deg_res = $stmt2->get_result();
            $degrees = [];
            while ($row = $deg_res->fetch_assoc()) {
                $degrees[] = $row;
            }
            $college['degrees'] = $degrees;
            echo json_encode($college);
        } else {
            echo json_encode(['error' => 'College not found']);
        }
    }

    public function getColleges() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        $user_id = isLoggedIn() ? intval($_SESSION['user_id']) : 0;
        $conn = getDB();
        
        if ($user_id > 0) {
            $sql = "SELECT c.*, IF(usc.id IS NOT NULL, 1, 0) as is_saved 
                    FROM colleges c 
                    LEFT JOIN user_saved_colleges usc ON c.id = usc.college_id AND usc.user_id = $user_id 
                    ORDER BY c.name ASC";
        } else {
            $sql = "SELECT c.*, 0 as is_saved FROM colleges c ORDER BY c.name ASC";
        }
        
        $result = $conn->query($sql);
        $colleges = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['is_saved'] = (bool)$row['is_saved'];
                $colleges[] = $row;
            }
        }
        $conn->close();
        echo json_encode($colleges);
    }

    public function getQuestions() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        
        $type = isset($_GET['type']) ? $_GET['type'] : 'standard';
        $conn = getDB();
        
        if ($type === 'extended') {
            $sql = "SELECT id, trait, question_text as text, is_reverse_coded FROM questions";
        } else {
            $sql = "SELECT id, trait, question_text as text, is_reverse_coded FROM questions WHERE test_set = 'standard'";
        }
        
        $result = $conn->query($sql);
        $questions = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $questions[] = [
                    'id' => intval($row['id']),
                    'trait' => $row['trait'],
                    'text' => $row['text'],
                    'is_reverse_coded' => intval($row['is_reverse_coded'])
                ];
            }
        }
        
        $conn->close();
        
        if (count($questions) > 0) {
            echo json_encode(['success' => true, 'questions' => $questions]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No questions found']);
        }
    }

    public function pauseAssessment() {
        return $this->saveProgress();
    }

    public function saveProgress() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Not logged in']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['answers'])) {
            echo json_encode(['success' => false, 'error' => 'Missing data']);
            exit;
        }

        $user_id = intval($_SESSION['user_id']);
        $test_type_int = (isset($data['test_type']) && $data['test_type'] === 'extended') ? 120 : 60;
        $current_index = isset($data['current_question_index']) ? intval($data['current_question_index']) : 0;
        $answers_json = json_encode($data['answers']);

        $conn = getDB();

        $stmt = $conn->prepare("SELECT id FROM user_assessments WHERE user_id = ? AND status = 'in_progress'");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $stmt_up = $conn->prepare("UPDATE user_assessments SET test_type=?, current_question_index=?, answers=?, updated_at=NOW() WHERE id=?");
            $stmt_up->bind_param("iisi", $test_type_int, $current_index, $answers_json, $row['id']);
            $stmt_up->execute();
            $stmt_up->close();
        } else {
            $stmt_in = $conn->prepare("INSERT INTO user_assessments (user_id, test_type, status, current_question_index, answers) VALUES (?, ?, 'in_progress', ?, ?)");
            $stmt_in->bind_param("iiis", $user_id, $test_type_int, $current_index, $answers_json);
            $stmt_in->execute();
            $stmt_in->close();
        }
        $stmt->close();
        $conn->close();
        echo json_encode(["success" => true, "message" => "Progress saved successfully"]);
        exit;
    }

    public function checkProgress() {
        header("Content-Type: application/json");
        require_once "auth/config.php";
        startAuthSession();
        
        if (!isLoggedIn()) {
            echo json_encode(["success" => true, "has_progress" => false]);
            exit;
        }

        $user_id = intval($_SESSION["user_id"]);
        $conn = getDB();
        
        $stmt = $conn->prepare("SELECT test_type, current_question_index, answers FROM user_assessments WHERE user_id = ? AND status = 'in_progress' ORDER BY updated_at DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $row["test_type_str"] = ($row["test_type"] == 120) ? "extended" : "standard";
            $row["answers"] = json_decode($row["answers"], true);
            echo json_encode(["success" => true, "has_progress" => true, "progress" => $row]);
        } else {
            echo json_encode(["success" => true, "has_progress" => false]);
        }

        $stmt->close();
        $conn->close();
        exit;
    }

    public function getRoleModel() {
        header('Content-Type: application/json');
        
        $degreeTitle = $_GET['degree'] ?? '';
        if (empty($degreeTitle)) {
            echo json_encode(['success' => false, 'error' => 'No degree provided']);
            exit;
        }

        require_once 'auth/config.php';
        $conn = getDB();

        // Exact match or partial match on degree
        $stmt = $conn->prepare("SELECT * FROM career_role_models WHERE ? LIKE CONCAT('%', degree_program, '%') LIMIT 1");
        $stmt->bind_param('s', $degreeTitle);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            echo json_encode(['success' => true, 'role_model' => $row]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No matching role model found']);
        }
        
        $stmt->close();
        $conn->close();
        exit;
    }
}


