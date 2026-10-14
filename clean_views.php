<?php
$views_dir = 'C:/xampp/htdocs/riasec/app/Views';
$processed = 0;
$skipped = [];

foreach (glob($views_dir . '/*.html') as $filepath) {
    if (basename($filepath) === 'home.html') continue;

    $content = file_get_contents($filepath);
    
    // Check if already processed
    if (stripos($content, '<html') === false) continue;
    
    if (preg_match('/<main[^>]*>(.*?)<\/main>/is', $content, $matches)) {
        $main_content = trim($matches[1]);
        file_put_contents($filepath, $main_content);
        $processed++;
    } else {
        $skipped[] = basename($filepath);
    }
}

echo "Processed: $processed\n";
if (!empty($skipped)) {
    echo "Skipped (no <main> tag): " . implode(', ', $skipped) . "\n";
}
?>
