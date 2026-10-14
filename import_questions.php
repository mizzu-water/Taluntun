<?php
// Script to parse questions.txt and insert into riasec_db.course_questions

$conn = new mysqli("localhost", "root", "", "riasec_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("TRUNCATE TABLE course_questions");

$file_path = "questions.txt";
if (!file_exists($file_path)) {
    die("Error: questions.txt not found.\n");
}

$lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$current_course_id = null;
$current_stage = 1;
$questions = [];

$current_q = null;

// First pass: collect all questions and identification answers
foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line)) continue;

    if (preg_match('/^COURSE\s+(\d+)\s+—/', $line, $matches)) {
        $course_num = intval($matches[1]);
        $stmt = $conn->prepare("SELECT id FROM degrees WHERE course_number = ?");
        $stmt->bind_param("i", $course_num);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $current_course_id = $res->fetch_assoc()['id'];
        } else {
            // fallback, maybe search by title
            echo "Warning: Course number $course_num not found in DB.\n";
            $current_course_id = $course_num; // might fail foreign key if any
        }
        $stmt->close();
        continue;
    }

    if (preg_match('/^STAGE\s+(\d+)/', $line, $matches)) {
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
            'correct' => null,
            'type' => 'unknown',
            'ident_answer' => ''
        ];
        continue;
    }

    // Is it an option?
    if (preg_match('/^([A-D])\.\s+(.*)$/', $line, $matches)) {
        if ($current_q !== null) {
            $current_q['options'][$matches[1]] = $matches[2];
            $current_q['type'] = 'mcq';
        }
        continue;
    }

    // Is it an answer?
    if (preg_match('/^Answer:\s+(.*)$/i', $line, $matches)) {
        if ($current_q !== null) {
            if ($current_q['type'] === 'mcq') {
                $current_q['correct'] = strtoupper(trim($matches[1]));
            } else {
                $current_q['type'] = 'ident';
                $current_q['ident_answer'] = trim($matches[1]);
            }
            $questions[] = $current_q;
            $current_q = null;
        }
        continue;
    }
}
if ($current_q !== null) {
    $questions[] = $current_q;
}

echo "Parsed " . count($questions) . " questions from text.\n";

// Group identification answers by course
$ident_answers_by_course = [];
foreach ($questions as $q) {
    if ($q['type'] === 'ident') {
        $ident_answers_by_course[$q['degree_id']][] = $q['ident_answer'];
    }
}

$inserted = 0;
$stmt = $conn->prepare("INSERT INTO course_questions (degree_id, stage, question_number, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($questions as $q) {
    if ($q['type'] === 'ident') {
        // Generate A,B,C,D
        $correct_ans = $q['ident_answer'];
        $pool = $ident_answers_by_course[$q['degree_id']] ?? [];
        $pool = array_diff($pool, [$correct_ans]);
        shuffle($pool);
        $distractors = array_slice($pool, 0, 3);
        
        // If not enough distractors (e.g. less than 4 ident questions in this course)
        while(count($distractors) < 3) {
            $distractors[] = "None of the above"; // fallback
        }

        $all_options = array_merge([$correct_ans], $distractors);
        shuffle($all_options);

        $optA = $all_options[0];
        $optB = $all_options[1];
        $optC = $all_options[2];
        $optD = $all_options[3];

        $correct_letter = 'A';
        if ($optB === $correct_ans) $correct_letter = 'B';
        if ($optC === $correct_ans) $correct_letter = 'C';
        if ($optD === $correct_ans) $correct_letter = 'D';

        $q['options']['A'] = $optA;
        $q['options']['B'] = $optB;
        $q['options']['C'] = $optC;
        $q['options']['D'] = $optD;
        $q['correct'] = $correct_letter;
    }

    $stmt->bind_param("iiissssss", 
        $q['degree_id'],
        $q['stage'],
        $q['q_num'],
        $q['text'],
        $q['options']['A'],
        $q['options']['B'],
        $q['options']['C'],
        $q['options']['D'],
        $q['correct']
    );
    if ($stmt->execute()) {
        $inserted++;
    } else {
        echo "Failed to insert Q" . $q['q_num'] . " for course " . $q['degree_id'] . "\n";
    }
}

echo "Successfully inserted $inserted questions into the database.\n";
$stmt->close();
$conn->close();
?>
