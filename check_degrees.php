<?php
$c = new mysqli('localhost', 'root', '', 'riasec_db');
$r = $c->query('SELECT id, title, course_number FROM degrees');
while($row = $r->fetch_assoc()) {
    print_r($row);
}
?>
