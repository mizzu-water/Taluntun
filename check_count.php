<?php
$c = new mysqli('localhost', 'root', '', 'riasec_db');
$r = $c->query('SELECT degree_id, count(*) as count FROM course_questions GROUP BY degree_id');
while($row = $r->fetch_assoc()) {
    echo $row['degree_id'] . ": " . $row['count'] . "\n";
}
?>
