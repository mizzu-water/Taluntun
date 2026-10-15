<?php
/**
 * Admin login. Accepts a username OR email plus password.
 * Only verified accounts with role = 'admin' may sign in here.
 *
 * Concurrency rule: Single active session per admin account.
 * If the account already has an active session within the idle timeout window,
 * login is rejected with: "This admin account is already logged in somewhere else."
 */
require_once __DIR__ . '/includes/bootstrap.php';

startAdminSession();

// Already signed in as a valid admin? Go straight to the dashboard.
if (current_admin() !== null) {
    redirect('index.php');
}

const MAX_ATTEMPTS = 5;
const LOCKOUT_SECONDS = 60;

$error = '';
$login = '';

// Simple per-session throttle against password guessing.
$attempts  = $_SESSION['admin_login_attempts'] ?? 0;
$lockUntil = $_SESSION['admin_login_lock_until'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $login    = post_str('login', 191);
    $password = $_POST['password'] ?? '';

    if ($lockUntil > time()) {
        $error = 'Too many failed attempts. Please wait ' . ($lockUntil - time()) . ' seconds.';
    } elseif ($login === '' || !is_string($password) || $password === '') {
        $error = 'Enter your username and password.';
    } else {
        // Query admin user by username or email
        $stmt = db()->prepare('SELECT id, full_name, username, email, password_hash, user_type, role, is_verified,
                                      current_session_id, last_activity,
                                      TIMESTAMPDIFF(SECOND, last_activity, NOW()) AS idle_seconds
                               FROM users WHERE (username = ? OR email = ?) AND role = "admin" LIMIT 1');
        $stmt->bind_param('ss', $login, $login);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $ok = $user && password_verify($password, $user['password_hash']);

        if ($ok && (int)$user['is_verified'] === 1) {
            $userId = (int)$user['id'];
            $idleSecs = $user['idle_seconds'] !== null ? (int)$user['idle_seconds'] : null;
            $hasActiveSession = !empty($user['current_session_id']) && ($idleSecs === null || $idleSecs <= ADMIN_IDLE_TIMEOUT_SECONDS);

            // Rule 2: If already logged in within the allowed idle window, reject the login!
            if ($hasActiveSession) {
                $error = 'This admin account is already logged in somewhere else.';
            } else {
                // Allowed! Start fresh session ID and atomically update DB
                session_regenerate_id(true);
                $newSessionId = session_id();
                $clientIp = $_SERVER['REMOTE_ADDR'] ?? '';

                // Atomic conditional update to guard against race conditions
                db()->begin_transaction();
                try {
                    $upd = db()->prepare("UPDATE users 
                                          SET current_session_id = ?, last_activity = NOW(), last_login_ip = ?
                                          WHERE id = ? 
                                            AND (current_session_id IS NULL OR last_activity IS NULL OR TIMESTAMPDIFF(SECOND, last_activity, NOW()) > ?)");
                    $timeoutSecs = ADMIN_IDLE_TIMEOUT_SECONDS;
                    $upd->bind_param('ssii', $newSessionId, $clientIp, $userId, $timeoutSecs);
                    $upd->execute();
                    $affected = $upd->affected_rows;
                    $upd->close();

                    if ($affected > 0) {
                        db()->commit();

                        unset($_SESSION['admin_login_attempts'], $_SESSION['admin_login_lock_until']);

                        // Set independent admin session variables
                        $_SESSION['admin_id']   = $userId;
                        $_SESSION['full_name']  = $user['full_name'];
                        $_SESSION['email']      = $user['email'];
                        $_SESSION['role']       = 'admin';
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                        // Upgrade the hash transparently if PHP's default cost changes
                        if (password_needs_rehash($user['password_hash'], PASSWORD_BCRYPT)) {
                            $newHash = password_hash($password, PASSWORD_BCRYPT);
                            $updHash = db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
                            $updHash->bind_param('si', $newHash, $userId);
                            $updHash->execute();
                            $updHash->close();
                        }

                        flash('success', 'Welcome back, ' . $user['full_name'] . '.');
                        redirect('index.php');
                    } else {
                        db()->rollback();
                        $error = 'This admin account is already logged in somewhere else.';
                    }
                } catch (Throwable $ex) {
                    db()->rollback();
                    $error = 'An error occurred while logging in. Please try again.';
                }
            }
        } else {
            // Same generic message for wrong credentials or non-admin
            $error = 'Invalid credentials or the account is not an administrator.';
            $attempts++;
            $_SESSION['admin_login_attempts'] = $attempts;
            if ($attempts >= MAX_ATTEMPTS) {
                $_SESSION['admin_login_lock_until'] = time() + LOCKOUT_SECONDS;
                $_SESSION['admin_login_attempts'] = 0;
            }
        }
    }
}
$flashes = take_flashes();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login &middot; Talunton</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/admin.css?v=<?= filemtime(__DIR__ . '/assets/admin.css') ?>">
</head>
<body>
<div class="login-wrap">
    <form class="login-card" method="post" action="login.php" autocomplete="off">
        <span class="brand-name">Talunton</span>
        <span class="brand-sub">Admin Panel</span>

        <?php foreach ($flashes as $f): ?>
            <div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div>
        <?php endforeach; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <?= csrf_field() ?>
        <div class="field">
            <label for="login">Username or email</label>
            <input id="login" name="login" type="text" value="<?= e($login) ?>" required autofocus autocomplete="username">
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
        </div>
        <button class="btn btn-primary" type="submit">Sign in</button>
        <p class="muted" style="text-align:center;margin-top:18px">
            <a href="<?= e(app_base()) ?>/">&larr; Back to Talunton</a>
        </p>
    </form>
</div>
</body>
</html>
