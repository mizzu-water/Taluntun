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
                
                $degrees[] = $row;
            }
        }
        $conn->close();
        echo json_encode($degrees);
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

    public function saveProgress() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Not logged in']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $user_id = intval($_SESSION['user_id']);
        $test_type_int = ($data['test_type'] === 'extended') ? 120 : 60;
        $current_index = intval($data['current_question_index']);
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
}
