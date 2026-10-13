<?php
$c = new mysqli('localhost', 'root', '', 'riasec_db');
$res = $c->query('SELECT course_number FROM degrees WHERE course_number >= 27 ORDER BY course_number ASC');
while ($row = $res->fetch_assoc()) {
    echo $row['course_number'] . ' ';
}
echo "\n";
?>
