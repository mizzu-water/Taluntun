<?php
$file = 'app/Controllers/AssessmentController.php';
$content = file_get_contents($file);

$old_sql_block = "\$sql = \"SELECT trait, question_text as text, is_reverse_coded FROM questions\";
        if (\$type === 'standard') {
            \$sql .= \" WHERE test_set = 'standard'\";
        }";

$new_sql_block = "\$sql = \"SELECT trait, question_text as text, is_reverse_coded FROM questions\";
        if (\$type === 'standard') {
            \$sql .= \" WHERE test_set = 'standard'\";
        }
        \$sql .= \" ORDER BY FIELD(trait, 'R', 'I', 'A', 'S', 'E', 'C'), id ASC\";";

$content = str_replace($old_sql_block, $new_sql_block, $content);
file_put_contents($file, $content);
echo "SQL Query updated for Chapters!";
?>
