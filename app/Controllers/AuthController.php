<?php
require_once __DIR__ . '/../../auth/config.php';

class AuthController extends Controller {

    public function login() {
        startAuthSession();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && isset($_GET['return'])) {
            $requestedReturn = safeAuthReturnPath($_GET['return']);
            if ($requestedReturn !== null) $_SESSION['auth_return_to'] = $requestedReturn;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $this->validateCsrf();
            require_once 'auth/config.php';
            $data = json_decode(file_get_contents('php://input'), true);

            $errors = [];
            $loginInput = trim($data['email'] ?? ($data['login'] ?? ''));
            $password   = $data['password'] ?? '';

            if (empty($loginInput)) {
                $errors['email'] = 'Email or username is required.';
            }
            if (empty($password)) {
                $errors['password'] = 'Password is required.';
            }
            if (!empty($errors)) {
                jsonResponse(false, 'Validation failed.', ['errors' => $errors]);
            }

            $userModel = $this->model('User');
            $user = $userModel->findByLogin($loginInput);

            if (!$user || !password_verify($password, $user['password_hash'])) {
                jsonResponse(false, 'Validation failed.', [
                    'errors' => ['email' => 'Invalid email or password.']
                ]);
            }

            if (!$user['is_verified']) {
                jsonResponse(false, 'Email not verified.', [
                    'errors' => ['email' => 'Please verify your email before logging in. Check your inbox.'],
                    'not_verified' => true,
                    'email' => $user['email']
                ]);
            }

            startAuthSession();
            session_regenerate_id(true);

            $_SESSION['student_id'] = $user['id'];
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['full_name']  = $user['full_name'];
            $_SESSION['email']      = $user['email'];
            $_SESSION['user_type']  = $user['user_type'];
            $_SESSION['role']       = $user['role'] ?? 'user';

            if (($user['role'] ?? 'user') === 'admin') {
                require_once __DIR__ . '/../../admin/includes/bootstrap.php';
                
                // Concurrency check for admin
                $conn = getDB();
                $stmtCheck = $conn->prepare("SELECT current_session_id, last_activity,
                                                    TIMESTAMPDIFF(SECOND, last_activity, NOW()) AS idle_seconds
                                             FROM users WHERE id = ? LIMIT 1");
                $stmtCheck->bind_param('i', $user['id']);
                $stmtCheck->execute();
                $adminCheck = $stmtCheck->get_result()->fetch_assoc();
                $stmtCheck->close();

                $idleSecs = $adminCheck['idle_seconds'] !== null ? (int)$adminCheck['idle_seconds'] : null;
                $hasActiveSession = !empty($adminCheck['current_session_id']) && ($idleSecs === null || $idleSecs <= ADMIN_IDLE_TIMEOUT_SECONDS);

                if ($hasActiveSession) {
                    jsonResponse(false, 'This admin account is already logged in somewhere else.', [
                        'errors' => ['email' => 'This admin account is already logged in somewhere else.']
                    ]);
                }

                // Initialize dedicated admin session
                startAdminSession();
                session_regenerate_id(true);
                $newAdminSessionId = session_id();
                $clientIp = $_SERVER['REMOTE_ADDR'] ?? '';

                $upd = $conn->prepare("UPDATE users 
                                      SET current_session_id = ?, last_activity = NOW(), last_login_ip = ?
                                      WHERE id = ? 
                                        AND (current_session_id IS NULL OR last_activity IS NULL OR TIMESTAMPDIFF(SECOND, last_activity, NOW()) > ?)");
                $timeoutSecs = ADMIN_IDLE_TIMEOUT_SECONDS;
                $upd->bind_param('ssii', $newAdminSessionId, $clientIp, $user['id'], $timeoutSecs);
                $upd->execute();
                $upd->close();

                $_SESSION['admin_id']  = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email']     = $user['email'];
                $_SESSION['role']      = 'admin';

                $redirect = 'admin/index.php';
            } else {
                $redirect = safeAuthReturnPath($_SESSION['auth_return_to'] ?? '') ?? 'home';
            }
            unset($_SESSION['auth_return_to']);

            // Send login confirmation email asynchronously/safely without blocking login
            try {
                $loginDate = date('F j, Y');
                $loginTime = date('g:i A');
                $subject = "Successful Login to Talunton RIASEC System";

                $htmlBody = "
                <div style='background-color: #f4f6f8; padding: 30px 15px; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif;'>
                    <div style='max-width: 560px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;'>
                        <div style='background-color: #0e3223; padding: 28px 24px; text-align: center;'>
                            <h1 style='color: #10b981; margin: 0; font-size: 26px; font-weight: 800; letter-spacing: 0.5px;'>Talunton</h1>
                            <p style='color: #d1fae5; margin: 6px 0 0 0; font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;'>RIASEC Career Profiling System</p>
                        </div>
                        <div style='padding: 32px 28px;'>
                            <h2 style='color: #111827; font-size: 19px; margin-top: 0; font-weight: 700;'>Successful Login Notification</h2>
                            <p style='color: #374151; font-size: 15px; line-height: 1.6; margin-bottom: 20px;'>
                                You have successfully logged in to the Talunton RIASEC System on <strong>{$loginDate}</strong> at <strong>{$loginTime}</strong>. You can now access the system’s features, take the RIASEC assessment, explore recommended degree programs, and discover career paths that match your interests, skills, and personality.
                            </p>
                            <div style='background-color: #f0fdf4; border-left: 4px solid #10b981; padding: 14px 18px; border-radius: 4px; margin-bottom: 24px;'>
                                <p style='color: #065f46; font-size: 13px; margin: 0; line-height: 1.5;'>
                                    If this was not you, please secure your account immediately or contact support.
                                </p>
                            </div>
                            <p style='color: #6b7280; font-size: 14px; margin-bottom: 0;'>
                                Best regards,<br>
                                <strong style='color: #0e3223;'>Talunton Guidance Team</strong>
                            </p>
                        </div>
                        <div style='background-color: #f9fafb; padding: 16px 24px; text-align: center; border-top: 1px solid #f3f4f6;'>
                            <p style='color: #9ca3af; font-size: 12px; margin: 0;'>&copy; " . date('Y') . " Talunton RIASEC System. All rights reserved.</p>
                        </div>
                    </div>
                </div>";

                $plainBody = "You have successfully logged in to the Talunton RIASEC System on {$loginDate} at {$loginTime}. You can now access the system’s features, take the RIASEC assessment, explore recommended degree programs, and discover career paths that match your interests, skills, and personality.\n\nIf this was not you, please secure your account immediately.\n\nTalunton RIASEC System";

                sendMail($user['email'], $subject, $htmlBody, $plainBody);
            } catch (\Throwable $mailEx) {
                $errorMsg = '[' . date('Y-m-d H:i:s') . '] Login notification failed for ' . $user['email'] . ': ' . $mailEx->getMessage() . PHP_EOL;
                $logDir = __DIR__ . '/../../storage/logs';
                if (!is_dir($logDir)) {
                    @mkdir($logDir, 0777, true);
                }
                $logFile = is_dir($logDir) ? $logDir . '/mail.log' : __DIR__ . '/../../auth/mail_errors.log';
                @file_put_contents($logFile, $errorMsg, FILE_APPEND);
            }

            jsonResponse(true, 'Login successful.', [
                'user_id'   => (int)$user['id'],
                'full_name' => $user['full_name'],
                'email'     => $user['email'],
                'user_type' => $user['user_type'],
                'role'      => $user['role'] ?? 'user',
                'redirect'  => $redirect 
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

        $this->validateCsrf();
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
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'], $params['httponly']);
        }
        session_destroy();
        
        // Return a view instead of hardcoded HTML
        $this->view('logout');
    }
    
    public function verifyCode() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(false, 'Method not allowed.');
        $this->validateCsrf();
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
        $_SESSION['student_id'] = $user['id'];
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['full_name']  = $user['full_name'];
        $_SESSION['email']      = $email;
        $_SESSION['user_type']  = $user['user_type'];

        $redirect = safeAuthReturnPath($_SESSION['auth_return_to'] ?? '') ?? 'home';
        unset($_SESSION['auth_return_to']);
        jsonResponse(true, 'Account verified successfully!', ['user_id' => (int)$user['id'], 'full_name' => $user['full_name'], 'email' => $email, 'user_type' => $user['user_type'], 'redirect' => $redirect]);
    }

    public function resendCode() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(false, 'Method not allowed.');
        $this->validateCsrf();
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

