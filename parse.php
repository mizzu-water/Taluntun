<?php
$map = [];
foreach (['ext1', 'ext2', 'ext3'] as $dir) {
    if (!file_exists("$dir/word/document.xml")) continue;
    $content = file_get_contents("$dir/word/document.xml");
    preg_match_all('/<w:t>([^<]+)<\/w:t>.*?name="(image\d+\.(?:png|jpg|jpeg))"/is', $content, $matches);
    for ($i=0; $i<count($matches[1]); $i++) {
        $title = trim($matches[1][$i]);
        $img = $matches[2][$i];
        if (!empty($title)) {
            $map[$title] = $img;
        }
    }
}
file_put_contents("image_map.json", json_encode($map, JSON_PRETTY_PRINT));
echo "Map created.\n";
