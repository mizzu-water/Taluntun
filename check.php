<?php
require 'auth/config.php';
$c = getDB()->query('SELECT short_name, address FROM colleges');
while($r = $c->fetch_assoc()) {
    echo $r['short_name'] . ' - ' . $r['address'] . "\n";
}
