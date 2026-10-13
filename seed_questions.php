<?php
$conn = new mysqli('localhost', 'root', '', 'riasec_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure unique constraint exists

$lines = file('c:/xampp/htdocs/riasec/question_bank.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$current_degree_id = null;
$current_stage = null;
$current_question = null;
$current_course_num = null;
$current_degree_name = null;

$failed_degrees = [];

function save_question($conn, $deg_id, $stage, $q) {
    if (!$deg_id || !$stage || !$q || !isset($q['num'], $q['text'], $q['A'], $q['B'], $q['C'], $q['D'], $q['ans'])) {
        return;
    }
    $stmt = $conn->prepare("INSERT INTO course_questions (degree_id, stage, question_number, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE question_text=VALUES(question_text), option_a=VALUES(option_a), option_b=VALUES(option_b), option_c=VALUES(option_c), option_d=VALUES(option_d), correct_answer=VALUES(correct_answer)");
    $stmt->bind_param("iiissssss", $deg_id, $stage, $q['num'], $q['text'], $q['A'], $q['B'], $q['C'], $q['D'], $q['ans']);
    $stmt->execute();
}

for ($i = 0; $i < count($lines); $i++) {
    $line = trim($lines[$i]);
    
    // Check if it's a Degree Header by looking ahead for "Core coverage:"
    if (preg_match('/^(\d+)\.\s+(.*)$/', $line, $matches)) {
        $is_degree = false;
        if (isset($lines[$i+1]) && strpos(trim($lines[$i+1]), 'Core coverage:') === 0) {
            $is_degree = true;
        }
        
        if ($is_degree) {
            if ($current_question) save_question($conn, $current_degree_id, $current_stage, $current_question);
            $current_question = null;
            
            $current_course_num = intval($matches[1]);
            $current_degree_name = trim($matches[2]);
            
            $stmt = $conn->prepare("SELECT id FROM degrees WHERE title = ?");
            $stmt->bind_param("s", $current_degree_name);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $current_degree_id = $row['id'];
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $current_degree_name)));
                $up_stmt = $conn->prepare("UPDATE degrees SET course_number = ?, slug = ? WHERE id = ?");
                $up_stmt->bind_param("isi", $current_course_num, $slug, $current_degree_id);
                $up_stmt->execute();
            } else {
                $current_degree_id = null;
                $failed_degrees[] = "Could not find degree: $current_degree_name";
            }
            continue;
        }
    }
    
    if (!$current_degree_id) continue;
    
    if (strpos($line, 'Core coverage:') === 0) {
        $coverage = trim(substr($line, strlen('Core coverage:')));
        $up_stmt = $conn->prepare("UPDATE degrees SET core_coverage = ? WHERE id = ?");
        $up_stmt->bind_param("si", $coverage, $current_degree_id);
        $up_stmt->execute();
        continue;
    }
    
    if (preg_match('/^Stage (\d+)/', $line, $matches)) {
        if ($current_question) save_question($conn, $current_degree_id, $current_stage, $current_question);
        $current_question = null;
        $current_stage = intval($matches[1]);
        continue;
    }
    
    if (in_array(strtolower($line), [
        'recall, identification, definitions, and foundational concepts.',
        'application of concepts to practical situations and routine professional decisions.',
        'case-based reasoning, problem solving, comparison, evaluation, and professional judgment.'
    ])) {
        continue;
    }
    
    // Parse Question Start
    if (preg_match('/^(\d+)\.\s+(.*)$/', $line, $matches)) {
        if ($current_question) save_question($conn, $current_degree_id, $current_stage, $current_question);
        
        $current_question = [
            'num' => intval($matches[1]),
            'text' => trim($matches[2])
        ];
        continue;
    }
    
    // Parse Options
    if (preg_match('/^([A-D])\.\s+(.*)$/', $line, $matches)) {
        if ($current_question) {
            $current_question[$matches[1]] = trim($matches[2]);
        }
        continue;
    }
    
    // Parse Answer
    if (preg_match('/^Correct Answer:\s*([A-D])$/', $line, $matches)) {
        if ($current_question) {
            $current_question['ans'] = $matches[1];
            save_question($conn, $current_degree_id, $current_stage, $current_question);
            $current_question = null; // Reset for next
        }
        continue;
    }
}
if ($current_question) save_question($conn, $current_degree_id, $current_stage, $current_question);

$res = $conn->query("SELECT degree_id, d.title, COUNT(*) as cnt FROM course_questions q JOIN degrees d ON d.id = q.degree_id WHERE degree_id >= 27 AND degree_id <= 50 GROUP BY degree_id");
while ($row = $res->fetch_assoc()) {
    if ($row['cnt'] != 50) {
        $failed_degrees[] = "Degree {$row['title']} (ID {$row['degree_id']}) has {$row['cnt']} questions, expected 50";
    }
}

echo "Seeding completed.\n";
if (!empty($failed_degrees)) {
    echo "Failures/Warnings:\n";
    print_r($failed_degrees);
} else {
    echo "All expected degrees validated correctly.\n";
}
