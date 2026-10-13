<?php

$profiles = [
    'cvsu-profile.html',
    'dlsu-profile.html',
    'eac-profile.html',
    'ncst-profile.html',
    'pcu-profile.html',
    'tup-profile.html',
    'school-profile.html'
];

foreach ($profiles as $file) {
    $path = __DIR__ . '/app/Views/' . $file;
    if (!file_exists($path)) continue;
    $content = file_get_contents($path);
    
    // We want to replace the flex container holding the title, badge, and button.
    // The easiest way is a regex that matches from <div class="flex flex-col sm:flex-row... down to Download Checklist PDF... </button>\n                  </div>
    
    $pattern = '/<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">\s*<div class="flex items-center gap-3">\s*<h2 class="text-2xl font-bold text-gray-900 font-serif-heading">Admission Requirements & Process<\/h2>\s*<span[^>]*>AY 2025–2026<\/span>\s*<\/div>\s*<button[^>]*>.*?Download Checklist PDF\s*<\/button>\s*<\/div>/is';
    
    $replacement = '<h2 class="text-2xl font-bold text-gray-900 mb-6 font-serif-heading">Admission Requirements & Process</h2>';
    
    $content = preg_replace($pattern, $replacement, $content);
    
    file_put_contents($path, $content);
    echo "Removed elements from $file\n";
}
