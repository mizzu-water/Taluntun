<?php
$file = 'app/Controllers/AssessmentController.php';
$content = file_get_contents($file);

$new_method = "
    public function getQuestions() {
        header('Content-Type: application/json');
        require_once 'auth/config.php';
        \$conn = getDB();
        \$type = isset(\$_GET['type']) ? \$_GET['type'] : 'standard';
        \$sql = \"SELECT trait, question_text as text, is_reverse_coded FROM questions\";
        if (\$type === 'standard') {
            \$sql .= \" WHERE test_set = 'standard'\";
        }
        \$result = \$conn->query(\$sql);
        \$questions = [];
        if (\$result) {
            while (\$row = \$result->fetch_assoc()) {
                \$row['is_reverse_coded'] = (int)\$row['is_reverse_coded'];
                \$questions[] = \$row;
            }
        }
        echo json_encode(['success' => true, 'questions' => \$questions]);
        exit;
    }
}
";

$content = preg_replace('/\}\s*$/', $new_method, $content);
file_put_contents($file, $content);
echo "Patched successfully!";
?>
