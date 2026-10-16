<?php
$content = file_get_contents('app/Controllers/AssessmentController.php');

$patch = <<<'PHP'
        if ($result && $result->num_rows > 0) {
            $map = json_decode(file_get_contents('image_map.json'), true);
            while ($row = $result->fetch_assoc()) {
                $img = 'assets/images/placeholder.jpg';
                if($map) {
                    foreach ($map as $k => $v) {
                        if (stripos($row['title'], $k) !== false) {
                            $img = '/riasec/' . $v;
                            break;
                        }
                    }
                }
                $row['image_url'] = $img;
                $degrees[] = $row;
            }
        }
PHP;

$content = str_replace(
    <<<'PHP'
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $degrees[] = $row;
            }
        }
PHP,
    $patch,
    $content
);

$patch2 = <<<'PHP'
        if ($result->num_rows > 0) {
            $degree = $result->fetch_assoc();
            $map = json_decode(file_get_contents('image_map.json'), true);
            $img = 'assets/images/placeholder.jpg';
            if($map) {
                foreach ($map as $k => $v) {
                    if (stripos($degree['title'], $k) !== false) {
                        $img = '/riasec/' . $v;
                        break;
                    }
                }
            }
            $degree['image_url'] = $img;
PHP;

$content = str_replace(
    <<<'PHP'
        if ($result->num_rows > 0) {
            $degree = $result->fetch_assoc();
PHP,
    $patch2,
    $content
);

file_put_contents('app/Controllers/AssessmentController.php', $content);
echo "Patched.\n";
