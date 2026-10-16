<?php require 'auth/config.php'; $c=getDB(); $r=$c->query('SELECT id, title FROM degrees'); while($row=$r->fetch_assoc()){ echo $row['id'] . ': ' . $row['title'] . PHP_EOL; } 
