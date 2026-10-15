<?php
/**
 * Admin logout (POST + CSRF only).
 * Clears current_session_id and last_activity in the database,
 * then destroys the TALUNTON_ADMIN session and cookie.
 */
require_once __DIR__ . '/includes/bootstrap.php';

startAdminSession();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}
verify_csrf();

$adminId = filter_var($_SESSION['admin_id'] ?? null, FILTER_VALIDATE_INT);
$sessId  = session_id();

// Clear the DB session lock for this admin
if ($adminId && !empty($sessId)) {
    $stmt = db()->prepare("UPDATE users SET current_session_id = NULL, last_activity = NULL WHERE id = ? AND current_session_id = ?");
    $stmt->bind_param('is', $adminId, $sessId);
    $stmt->execute();
    $stmt->close();
}

// Destroy only the admin session
destroyAdminSession();

// Start a fresh admin session just to carry the logout flash message
startAdminSession();
flash('success', 'You have been logged out.');
redirect('login.php');
