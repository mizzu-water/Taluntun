<?php
$file = 'app/Views/assessment.html';
$content = file_get_contents($file);
$content = preg_replace('/<component :is="\'style\'" v-if="assessmentStarted">\s*nav, footer \{ display: none !important; \}\s*<\/component>\s*/', '', $content);
file_put_contents($file, $content);
echo "Cleaned!";
?>
