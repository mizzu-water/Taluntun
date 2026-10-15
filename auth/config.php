<?php
// Set system timezone to Asia/Manila (Philippine Time, UTC+8)
date_default_timezone_set('Asia/Manila');

// Central DB & SMTP config — include this in every PHP file
// Load Composer autoloader
$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

// Load environment variables from .env file using vlucas/phpdotenv
$envPath = __DIR__ . '/..';
if (class_exists('Dotenv\Dotenv') && file_exists($envPath . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
    $dotenv->safeLoad();
    foreach ($_ENV as $key => $value) {
        if (!defined($key)) {
            define($key, $value);
        }
    }
} elseif (file_exists($envPath . '/.env')) {
    $envVariables = parse_ini_file($envPath . '/.env');
    foreach ($envVariables as $key => $value) {
        if (!defined($key)) {
            define($key, $value);
        }
    }
} else {
    die("Error: .env file not found.");
}

// Ensure SMTP credential aliases are defined
if (!defined('SMTP_HOST')) define('SMTP_HOST', $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com');
if (!defined('SMTP_PORT')) define('SMTP_PORT', (int)($_ENV['SMTP_PORT'] ?? 587));
if (!defined('SMTP_USERNAME')) define('SMTP_USERNAME', $_ENV['SMTP_USERNAME'] ?? ($_ENV['SMTP_USER'] ?? ''));
if (!defined('SMTP_APP_PASSWORD')) define('SMTP_APP_PASSWORD', $_ENV['SMTP_APP_PASSWORD'] ?? ($_ENV['SMTP_PASS'] ?? ''));
if (!defined('SMTP_USER')) define('SMTP_USER', SMTP_USERNAME);
if (!defined('SMTP_PASS')) define('SMTP_PASS', SMTP_APP_PASSWORD);
if (!defined('SMTP_ENCRYPTION')) define('SMTP_ENCRYPTION', $_ENV['SMTP_ENCRYPTION'] ?? 'tls');
if (!defined('SMTP_FROM_EMAIL')) define('SMTP_FROM_EMAIL', $_ENV['SMTP_FROM_EMAIL'] ?? SMTP_USERNAME);
if (!defined('SMTP_FROM_NAME')) define('SMTP_FROM_NAME', $_ENV['SMTP_FROM_NAME'] ?? 'Talunton');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getDB(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        http_response_code(500);
        die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
    }
    $conn->set_charset('utf8mb4');
    // Ensure database connection timezone is set to Philippine Time (+08:00)
    $conn->query("SET time_zone = '+08:00'");
    return $conn;
}

function jsonResponse(bool $success, string $message, array $data = []): void {
    header('Content-Type: application/json');
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $data));
    exit;
}

function startAuthSession(): void {
    if (session_status() !== PHP_SESSION_NONE) return;
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    $secure = (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') || (($_SERVER['SERVER_PORT'] ?? null) == 443);
    session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'secure' => $secure, 'httponly' => true, 'samesite' => 'Lax']);
    session_start();
}

function isLoggedIn(): bool {
    static $checkedUserId = null;
    static $checkedResult = false;
    startAuthSession();
    if (!isset($_SESSION['user_id']) || filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT) === false || (int)$_SESSION['user_id'] < 1) return false;
    $userId = (int)$_SESSION['user_id'];
    if ($checkedUserId === $userId) return $checkedResult;
    $checkedUserId = $userId;
    try {
        $conn = getDB();
        $stmt = $conn->prepare('SELECT is_verified FROM users WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->bind_result($isVerified);
        $checkedResult = $stmt->fetch() && (bool)$isVerified;
        $stmt->close();
        $conn->close();
    } catch (Throwable $error) {
        $checkedResult = false;
    }
    if (!$checkedResult) {
        unset($_SESSION['user_id'], $_SESSION['full_name'], $_SESSION['email'], $_SESSION['user_type']);
    }
    return $checkedResult;
}
function safeAuthReturnPath($candidate): ?string {
    if (!is_string($candidate) || $candidate === '' || preg_match('/[\\x00-\\x1F\\\\]/', $candidate)) return null;
    $parts = parse_url($candidate);
    if ($parts === false || isset($parts['scheme']) || isset($parts['host']) || isset($parts['user']) || isset($parts['pass'])) return null;
    $path = $parts['path'] ?? '';
    if (strpos($path, '//') !== false) return null;
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    $base = rtrim($scriptDir, '/');
    if ($base !== '' && $base !== '.' && strpos($path, $base . '/') === 0) $path = substr($path, strlen($base) + 1);
    $route = trim($path, '/');
    if (strpos($route, '/') !== false || !in_array($route, ['assessment', 'results', 'course-quiz'], true)) return null;
    parse_str($parts['query'] ?? '', $query);
    $safeQuery = [];
    if ($route === 'assessment' && isset($query['retake']) && in_array($query['retake'], ['standard', 'extended'], true)) $safeQuery['retake'] = $query['retake'];
    if ($route === 'course-quiz' && isset($query['degree_id']) && ctype_digit((string)$query['degree_id']) && (int)$query['degree_id'] > 0) $safeQuery['degree_id'] = (string)(int)$query['degree_id'];
    return $route . ($safeQuery ? '?' . http_build_query($safeQuery) : '');
}

function requireLogin(?string $returnTo = null, bool $isApi = false): void {
    if (isLoggedIn()) return;
    $target = safeAuthReturnPath($returnTo) ?? 'assessment';
    $_SESSION['auth_return_to'] = $target;
    $loginUrl = 'login?return=' . rawurlencode($target);
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
    if ($isApi || strpos($requestPath, '/api/') !== false || stripos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) {
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store, private');
        echo json_encode(['success' => false, 'message' => 'Please sign in or create an account before taking an assessment.', 'redirect' => $loginUrl]);
        exit;
    }
    header('Location: ' . $loginUrl, true, 302);
    exit;
}
/**
 * Reusable function to send HTML emails with Talunton branding via Gmail SMTP.
 * Returns true on success, false on failure (logs error to storage/logs or auth/mail_errors.log).
 */
function sendMail(string $to, string $subject, string $body, string $altBody = ''): bool {
    $mail = new PHPMailer(true);
    try {
        $username = SMTP_USERNAME;
        $password = SMTP_APP_PASSWORD;

        if (empty($username) || empty($password) || $username === 'your_gmail_here@gmail.com') {
            throw new Exception('SMTP credentials not configured.');
        }

        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;
        $mail->Timeout    = 10;
        $mail->CharSet    = 'UTF-8';

        // From name: "Talunton"
        $fromEmail = !empty(SMTP_FROM_EMAIL) ? SMTP_FROM_EMAIL : $username;
        $mail->setFrom($fromEmail, 'Talunton');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = !empty($altBody) ? $altBody : strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], ["\n", "\n", "\n", "\n\n"], $body));

        $mail->send();
        return true;
    } catch (\Throwable $e) {
        $errorMsg = '[' . date('Y-m-d H:i:s') . '] Mail Error to ' . $to . ': ' . $e->getMessage() . ' | PHPMailer: ' . ($mail->ErrorInfo ?? 'None') . PHP_EOL;
        $logDir = __DIR__ . '/../storage/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }
        $logFile = is_dir($logDir) ? $logDir . '/mail.log' : __DIR__ . '/mail_errors.log';
        @file_put_contents($logFile, $errorMsg, FILE_APPEND);
        return false;
    }
}

/**
 * Send an email verification code using PHPMailer.
 * Returns array: ['success' => bool, 'error' => string]
 */
function sendVerificationEmail(string $recipientEmail, string $recipientName, string $verificationCode): array {
    $mail = new PHPMailer(true);
    try {
        $username = SMTP_USERNAME;
        $password = SMTP_APP_PASSWORD;

        // If SMTP credentials have not been configured yet by the user, return early with message
        if (empty($username) || empty($password) || $username === 'your_gmail_here@gmail.com' || $password === 'your_app_password_here') {
            return [
                'success' => false,
                'error' => 'SMTP not configured yet. Please configure your Gmail credentials.'
            ];
        }

        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;
        if (SMTP_ENCRYPTION === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port       = SMTP_PORT;
        $mail->Timeout    = 10;
        $mail->CharSet    = 'UTF-8';

        // Recipients
        $fromEmail = !empty(SMTP_FROM_EMAIL) ? SMTP_FROM_EMAIL : $username;
        $fromName  = !empty(SMTP_FROM_NAME) ? SMTP_FROM_NAME : 'Talunton';
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($recipientEmail, $recipientName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Your Talunton Cavite Verification Code: " . $verificationCode;
        
        $safeName = htmlspecialchars($recipientName, ENT_QUOTES, 'UTF-8');
        $codeDisplay = htmlspecialchars($verificationCode, ENT_QUOTES, 'UTF-8');
        
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 550px; margin: 0 auto; background-color: #fdfaf6; padding: 30px; border-radius: 12px; border: 1px solid #e5e7eb;'>
            <div style='text-align: center; margin-bottom: 24px;'>
                <h1 style='color: #0e3223; margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px;'>TALUNTON CAVITE</h1>
                <p style='color: #059669; font-size: 13px; font-weight: 700; text-transform: uppercase; margin-top: 4px; letter-spacing: 1px;'>RIASEC Career Profiling System</p>
            </div>
            <div style='background-color: #ffffff; padding: 28px; border-radius: 10px; border: 1px solid #f3f4f6;'>
                <h2 style='color: #111827; font-size: 18px; margin-top: 0;'>Hello, " . $safeName . "!</h2>
                <p style='color: #4b5563; font-size: 15px; line-height: 1.5;'>Thank you for registering. To complete your account registration and unlock your career assessment, enter this 6-digit verification code:</p>
                <div style='text-align: center; margin: 28px 0;'>
                    <div style='display: inline-block; font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #0e3223; background-color: #ecfdf5; padding: 14px 28px; border-radius: 8px; border: 2px dashed #10b981; font-family: monospace, Courier, sans-serif;'>" . $codeDisplay . "</div>
                </div>
                <p style='color: #6b7280; font-size: 13px; line-height: 1.4; margin-bottom: 0;'>This code will expire in <strong>15 minutes</strong>. If you did not request this account, you can safely ignore this email.</p>
            </div>
            <p style='text-align: center; color: #9ca3af; font-size: 12px; margin-top: 20px;'>&copy; " . date('Y') . " Talunton Cavite Guidance. All rights reserved.</p>
        </div>";

        $mail->AltBody = "Hello " . $recipientName . ",\n\nYour Talunton Cavite verification code is: " . $verificationCode . "\n\nThis code will expire in 15 minutes.\n\nThank you,\nTalunton Cavite Guidance";

        $mail->send();
        return ['success' => true, 'error' => ''];
    } catch (\Throwable $e) {
        $errorMsg = '[' . date('Y-m-d H:i:s') . '] Verification Mail Error to ' . $recipientEmail . ': ' . $e->getMessage() . ' | PHPMailer: ' . ($mail->ErrorInfo ?? 'None') . PHP_EOL;
        $logDir = __DIR__ . '/../storage/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }
        $logFile = is_dir($logDir) ? $logDir . '/mail.log' : __DIR__ . '/mail_errors.log';
        @file_put_contents($logFile, $errorMsg, FILE_APPEND);
        return ['success' => false, 'error' => $mail->ErrorInfo ?: $e->getMessage()];
    }
}
