<?php
$file = 'c:\xampp\htdocs\riasec\app\Views\colleges.html';
$content = file_get_contents($file);

$images = [
    '/riasec/assets/colleges/image1.jpeg',
    '/riasec/assets/colleges/image2.jpeg',
    '/riasec/assets/colleges/image3.png',
    '/riasec/assets/colleges/image4.jpeg',
    '/riasec/assets/colleges/image5.jpeg',
    '/riasec/assets/colleges/image6.jpeg',
    '/riasec/assets/colleges/image7.jpeg',
    '/riasec/assets/colleges/image8.jpeg',
    '/riasec/assets/colleges/image9.jpeg',
    '/riasec/assets/colleges/image10.jpeg',
    '/riasec/assets/colleges/image11.jpeg',
    '/riasec/assets/colleges/image12.jpeg'
];
$index = 0;

$newContent = preg_replace_callback('/<img\s+src="https:\/\/images\.unsplash\.com[^"]+"/i', function($matches) use (&$index, $images) {
    if ($index < 12) {
        $res = '<img src="' . $images[$index] . '"';
        $index++;
        return $res;
    }
    return $matches[0];
}, $content);

file_put_contents($file, $newContent);
echo "Replaced " . $index . " images.\n";
