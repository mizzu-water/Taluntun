<?php
$file = 'c:\xampp\htdocs\riasec\app\Views\course-quiz.html';
$content = file_get_contents($file);
$content = str_replace('\"degreeQuizHistory_\"', '"degreeQuizHistory_"', $content);
$content = str_replace('\"degreeQuizLatestResult_\"', '"degreeQuizLatestResult_"', $content);
$content = str_replace('\"degreeQuizShuffles_\"', '"degreeQuizShuffles_"', $content);
$content = str_replace('\"degreeQuizAnswers_\"', '"degreeQuizAnswers_"', $content);
$content = str_replace('\"degreeQuizPreference_\"', '"degreeQuizPreference_"', $content);

file_put_contents($file, $content);
echo "Fixed backticks.\n";
