<?php
/**
 * Admin bootstrap: shared by every file in /admin.
 * Loads the main app config (DB, timezone, session settings) and defines
 * helpers for admin session lifecycle, CSRF, flash messages, and concurrency.
 */
require_once __DIR__ . '/../../auth/config.php';

const ADMIN_SESSION_NAME = 'TALUNTON_ADMIN';
const ADMIN_IDLE_TIMEOUT_SECONDS = 900; // 15 minutes idle expiration

// Admin pages must never be cached by the browser/proxies.
header('Cache-Control: no-store, private, max-age=0');
header('Pragma: no-cache');
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');

/** Start or switch to the dedicated admin session */
function startAdminSession(): void {
    if (session_status() === PHP_SESSION_ACTIVE) {
        if (session_name() === ADMIN_SESSION_NAME) {
            return;
        }
        session_write_close();
    }
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    session_name(ADMIN_SESSION_NAME);
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

/** Destroy admin session and clear its cookie */
function destroyAdminSession(): void {
    startAdminSession();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(ADMIN_SESSION_NAME, '', time() - 42000, $p['path'], $p['domain'] ?? '', $p['secure'], $p['httponly']);
    }
    session_destroy();
}

/** Shared DB connection for the request. */
function db(): mysqli {
    static $conn = null;
    if ($conn === null) $conn = getDB();
    return $conn;
}

/** Escape any value for HTML output. */
function e($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

/* ---------------- Concurrency & Auth Verification ---------------- */

/**
 * Validate that the current session belongs to an active, verified admin
 * whose current_session_id matches this session and whose last activity is not timed out.
 */
function current_admin(): ?array {
    static $cachedAdmin = false;
    if ($cachedAdmin !== false) return $cachedAdmin;

    $cachedAdmin = null;
    startAdminSession();

    $adminId = filter_var($_SESSION['admin_id'] ?? null, FILTER_VALIDATE_INT);
    if (!$adminId) return null;

    $currentSessId = session_id();
    if (empty($currentSessId)) return null;

    // Check DB: role, verified status, current_session_id match, and idle timeout
    $stmt = db()->prepare("SELECT id, full_name, username, email, role, current_session_id, last_activity,
                                  TIMESTAMPDIFF(SECOND, last_activity, NOW()) AS idle_seconds
                           FROM users
                           WHERE id = ? AND role = 'admin' AND is_verified = 1 LIMIT 1");
    $stmt->bind_param('i', $adminId);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$admin) {
        return null;
    }

    // Single active session check: must match current session ID
    if ($admin['current_session_id'] !== $currentSessId) {
        return null;
    }

    // Idle timeout check
    if ($admin['last_activity'] !== null && (int)$admin['idle_seconds'] > ADMIN_IDLE_TIMEOUT_SECONDS) {
        // Session expired due to inactivity -> unlock DB record
        $stmt_expire = db()->prepare("UPDATE users SET current_session_id = NULL, last_activity = NULL WHERE id = ? AND current_session_id = ?");
        $stmt_expire->bind_param('is', $adminId, $currentSessId);
        $stmt_expire->execute();
        $stmt_expire->close();
        return null;
    }

    $cachedAdmin = $admin;
    return $cachedAdmin;
}

/** Update last_activity to current timestamp */
function updateAdminActivity(int $adminId): void {
    $sessId = session_id();
    if (empty($sessId)) return;
    $stmt = db()->prepare("UPDATE users SET last_activity = NOW() WHERE id = ? AND current_session_id = ?");
    $stmt->bind_param('is', $adminId, $sessId);
    $stmt->execute();
    $stmt->close();
}

/* ---------------- CSRF ---------------- */

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Hidden input to drop inside every admin <form method="post">. */
function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/** Abort the request if the posted CSRF token is missing or wrong. */
function verify_csrf(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || $token === '' || !hash_equals(csrf_token(), $token)) {
        http_response_code(403);
        exit('Invalid or expired form token. Go back, refresh the page and try again.');
    }
}

/* ---------------- Flash + redirect ---------------- */

function flash(string $type, string $message): void {
    $_SESSION['admin_flash'][] = ['type' => $type, 'message' => $message];
}

function take_flashes(): array {
    $items = $_SESSION['admin_flash'] ?? [];
    unset($_SESSION['admin_flash']);
    return $items;
}

/** Redirect to a path relative to /admin (e.g. 'users.php?page=2'). */
function redirect(string $path): void {
    header('Location: ' . $path, true, 303);
    exit;
}

/** Web path of the app root, e.g. "/riasec" (no trailing slash). */
function app_base(): string {
    $dir = str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME'] ?? '/admin/index.php')));
    return rtrim($dir, '/');
}

/** Read a trimmed string from POST. */
function post_str(string $key, int $maxLen = 0): string {
    $v = $_POST[$key] ?? '';
    $v = is_string($v) ? trim($v) : '';
    return $maxLen > 0 ? mb_substr($v, 0, $maxLen) : $v;
}

/** Build a query string from the current GET params with overrides. */
function query_with(array $overrides): string {
    $q = array_merge($_GET, $overrides);
    $q = array_filter($q, fn($v) => $v !== null && $v !== '');
    return $q ? '?' . http_build_query($q) : '';
}

/** Render simple pagination links. */
function render_pagination(int $page, int $totalPages): string {
    if ($totalPages <= 1) return '';
    $html = '<nav class="pagination">';
    $html .= $page > 1
        ? '<a href="' . e(query_with(['page' => $page - 1])) . '">&laquo; Prev</a>'
        : '<span class="disabled">&laquo; Prev</span>';
    $start = max(1, $page - 2);
    $end   = min($totalPages, $page + 2);
    for ($i = $start; $i <= $end; $i++) {
        $html .= $i === $page
            ? '<span class="current">' . $i . '</span>'
            : '<a href="' . e(query_with(['page' => $i])) . '">' . $i . '</a>';
    }
    $html .= $page < $totalPages
        ? '<a href="' . e(query_with(['page' => $page + 1])) . '">Next &raquo;</a>'
        : '<span class="disabled">Next &raquo;</span>';
    return $html . '</nav>';
}

const RIASEC_TRAITS = [
    'R' => 'Realistic',
    'I' => 'Investigative',
    'A' => 'Artistic',
    'S' => 'Social',
    'E' => 'Enterprising',
    'C' => 'Conventional',
];

const QUIZ_STAGES = [
    1 => 'Stage 1 - Basic',
    2 => 'Stage 2 - Understanding',
    3 => 'Stage 3 - Deep Analysis',
];
