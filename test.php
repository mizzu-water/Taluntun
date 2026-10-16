<?php
$html = file_get_contents("app/Views/course-quiz.html");
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
foreach(libxml_get_errors() as $error) {
    echo $error->line . ": " . $error->message . "\n";
}
