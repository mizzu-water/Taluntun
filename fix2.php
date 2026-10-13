<?php $c = file_get_contents("app/Controllers/AssessmentController.php"); $c = substr($c, 0, strpos($c, "GET[\'id\'")); file_put_contents("app/Controllers/AssessmentController.php", $c);
