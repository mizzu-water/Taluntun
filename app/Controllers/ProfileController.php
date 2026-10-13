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

    public function saveFavoriteSubjects() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Not logged in']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $subjects = $data['subjects'] ?? [];
        $subjects_str = is_array($subjects) ? json_encode(array_values(array_filter($subjects))) : '[]';

        $user_id = intval($_SESSION['user_id']);
        $conn = getDB();
        $stmt = $conn->prepare("UPDATE users SET favorite_subjects = ? WHERE id = ?");
        $stmt->bind_param("si", $subjects_str, $user_id);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();

        echo json_encode(['success' => $success, 'message' => 'Favorite subjects updated successfully']);
        exit;
    }

    public function getFavoriteSubjects() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'subjects' => []]);
            exit;
        }

        $user_id = intval($_SESSION['user_id']);
        $conn = getDB();
        $stmt = $conn->prepare("SELECT favorite_subjects FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $subjects = [];
        if ($row = $res->fetch_assoc()) {
            if (!empty($row['favorite_subjects'])) {
                $decoded = json_decode($row['favorite_subjects'], true);
                if (is_array($decoded)) {
                    $subjects = $decoded;
                }
            }
        }
        $stmt->close();
        $conn->close();

        echo json_encode(['success' => true, 'subjects' => $subjects]);
        exit;
    }
}
