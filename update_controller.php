<?php
$file = 'app/Controllers/AssessmentController.php';
$content = file_get_contents($file);

$target = <<<PHP
        if (\$res->num_rows > 0) {
            \$college = \$res->fetch_assoc();
PHP;

$replacement = <<<PHP
        if (\$res->num_rows > 0) {
            \$college = \$res->fetch_assoc();
            if (isset(\$college['requirements']) && !empty(\$college['requirements'])) {
                \$college['requirements'] = json_decode(\$college['requirements'], true);
            }
PHP;

if (strpos($content, $target) !== false) {
    $content = str_replace($target, $replacement, $content);
    file_put_contents($file, $content);
    echo "Successfully updated AssessmentController.php\n";
} else {
    echo "Could not find target string in AssessmentController.php\n";
}
