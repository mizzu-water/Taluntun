<?php
$file = 'c:\xampp\htdocs\riasec\app\Views\course-quiz.html';
$content = file_get_contents($file);
$content = str_replace('localStorage.getItem("degreeQuizHistory_" + id);', 'localStorage.getItem("degreeQuizHistory_" + id);', $content);
$content = str_replace('localStorage.getItem("degreeQuizLatestResult_" + id);', 'localStorage.getItem("degreeQuizLatestResult_" + id);', $content);
$content = str_replace('localStorage.getItem("degreeQuizShuffles_" + id);', 'localStorage.getItem("degreeQuizShuffles_" + id);', $content);
$content = str_replace('localStorage.getItem("degreeQuizAnswers_" + id);', 'localStorage.getItem("degreeQuizAnswers_" + id);', $content);
$content = str_replace('localStorage.getItem("degreeQuizPreference_" + id);', 'localStorage.getItem("degreeQuizPreference_" + id);', $content);

$content = str_replace('localStorage.setItem("degreeQuizLatestResult_" + degreeId.value', 'localStorage.setItem("degreeQuizLatestResult_" + degreeId.value', $content);
$content = str_replace('localStorage.setItem("degreeQuizHistory_" + degreeId.value', 'localStorage.setItem("degreeQuizHistory_" + degreeId.value', $content);
$content = str_replace('localStorage.setItem("degreeQuizAnswers_" + degreeId.value', 'localStorage.setItem("degreeQuizAnswers_" + degreeId.value', $content);
$content = str_replace('localStorage.setItem("degreeQuizShuffles_" + degreeId.value', 'localStorage.setItem("degreeQuizShuffles_" + degreeId.value', $content);
$content = str_replace('localStorage.setItem("degreeQuizPreference_" + degreeId.value', 'localStorage.setItem("degreeQuizPreference_" + degreeId.value', $content);

$content = preg_replace('/const res = await fetch\(.*?pi\/get_course_questions\?degree_id=\);/', 'const res = await fetch("api/get_course_questions?degree_id=" + id);', $content);

file_put_contents($file, $content);
echo "Fixed syntax.\n";
