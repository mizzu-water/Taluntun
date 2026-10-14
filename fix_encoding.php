<?php
function fix_file($path) {
    $content = file_get_contents($path);
    $original = $content;
    
    // Fix Dasmariñas
    $content = preg_replace('/Dasmari[\\x{FFFD}\?]as/u', 'Dasmariñas', $content);
    // Also catch any non-utf8 corrupted bytes like \xE2\x80\x93 etc if they got turned into ?
    // But safely just fix Dasmarias and Dasmari?as
    $content = str_replace("Dasmari?as", "Dasmariñas", $content);
    $content = str_replace(urldecode("Dasmari%EF%BF%BDas"), "Dasmariñas", $content);

    // Some places have 'magic?it\'s'
    $content = str_replace("magic?it's", "magic - it's", $content);
    
    // "Dasmarias-both" -> "Dasmariñas - both" 
    // It's covered by Dasmariñas replacement above, leaving "Dasmariñas-both" which is fine.

    if ($original !== $content) {
        file_put_contents($path, $content);
        echo "Fixed: $path\n";
    }
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app/Views'));
foreach ($iterator as $file) {
    if ($file->isFile() && in_array($file->getExtension(), ['html', 'php'])) {
        fix_file($file->getPathname());
    }
}
echo "Complete.\n";
