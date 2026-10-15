<?php
/**
 * student_auth.php - Authentication and session handling for students / standard users.
 *
 * Uses a dedicated session name ('TALUNTON_STUDENT') so that student logins
 * never collide with or log out an active administrator session in the same browser.
 */
require_once __DIR__ . '/config.php';

const STUDENT_SESSION_NAME = 'TALUNTON_STUDENT';

function startStudentSession(): void {
    if (session_status() === PHP_SESSION_ACTIVE) {
        if (session_name() === STUDENT_SESSION_NAME) {
            return;
        }
        // If a different session is active, write and close it before switching
        session_write_close();
    }
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    session_name(STUDENT_SESSION_NAME);
    $secure = (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') || (($_SERVER['SERVER_PORT'] ?? null) == 443);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

/** Check whether a student / user is logged in */
function isStudentLoggedIn(): bool {
    startStudentSession();
    $userId = filter_var($_SESSION['student_id'] ?? ($_SESSION['user_id'] ?? null), FILTER_VALIDATE_INT);
    if (!$userId || $userId < 1) return false;

    // Normalizing student_id
    if (!isset($_SESSION['student_id']) && isset($_SESSION['user_id'])) {
        $_SESSION['student_id'] = $_SESSION['user_id'];
    }

    try {
        $conn = getDB();
        $stmt = $conn->prepare('SELECT is_verified FROM users WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->bind_result($isVerified);
        $valid = $stmt->fetch() && (bool)$isVerified;
        $stmt->close();
        $conn->close();
    } catch (Throwable $error) {
        $valid = false;
    }

    if (!$valid) {
        unset($_SESSION['student_id'], $_SESSION['user_id'], $_SESSION['full_name'], $_SESSION['email'], $_SESSION['user_type'], $_SESSION['role']);
    }
    return $valid;
}

/** Guard for protected student routes */
function requireStudentLogin(?string $returnTo = null, bool $isApi = false): void {
    if (isStudentLoggedIn()) return;
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
