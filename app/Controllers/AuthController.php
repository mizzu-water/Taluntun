<?php
require_once __DIR__ . '/../../auth/config.php';

class AuthController extends Controller {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            require_once 'auth/config.php';
            $data = json_decode(file_get_contents('php://input'), true);

            $errors = [];
            $email    = trim($data['email'] ?? '');
            $password = $data['password'] ?? '';

            if (empty($email)) {
                $errors['email'] = 'Email address is required.';
            }
            if (empty($password)) {
                $errors['password'] = 'Password is required.';
            }
            if (!empty($errors)) {
                jsonResponse(false, 'Validation failed.', ['errors' => $errors]);
            }

            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user['password_hash'])) {
                jsonResponse(false, 'Validation failed.', [
                    'errors' => ['email' => 'Invalid email or password.']
                ]);
            }

            if (!$user['is_verified']) {
                jsonResponse(false, 'Email not verified.', [
                    'errors' => ['email' => 'Please verify your email before logging in. Check your inbox.'],
                    'not_verified' => true,
                    'email' => $email
                ]);
            }

            startAuthSession();
            session_regenerate_id(true);

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email']     = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];

            jsonResponse(true, 'Login successful.', [
                'full_name' => $user['full_name'],
                'user_type' => $user['user_type'],
                'redirect'  => '' 
            ]);
            exit;
        }

        $this->view('login');
    }

    public function signup() {
        $this->view('signup');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            jsonResponse(false, 'Method not allowed.');
        }

        require_once 'auth/config.php';
        $data = json_decode(file_get_contents('php://input'), true);
        $errors = [];

        $fullName = trim($data['full_name'] ?? '');
        $email    = trim($data['email']     ?? '');
        $password =       $data['password'] ?? '';
        $userType =       $data['user_type'] ?? 'shs';

        if (empty($fullName)) $errors['full_name'] = 'Full name is required.';
        if (empty($email)) $errors['email'] = 'Email is required.';
        if (empty($password)) $errors['password'] = 'Password is required.';
        
        if (!empty($errors)) {
            jsonResponse(false, 'Validation failed.', ['errors' => $errors]);
        }

        $db = getDB();
        $stmt = $db->prepare('SELECT id, is_verified FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($existingId, $isVerified);
            $stmt->fetch();
            $stmt->close();

            if ($isVerified) {
                $db->close();
                jsonResponse(false, 'Validation failed.', [
                    'errors' => ['email' => 'This email is already registered and verified. Please log in.']
                ]);
            } else {
                $verificationCode = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
                $expires          = date('Y-m-d H:i:s', time() + (15 * 60));
                $passwordHash     = password_hash($password, PASSWORD_BCRYPT);

                $upd = $db->prepare('UPDATE users SET full_name = ?, password_hash = ?, user_type = ?, verification_code = ?, token_expires_at = ? WHERE id = ?');
                $upd->bind_param('sssssi', $fullName, $passwordHash, $userType, $verificationCode, $expires, $existingId);
                $upd->execute();
                $upd->close();
                $db->close();

                $mailResult = sendVerificationEmail($email, $fullName, $verificationCode);
                jsonResponse(true, 'A 6-digit verification code has been sent to your email.', [
                    'email'       => $email,
                    'mail_sent'   => $mailResult['success'],
                    'mail_error'  => $mailResult['error'],
                    'dev_code'    => $mailResult['success'] ? null : $verificationCode
                ]);
            }
        }
        $stmt->close();

        $passwordHash     = password_hash($password, PASSWORD_BCRYPT);
        $verificationCode = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $token            = bin2hex(random_bytes(32));
        $expires          = date('Y-m-d H:i:s', time() + (15 * 60));

        $stmt = $db->prepare('INSERT INTO users (full_name, email, password_hash, user_type, verification_token, verification_code, token_expires_at) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssssss', $fullName, $email, $passwordHash, $userType, $token, $verificationCode, $expires);
        
        if (!$stmt->execute()) {
            $stmt->close();
            $db->close();
            jsonResponse(false, 'Registration failed.');
        }

        $stmt->close();
        $db->close();

        $mailResult = sendVerificationEmail($email, $fullName, $verificationCode);
        jsonResponse(true, 'A verification code has been sent.', [
            'email'       => $email,
            'mail_sent'   => $mailResult['success'],
            'mail_error'  => $mailResult['error'],
            'dev_code'    => $mailResult['success'] ? null : $verificationCode
        ]);
    }

    public function logout() {
        require_once 'auth/config.php';
        startAuthSession();
        $_SESSION = [];
        session_destroy();
        
        // Return a view instead of hardcoded HTML
        $this->view('logout');
    }
    
    public function verifyCode() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(false, 'Method not allowed.');
        require_once 'auth/config.php';
        $data = json_decode(file_get_contents('php://input'), true);

        $email = trim($data['email'] ?? '');
        $code  = trim($data['code'] ?? '');

        $db = getDB();
        $stmt = $db->prepare('SELECT id, full_name, user_type, is_verified, verification_code, token_expires_at FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();
        $stmt->close();

        if (!$user) {
            $db->close();
            jsonResponse(false, 'Account not found.');
        }

        if ($user['is_verified']) {
            $db->close();
            jsonResponse(true, 'Account already verified.', ['already_verified' => true, 'redirect' => 'login']);
        }

        if (new DateTime() > new DateTime($user['token_expires_at'])) {
            $db->close();
            jsonResponse(false, 'Verification code expired.');
        }

        if ($user['verification_code'] !== $code) {
            $db->close();
            jsonResponse(false, 'Incorrect verification code.');
        }

        $upd = $db->prepare('UPDATE users SET is_verified = 1, verification_code = NULL, verification_token = NULL, token_expires_at = NULL WHERE id = ?');
        $upd->bind_param('i', $user['id']);
        $upd->execute();
        $upd->close();
        $db->close();

        startAuthSession();
        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email']     = $email;
        $_SESSION['user_type'] = $user['user_type'];

        jsonResponse(true, 'Account verified successfully!', ['redirect' => 'index']);
    }

    public function resendCode() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(false, 'Method not allowed.');
        require_once 'auth/config.php';
        $data = json_decode(file_get_contents('php://input'), true);
        $email = trim($data['email'] ?? '');
        
        $db = getDB();
        $stmt = $db->prepare('SELECT id, full_name, is_verified FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();
        $stmt->close();
        
        if (!$user) jsonResponse(false, 'Email not registered.');
        if ($user['is_verified']) jsonResponse(false, 'Already verified.');
        
        $newCode = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $expires = date('Y-m-d H:i:s', time() + (15 * 60));
        
        $upd = $db->prepare('UPDATE users SET verification_code = ?, token_expires_at = ? WHERE id = ?');
        $upd->bind_param('ssi', $newCode, $expires, $user['id']);
        $upd->execute();
        
        $mailResult = sendVerificationEmail($email, $user['full_name'], $newCode);
        jsonResponse(true, 'Code sent.', [
            'mail_sent' => $mailResult['success'],
            'dev_code'  => $mailResult['success'] ? null : $newCode
        ]);
    }
}

