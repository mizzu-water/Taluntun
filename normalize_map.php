<?php
$mapFile = 'image_map.json';
$map = file_exists($mapFile) ? json_decode(file_get_contents($mapFile), true) : [];

require_once 'auth/config.php';
$conn = getDB();
$degrees = [];
$result = $conn->query("SELECT id, title FROM degrees");
if ($result) {
    while($row = $result->fetch_assoc()){
        $degrees[] = $row;
    }
}
$conn->close();

$newMap = [];
foreach ($degrees as $deg) {
    $dbTitle = $deg['title'];
    $matchedImg = '';
    if($map) {
        foreach ($map as $k => $v) {
            if (stripos($dbTitle, $k) !== false) {
                $matchedImg = $v;
                break;
            }
        }
    }
    if ($matchedImg) {
        $newMap[$dbTitle] = $matchedImg;
    }
}

file_put_contents($mapFile, json_encode($newMap, JSON_PRETTY_PRINT));
echo "Map normalized.";

