<?php
/**
 * Admin Heartbeat Endpoint.
 * Refreshes last_activity for the logged-in admin while the tab is open,
 * preventing unexpected idle timeouts during active browsing.
 */
require_once __DIR__ . '/includes/admin_auth.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

verify_csrf();

// current_admin() and updateAdminActivity() already executed via admin_auth.php
echo json_encode([
    'success' => true,
    'timestamp' => date('Y-m-d H:i:s'),
    'admin' => $ADMIN['username'] ?: $ADMIN['full_name']
]);
exit;
