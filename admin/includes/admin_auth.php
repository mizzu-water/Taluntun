<?php
/**
 * admin_auth.php - Authentication, session control, and concurrency management for admins.
 *
 * Enforces:
 * 1. Independent session cookie ('TALUNTON_ADMIN') separating admin from student logins.
 * 2. Single active session per admin account (rejects concurrent logins with the same account).
 * 3. Multiple different admin accounts can be logged in simultaneously.
 * 4. Configurable idle timeout with automatic lock expiration.
 */
require_once __DIR__ . '/bootstrap.php';

// Ensure the dedicated admin session is active
startAdminSession();

// Fetch currently logged in admin and verify session matching
$ADMIN = current_admin();

if (!$ADMIN) {
    destroyAdminSession();
    startAdminSession();
    redirect('login.php');
}

// Update last_activity timestamp on every authenticated request
updateAdminActivity((int)$ADMIN['id']);
