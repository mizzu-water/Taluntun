<?php
$file = 'app/Views/assessment.html';
$content = file_get_contents($file);

// Replace exactly the broken line
$content = str_replace('const res = await fetch( pi/get_questions?type=${type});', "const res = await fetch('api/get_questions?type=' + type);", $content);

file_put_contents($file, $content);
echo "Fixed exactly!";
?>
