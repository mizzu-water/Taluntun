<?php
$conn = new mysqli("localhost", "root", "", "riasec_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$file_path = "question_bank.txt";
if (!file_exists($file_path)) {
    die("Error: question_bank.txt not found.\n");
}

$lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$current_course_id = null;
$current_stage = 1;
$questions = [];
$current_q = null;

foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line)) continue;

    // e.g. "27. BS Nursing"
    if (preg_match('/^Course\s+#(\d+)/i', $line, $matches)) {
        $num = intval($matches[1]);
        if ($num >= 27 && $num <= 50) {
            $course_num = $num;
            $stmt = $conn->prepare("SELECT id FROM degrees WHERE course_number = ?");
            $stmt->bind_param("i", $course_num);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $current_course_id = $res->fetch_assoc()['id'];
            } else {
                // Course doesn't exist, use course_num but we'll print a warning
                $current_course_id = $course_num;
            }
            $stmt->close();
            continue;
        }
    }

    // e.g. "Stage 1 – Basic"
    if (preg_match('/^Stage\s+(\d+)/i', $line, $matches)) {
        $current_stage = intval($matches[1]);
        continue;
    }

    // Is it a question start?
    if (preg_match('/^(\d+)\.\s+(.*)$/', $line, $matches)) {
        if ($current_q !== null) {
            $questions[] = $current_q;
        }
        $current_q = [
            'degree_id' => $current_course_id,
            'stage' => $current_stage,
            'q_num' => intval($matches[1]),
            'text' => $matches[2],
            'options' => [],
            'correct' => null
        ];
        continue;
    }

    // Is it an option?
    if (preg_match('/^([A-D])\.\s+(.*)$/', $line, $matches)) {
        if ($current_q !== null) {
            $current_q['options'][$matches[1]] = $matches[2];
        }
        continue;
    }

    // Is it an answer?
    if (preg_match('/^(?:Correct\s+)?Answer:\s+([A-D])/i', $line, $matches)) {
        if ($current_q !== null) {
            $current_q['correct'] = strtoupper(trim($matches[1]));
            $questions[] = $current_q;
            $current_q = null;
        }
        continue;
    }
}
if ($current_q !== null && $current_q['correct'] !== null) {
    $questions[] = $current_q;
}

echo "Parsed " . count($questions) . " questions from text.\n";

$valid_questions = $questions;
echo "Valid questions: " . count($valid_questions) . "\n";

// Delete existing questions for courses >= 27 to make it idempotent
// We need to delete by joining with degrees table where course_number >= 27
$conn->query("DELETE cq FROM course_questions cq JOIN degrees d ON cq.degree_id = d.id WHERE d.course_number >= 27");

$inserted = 0;
$stmt = $conn->prepare("INSERT INTO course_questions (degree_id, stage, question_number, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($valid_questions as $q) {
    $optA = $q['options']['A'] ?? '';
    $optB = $q['options']['B'] ?? '';
    $optC = $q['options']['C'] ?? '';
    $optD = $q['options']['D'] ?? '';

    $stmt->bind_param("iiissssss", 
        $q['degree_id'],
        $q['stage'],
        $q['q_num'],
        $q['text'],
        $optA,
        $optB,
        $optC,
        $optD,
        $q['correct']
    );
    if ($stmt->execute()) {
        $inserted++;
    }
}

echo "Successfully inserted $inserted questions into the database.\n";
$stmt->close();
$conn->close();
?>
