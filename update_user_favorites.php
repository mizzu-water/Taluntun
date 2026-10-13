<?php
require_once 'auth/config.php';
$db = getDB();

$res = $db->query("SHOW COLUMNS FROM users LIKE 'favorite_subjects'");
if ($res->num_rows == 0) {
    $db->query("ALTER TABLE users ADD COLUMN favorite_subjects TEXT NULL");
    echo "Added favorite_subjects column.\n";
} else {
    echo "Column already exists.\n";
}
