<?php require 'auth/config.php'; $c = getDB(); $r = $c->query('SELECT * FROM degrees LIMIT 1'); print_r($r->fetch_assoc()); ?>
