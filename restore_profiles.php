<?php
$template = file_get_contents('app/Views/school-profile.html');

$profiles = [
    'cvsu-profile.html' => 'CvSU',
    'dlsu-profile.html' => 'DLSU-D',
    'eac-profile.html' => 'EAC-C',
    'ncst-profile.html' => 'NCST',
    'pcu-profile.html' => 'PCU',
    'tup-profile.html' => 'TUP'
];

foreach ($profiles as $file => $shortName) {
    // Also change `const shortName = urlParams.get('id');` if that's what it uses
    $content = str_replace(
        "const shortName = urlParams.get('id');",
        "const shortName = urlParams.get('id') || '$shortName';",
        $template
    );
    file_put_contents('app/Views/' . $file, $content);
    echo "Restored $file with default id $shortName\n";
}
