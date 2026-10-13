<?php
require_once __DIR__ . '/../../auth/config.php';

class ProfileController extends Controller {
    public function index() {
        $this->view('profile');
    }
    public function getCurrentUser() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['logged_in' => false]);
            exit;
        }

        $userId = intval($_SESSION['user_id']);
        $email = $_SESSION['email'] ?? '';
        $fullName = $_SESSION['full_name'] ?? '';
        $userType = $_SESSION['user_type'] ?? 'student';

        if (empty($email) || empty($fullName)) {
            $conn = getDB();
            $stmt = $conn->prepare("SELECT full_name, email, user_type FROM users WHERE id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $fullName = $row['full_name'];
                $email = $row['email'];
                $userType = $row['user_type'];
                $_SESSION['full_name'] = $fullName;
                $_SESSION['email'] = $email;
                $_SESSION['user_type'] = $userType;
            }
            $stmt->close();
            $conn->close();
        }

        echo json_encode([
            'logged_in' => true,
            'id' => $userId,
            'full_name' => $fullName ?: 'Student',
            'email' => $email,
            'user_type' => $userType
        ]);
        exit;
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

    public function changePassword() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Please log in to change your password.']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $currentPassword = trim($data['current_password'] ?? '');
        $newPassword = trim($data['new_password'] ?? '');
        $confirmPassword = trim($data['confirm_password'] ?? '');

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            echo json_encode(['success' => false, 'error' => 'All password fields are required.']);
            exit;
        }

        if (strlen($newPassword) < 8) {
            echo json_encode(['success' => false, 'error' => 'New password must be at least 8 characters long.']);
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            echo json_encode(['success' => false, 'error' => 'New password and confirmation do not match.']);
            exit;
        }

        $userId = intval($_SESSION['user_id']);
        $conn = getDB();
        $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();

        if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
            echo json_encode(['success' => false, 'error' => 'Current password is incorrect.']);
            $conn->close();
            exit;
        }

        $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $updateStmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $updateStmt->bind_param("si", $newHash, $userId);
        $success = $updateStmt->execute();
        $updateStmt->close();
        $conn->close();

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update password. Please try again.']);
        }
        exit;
    }

    public function updateProfileName() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(['success' => false, 'error' => 'Please log in.']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $fullName = trim($data['full_name'] ?? '');

        if (empty($fullName)) {
            echo json_encode(['success' => false, 'error' => 'Full name cannot be empty.']);
            exit;
        }

        $userId = intval($_SESSION['user_id']);
        $conn = getDB();
        $stmt = $conn->prepare("UPDATE users SET full_name = ? WHERE id = ?");
        $stmt->bind_param("si", $fullName, $userId);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();

        if ($success) {
            $_SESSION['full_name'] = $fullName;
            echo json_encode(['success' => true, 'message' => 'Profile name updated successfully!', 'full_name' => $fullName]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update profile name.']);
        }
        exit;
    }
}
