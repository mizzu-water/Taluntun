<?php
$conn = new mysqli("localhost", "root", "", "riasec_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "course_questions schema:\n";
$result = $conn->query("DESCRIBE course_questions");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
echo "\ndegrees schema:\n";
$result = $conn->query("DESCRIBE degrees");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
$conn->close();
?>
