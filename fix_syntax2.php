<?php
$file = 'c:\xampp\htdocs\riasec\app\Views\course-quiz.html';
$content = file_get_contents($file);

// Replace any messy combinations of quotes and backticks with just double quotes
$content = preg_replace('/localStorage\.getItem\([\'"]+(degreeQuiz[a-zA-Z_]+)[\'"]+\s*\+\s*id\);/', 'localStorage.getItem("" + id);', $content);
$content = preg_replace('/localStorage\.setItem\([\'"]+(degreeQuiz[a-zA-Z_]+)[\'"]+\s*\+\s*degreeId\.value/', 'localStorage.setItem("" + degreeId.value', $content);

file_put_contents($file, $content);
echo "Cleaned up quotes.\n";
