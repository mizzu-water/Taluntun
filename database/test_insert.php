<?php
$c = new mysqli('localhost', 'root', '', 'riasec_db');
if ($c->connect_error) die("Conn fail");
$c->query("INSERT INTO course_questions (degree_id, stage, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (1, 4, 'Test Q4', 'A', 'B', 'C', 'D', 'A'), (1, 5, 'Test Q5', 'A', 'B', 'C', 'D', 'B')");
echo "Done";
