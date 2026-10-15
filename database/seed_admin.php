<?php
/**
 * Admin seeder (CLI only).
 *
 *   php database/seed_admin.php                 -> creates admin / "admin 123" if missing
 *   php database/seed_admin.php --reset         -> also resets the admin password to "admin 123"
 *
 * Applies the same schema changes as migrations/2026_10_15_admin_module.sql,
 * so you can use either this script or the .sql file.
 */
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once __DIR__ . '/../auth/config.php';

$username = 'admin';
$password = 'admin 123';
$reset    = in_array('--reset', $argv, true);

$db = getDB();

// --- Schema (idempotent) -------------------------------------------------
$db->query("ALTER TABLE users
    ADD COLUMN IF NOT EXISTS role ENUM('user','admin') NOT NULL DEFAULT 'user' AFTER user_type,
    ADD COLUMN IF NOT EXISTS username VARCHAR(50) NULL DEFAULT NULL AFTER full_name");
$db->query("CREATE UNIQUE INDEX IF NOT EXISTS uniq_users_username ON users (username)");
$db->query("CREATE INDEX IF NOT EXISTS idx_users_role ON users (role)");
$db->query("ALTER TABLE colleges ADD COLUMN IF NOT EXISTS website VARCHAR(255) NULL DEFAULT NULL AFTER profile_url");

// --- Seed ----------------------------------------------------------------
$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $db->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $username);
$stmt->execute();
$existing = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($existing) {
    if ($reset) {
        $stmt = $db->prepare("UPDATE users SET password_hash = ?, role = 'admin', is_verified = 1 WHERE id = ?");
        $stmt->bind_param('si', $hash, $existing['id']);
        $stmt->execute();
        echo "Admin password reset to the default.\n";
    } else {
        echo "Admin account already exists (id {$existing['id']}). Use --reset to reset its password.\n";
    }
} else {
    $stmt = $db->prepare("INSERT INTO users (full_name, username, email, password_hash, user_type, role, is_verified)
                          VALUES ('System Administrator', ?, 'admin@talunton.local', ?, 'professional', 'admin', 1)");
    $stmt->bind_param('ss', $username, $hash);
    $stmt->execute();
    echo "Admin account created. Username: admin  Password: admin 123\n";
}

echo "IMPORTANT: change the admin password before going live.\n";
$db->close();
