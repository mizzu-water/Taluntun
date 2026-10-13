<?php
$file = 'c:/xampp/htdocs/riasec/brain.png';
$img = imagecreatefrompng($file);
imagealphablending($img, false);
imagesavealpha($img, true);

$width = imagesx($img);
$height = imagesy($img);

for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $rgb = imagecolorat($img, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        // Check if pixel is grey or white (R=G=B > 200)
        // A checkerboard is usually exactly #FFFFFF and #CCCCCC or similar
        // We'll consider any neutral light grey or white as transparent
        if ($r > 190 && $g > 190 && $b > 190 && abs($r - $g) < 10 && abs($g - $b) < 10) {
            $transparent = imagecolorallocatealpha($img, 255, 255, 255, 127);
            imagesetpixel($img, $x, $y, $transparent);
        }
    }
}
imagepng($img, 'c:/xampp/htdocs/riasec/brain_transparent.png');
echo "Done";
?>
