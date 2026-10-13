<?php
$content = file_get_contents('php://input');
file_put_contents('frontend_dom.log', $content);
