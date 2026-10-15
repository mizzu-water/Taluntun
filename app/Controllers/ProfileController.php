<?php
require_once __DIR__ . '/../../auth/config.php';

class ProfileController extends Controller {
    public function index() {
        $this->view('profile');
    }
    public function settings() {
        $this->view('settings');
    }
    public function saveCollege() {
        header('Content-Type: application/json');
        
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Not logged in']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['college_id'])) {
            echo json_encode(['success' => false, 'error' => 'Missing college_id']);
            exit;
        }

        $user_id = intval($_SESSION['user_id']);
        $college_id = intval($data['college_id']);

        $conn = getDB();

        try {
            $stmt = $conn->prepare("SELECT id FROM user_saved_colleges WHERE user_id = ? AND college_id = ?");
            $stmt->bind_param("ii", $user_id, $college_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt = $conn->prepare("DELETE FROM user_saved_colleges WHERE user_id = ? AND college_id = ?");
                $stmt->bind_param("ii", $user_id, $college_id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'action' => 'removed', 'message' => 'College removed from shortlist']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to remove college']);
                }
            } else {
                $stmt = $conn->prepare("INSERT INTO user_saved_colleges (user_id, college_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $user_id, $college_id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'action' => 'added', 'message' => 'College saved successfully']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to save college']);
                }
            }
            $stmt->close();
            $conn->close();
        } catch (Throwable $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function saveDegree() {
        header('Content-Type: application/json');

        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Not logged in']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['degree_id'])) {
            echo json_encode(['success' => false, 'error' => 'Missing degree_id']);
            exit;
        }

        $user_id = intval($_SESSION['user_id']);
        $degree_id = intval($data['degree_id']);

        $conn = getDB();

        try {
            $stmt = $conn->prepare("SELECT id FROM user_saved_degrees WHERE user_id = ? AND degree_id = ?");
            $stmt->bind_param("ii", $user_id, $degree_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt = $conn->prepare("DELETE FROM user_saved_degrees WHERE user_id = ? AND degree_id = ?");
                $stmt->bind_param("ii", $user_id, $degree_id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'action' => 'removed', 'message' => 'Degree removed from shortlist']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to remove degree']);
                }
            } else {
                $stmt = $conn->prepare("INSERT INTO user_saved_degrees (user_id, degree_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $user_id, $degree_id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'action' => 'added', 'message' => 'Degree saved successfully']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to save degree']);
                }
            }
            $stmt->close();
            $conn->close();
        } catch (Throwable $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function getProfileData() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Not authenticated', 'redirect' => 'login']);
            exit;
        }

        $user_id = intval($_SESSION['user_id']);
        $conn = getDB();

        try {
            // 1. User Info
            $stmt = $conn->prepare("SELECT id, full_name, email, user_type, is_verified, created_at FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$user) {
                echo json_encode(['success' => false, 'error' => 'User not found']);
                exit;
            }

            // 2. Shortlisted Degrees
            $sqlDegrees = "SELECT d.*, 1 as is_saved, usd.saved_at,
                                  GROUP_CONCAT(CONCAT(c.short_name, '::', c.profile_url) SEPARATOR '|') as campuses_list
                           FROM user_saved_degrees usd
                           JOIN degrees d ON usd.degree_id = d.id
                           LEFT JOIN college_degrees cd ON d.id = cd.degree_id
                           LEFT JOIN colleges c ON cd.college_id = c.id AND (c.is_archived = 0 OR c.is_archived IS NULL)
                           WHERE usd.user_id = ?
                           GROUP BY d.id
                           ORDER BY usd.saved_at DESC";
            $stmtD = $conn->prepare($sqlDegrees);
            $stmtD->bind_param("i", $user_id);
            $stmtD->execute();
            $resD = $stmtD->get_result();
            $saved_degrees = [];
            while ($row = $resD->fetch_assoc()) {
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
                $row['is_saved'] = true;
                $saved_degrees[] = $row;
            }
            $stmtD->close();

            // 3. Shortlisted Colleges
            $sqlColleges = "SELECT c.*, usc.saved_at
                            FROM user_saved_colleges usc
                            JOIN colleges c ON usc.college_id = c.id
                            WHERE usc.user_id = ? AND (c.is_archived = 0 OR c.is_archived IS NULL)
                            ORDER BY usc.saved_at DESC";
            $stmtC = $conn->prepare($sqlColleges);
            $stmtC->bind_param("i", $user_id);
            $stmtC->execute();
            $resC = $stmtC->get_result();
            $saved_colleges = [];
            while ($row = $resC->fetch_assoc()) {
                $saved_colleges[] = $row;
            }
            $stmtC->close();

            // 4. Latest Assessment Result
            $sqlAssessment = "SELECT id, scores, holland_code, taken_at 
                              FROM assessment_results 
                              WHERE user_id = ? 
                              ORDER BY taken_at DESC LIMIT 1";
            $stmtA = $conn->prepare($sqlAssessment);
            $stmtA->bind_param("i", $user_id);
            $stmtA->execute();
            $assessment = $stmtA->get_result()->fetch_assoc();
            $stmtA->close();
            if ($assessment && !empty($assessment['scores'])) {
                $assessment['scores'] = json_decode($assessment['scores'], true);
            }

            // 5. Course Quiz Attempts (Knowledge checks taken by student)
            $quiz_attempts = [];
            $tableCheck = $conn->query("SHOW TABLES LIKE 'course_quiz_attempts'");
            if ($tableCheck && $tableCheck->num_rows > 0) {
                $sqlQuizzes = "SELECT cqa.id, cqa.degree_id, cqa.score, cqa.total_questions, 
                                      cqa.correct_count, cqa.incorrect_count, cqa.skipped_count, 
                                      cqa.taken_at, d.title as degree_title, d.category as degree_category
                               FROM course_quiz_attempts cqa
                               LEFT JOIN degrees d ON cqa.degree_id = d.id
                               WHERE cqa.user_id = ?
                               ORDER BY cqa.taken_at DESC
                               LIMIT 12";
                $stmtQ = $conn->prepare($sqlQuizzes);
                if ($stmtQ) {
                    $stmtQ->bind_param("i", $user_id);
                    $stmtQ->execute();
                    $resQ = $stmtQ->get_result();
                    while ($qRow = $resQ->fetch_assoc()) {
                        $pct = $qRow['total_questions'] > 0 
                            ? (int)round(($qRow['score'] / $qRow['total_questions']) * 100) 
                            : 0;
                        $qRow['percentage'] = $pct;
                        if ($pct >= 90) {
                            $qRow['tier_title'] = "Tier 5 (Expert)";
                            $qRow['tier_badge'] = "badge-expert";
                        } elseif ($pct >= 75) {
                            $qRow['tier_title'] = "Tier 4 (Proficient)";
                            $qRow['tier_badge'] = "badge-proficient";
                        } elseif ($pct >= 60) {
                            $qRow['tier_title'] = "Tier 3 (Intermediate)";
                            $qRow['tier_badge'] = "badge-intermediate";
                        } elseif ($pct >= 40) {
                            $qRow['tier_title'] = "Tier 2 (Basic)";
                            $qRow['tier_badge'] = "badge-basic";
                        } else {
                            $qRow['tier_title'] = "Tier 1 (Beginner)";
                            $qRow['tier_badge'] = "badge-beginner";
                        }
                        $quiz_attempts[] = $qRow;
                    }
                    $stmtQ->close();
                }
            }

            $conn->close();

            echo json_encode([
                'success' => true,
                'user' => $user,
                'saved_degrees' => $saved_degrees,
                'saved_colleges' => $saved_colleges,
                'latest_assessment' => $assessment,
                'quiz_attempts' => $quiz_attempts
            ]);
        } catch (Throwable $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updateSettings() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Not authenticated']);
            exit;
        }

        $user_id = intval($_SESSION['user_id']);
        $data = json_decode(file_get_contents('php://input'), true);

        $conn = getDB();

        try {
            // Update personal details if provided
            if (isset($data['full_name']) && !empty(trim($data['full_name']))) {
                $newName = trim($data['full_name']);
                $newType = isset($data['user_type']) ? $data['user_type'] : $_SESSION['user_type'];
                $stmt = $conn->prepare("UPDATE users SET full_name = ?, user_type = ? WHERE id = ?");
                $stmt->bind_param("ssi", $newName, $newType, $user_id);
                $stmt->execute();
                $stmt->close();
                $_SESSION['full_name'] = $newName;
                $_SESSION['user_type'] = $newType;
            }

            // Update password if requested
            if (!empty($data['new_password'])) {
                if (empty($data['current_password'])) {
                    echo json_encode(['success' => false, 'error' => 'Current password is required to set a new password.']);
                    exit;
                }

                // Verify current password
                $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if (!$user || !password_verify($data['current_password'], $user['password_hash'])) {
                    echo json_encode(['success' => false, 'error' => 'Incorrect current password.']);
                    exit;
                }

                if (strlen($data['new_password']) < 8) {
                    echo json_encode(['success' => false, 'error' => 'New password must be at least 8 characters.']);
                    exit;
                }

                if ($data['new_password'] !== ($data['confirm_password'] ?? '')) {
                    echo json_encode(['success' => false, 'error' => 'New password and confirmation do not match.']);
                    exit;
                }

                $newHash = password_hash($data['new_password'], PASSWORD_BCRYPT);
                $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $stmt->bind_param("si", $newHash, $user_id);
                $stmt->execute();
                $stmt->close();
            }

            $conn->close();

            echo json_encode([
                'success' => true,
                'message' => 'Settings updated successfully!',
                'full_name' => $_SESSION['full_name'],
                'user_type' => $_SESSION['user_type']
            ]);
        } catch (Throwable $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
