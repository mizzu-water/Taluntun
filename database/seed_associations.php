<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'riasec_db';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$degrees = $conn->query("SELECT id FROM degrees")->fetch_all(MYSQLI_ASSOC);
$colleges = $conn->query("SELECT id FROM colleges")->fetch_all(MYSQLI_ASSOC);

foreach ($degrees as $d) {
    // Pick a random number of colleges to associate (1 to 4)
    $num = rand(1, 4);
    $keys = array_rand($colleges, $num);
    if (!is_array($keys)) $keys = [$keys];
    foreach ($keys as $k) {
        $c_id = $colleges[$k]['id'];
        $d_id = $d['id'];
        $conn->query("INSERT IGNORE INTO college_degrees (college_id, degree_id) VALUES ($c_id, $d_id)");
    }
}
echo "Seeded successfully!";
$conn->close();
?>
