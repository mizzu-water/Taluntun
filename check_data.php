<?php
$c = new mysqli('localhost', 'root', '', 'riasec_db');
echo "MCQ Question:\n";
$r = $c->query("SELECT * FROM course_questions WHERE option_a != '' AND option_b != '' LIMIT 1");
print_r($r->fetch_assoc());
echo "\nIdent Question (randomized A/B/C/D):\n";
$r = $c->query("SELECT * FROM course_questions WHERE option_d != '' ORDER BY id DESC LIMIT 1");
print_r($r->fetch_assoc());
?>
