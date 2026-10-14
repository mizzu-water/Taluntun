<?php
require_once 'auth/config.php';

class CourseQuizController extends Controller {
    public function authorize() {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => true, 'user_id' => (int)$_SESSION['user_id']]);
        exit;
    }

    public function index() {
        $this->view('course-quiz');
    }

    public function submit() {
        header('Content-Type: application/json; charset=utf-8');
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
            exit;
        }
        $this->validateCsrf();
        $payload = json_decode(file_get_contents('php://input'), true);
        $degreeId = filter_var($payload['degree_id'] ?? null, FILTER_VALIDATE_INT);
        $answers = $payload['answers'] ?? null;
        if (!$degreeId || $degreeId < 1 || !is_array($answers) || empty($answers)) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'A valid degree and answer set are required.']);
            exit;
        }

        $conn = getDB();

        // Grade only the questions submitted in the quiz attempt
        $questionIds = array_filter(array_map('intval', array_keys($answers)), function($id) {
            return $id > 0;
        });

        if (empty($questionIds)) {
            $conn->close();
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'No valid question IDs were submitted.']);
            exit;
        }

        $placeholders = implode(',', array_fill(0, count($questionIds), '?'));
        $types = 'i' . str_repeat('i', count($questionIds));
        $params = array_merge([$degreeId], array_values($questionIds));

        $sql = "SELECT id, stage, correct_answer FROM course_questions WHERE degree_id = ? AND id IN ($placeholders) ORDER BY stage ASC, id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $questionsData = [];
        while ($row = $result->fetch_assoc()) {
            $questionsData[(string)$row['id']] = [
                'stage' => (int)$row['stage'],
                'correct_answer' => strtoupper($row['correct_answer'])
            ];
        }
        $stmt->close();

        if (empty($questionsData)) {
            $conn->close();
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'No matching questions found for this degree.']);
            exit;
        }

        $stageDefinitions = [
            1 => 'Fundamentals & Terminology',
            2 => 'Core Academic Principles',
            3 => 'Applied Scenarios',
            4 => 'Advanced Specialization'
        ];

        $stageBreakdown = [];
        foreach ($stageDefinitions as $stgNum => $stgName) {
            $stageBreakdown[$stgNum] = [
                'stage' => $stgNum,
                'name' => $stgName,
                'score' => 0,
                'total' => 0,
                'percentage' => 0
            ];
        }

        $correct = 0;
        $incorrect = 0;
        $skipped = 0;
        $normalizedAnswers = [];

        foreach ($questionsData as $questionId => $qInfo) {
            $stageNum = $qInfo['stage'];
            if (!isset($stageBreakdown[$stageNum])) {
                $stageBreakdown[$stageNum] = [
                    'stage' => $stageNum,
                    'name' => 'Stage ' . $stageNum,
                    'score' => 0,
                    'total' => 0,
                    'percentage' => 0
                ];
            }
            $stageBreakdown[$stageNum]['total']++;

            $selected = $answers[$questionId] ?? null;
            $selected = is_string($selected) ? strtoupper(trim($selected)) : null;

            if (!in_array($selected, ['A', 'B', 'C', 'D'], true)) {
                $selected = null;
                $skipped++;
            } elseif ($selected === $qInfo['correct_answer']) {
                $correct++;
                $stageBreakdown[$stageNum]['score']++;
            } else {
                $incorrect++;
            }
            $normalizedAnswers[$questionId] = $selected;
        }

        // Calculate stage percentages
        foreach ($stageBreakdown as $stgNum => &$stgData) {
            $stgData['percentage'] = $stgData['total'] > 0 
                ? (int)round(($stgData['score'] / $stgData['total']) * 100) 
                : 0;
        }
        unset($stgData);

        $total = count($questionsData);
        $score = $correct;
        $percentage = $total > 0 ? (int)round(($score / $total) * 100) : 0;
        $answersJson = json_encode($normalizedAnswers);

        // 5-Tier Knowledge Level Evaluation
        if ($percentage >= 90) {
            $tier = 5;
            $tierTitle = "Tier 5 — Expert Mastery";
            $tierShort = "Tier 5 (Expert)";
            $tierDesc = "Outstanding command of the domain. You demonstrate comprehensive mastery across core theories, complex applications, and specialized professional standards.";
            $badgeColor = "emerald";
        } elseif ($percentage >= 75) {
            $tier = 4;
            $tierTitle = "Tier 4 — Proficient Competence";
            $tierShort = "Tier 4 (Proficient)";
            $tierDesc = "Strong working knowledge of academic and professional concepts. You show high accuracy in core principles with minor gaps in specialized problem scenarios.";
            $badgeColor = "green";
        } elseif ($percentage >= 60) {
            $tier = 3;
            $tierTitle = "Tier 3 — Intermediate Foundation";
            $tierShort = "Tier 3 (Intermediate)";
            $tierDesc = "Solid grasp of foundational subject matter. You understand key terminology and standard methods, but will benefit from reinforcing advanced applications.";
            $badgeColor = "blue";
        } elseif ($percentage >= 40) {
            $tier = 2;
            $tierTitle = "Tier 2 — Basic Familiarity";
            $tierShort = "Tier 2 (Basic)";
            $tierDesc = "Introductory awareness of the subject. You recognize basic terminology but need deeper study into core academic principles and applied problem solving.";
            $badgeColor = "amber";
        } else {
            $tier = 1;
            $tierTitle = "Tier 1 — Beginner / Exploratory";
            $tierShort = "Tier 1 (Beginner)";
            $tierDesc = "Early exploratory stage. You are just beginning your journey in this field. We recommend starting with fundamental courses and introductory resources.";
            $badgeColor = "slate";
        }

        $createSql = "CREATE TABLE IF NOT EXISTS course_quiz_attempts (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            degree_id INT NOT NULL,
            score INT NOT NULL,
            total_questions INT NOT NULL,
            correct_count INT NOT NULL,
            incorrect_count INT NOT NULL,
            skipped_count INT NOT NULL,
            answers LONGTEXT NOT NULL,
            taken_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_course_attempt_user_degree (user_id, degree_id, taken_at),
            CONSTRAINT fk_course_attempt_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            CONSTRAINT fk_course_attempt_degree FOREIGN KEY (degree_id) REFERENCES degrees(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if (!$conn->query($createSql)) {
            $conn->close();
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Could not prepare quiz result storage.']);
            exit;
        }

        $userId = (int)$_SESSION['user_id'];
        $insert = $conn->prepare('INSERT INTO course_quiz_attempts (user_id, degree_id, score, total_questions, correct_count, incorrect_count, skipped_count, answers) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $insert->bind_param('iiiiiiis', $userId, $degreeId, $score, $total, $correct, $incorrect, $skipped, $answersJson);

        if (!$insert->execute()) {
            $insert->close();
            $conn->close();
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Could not save this quiz attempt.']);
            exit;
        }

        $attemptId = $insert->insert_id;
        $insert->close();
        $conn->close();

        echo json_encode([
            'success' => true,
            'attempt_id' => $attemptId,
            'result' => [
                'score' => $score,
                'total' => $total,
                'correct' => $correct,
                'incorrect' => $incorrect,
                'skipped' => $skipped,
                'percentage' => $percentage,
                'tier' => $tier,
                'interpretation' => $tierTitle,
                'mastery' => [
                    'tier' => $tier,
                    'title' => $tierTitle,
                    'short' => $tierShort,
                    'description' => $tierDesc,
                    'badge_color' => $badgeColor
                ],
                'stage_breakdown' => array_values($stageBreakdown)
            ]
        ]);
        exit;
    }

    public function getQuestions() {
        header('Content-Type: application/json');
        if (!isset($_GET['degree_id'])) {
            echo json_encode(['success' => false, 'error' => 'No degree ID provided']);
            exit;
        }

        require_once 'auth/config.php';
        $conn = getDB();
        $degree_id = intval($_GET['degree_id']);

        // Check if degree exists
        $stmt_deg = $conn->prepare("SELECT title FROM degrees WHERE id = ?");
        $stmt_deg->bind_param("i", $degree_id);
        $stmt_deg->execute();
        $res_deg = $stmt_deg->get_result();
        if ($res_deg->num_rows == 0) {
            echo json_encode(['success' => false, 'error' => 'Degree not found']);
            $stmt_deg->close();
            $conn->close();
            exit;
        }
        $degree_title = $res_deg->fetch_assoc()['title'];
        $stmt_deg->close();

        // Quiz length limit: 15, 30, or 50 (default: 50)
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
        if (!in_array($limit, [15, 30, 50], true)) {
            $limit = 50;
        }

        // Count per stage based on limit
        // Stage 1 (Fundamentals), Stage 2 (Principles), Stage 3 (Scenarios), Stage 4 (Advanced)
        if ($limit === 15) {
            $stageCounts = [1 => 4, 2 => 4, 3 => 4, 4 => 3];
        } elseif ($limit === 30) {
            $stageCounts = [1 => 8, 2 => 8, 3 => 7, 4 => 7];
        } else {
            // 50 questions
            $stageCounts = [1 => 13, 2 => 13, 3 => 12, 4 => 12];
        }

        $questions = [];

        foreach ($stageCounts as $stageNum => $countNeeded) {
            $stmt = $conn->prepare("SELECT id, stage, question_text, option_a, option_b, option_c, option_d, correct_answer FROM course_questions WHERE degree_id = ? AND stage = ? ORDER BY RAND() LIMIT ?");
            $stmt->bind_param("iii", $degree_id, $stageNum, $countNeeded);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $questions[] = [
                    'id' => intval($row['id']),
                    'stage' => intval($row['stage']),
                    'text' => $row['question_text'],
                    'options' => [
                        'A' => $row['option_a'],
                        'B' => $row['option_b'],
                        'C' => $row['option_c'],
                        'D' => $row['option_d']
                    ],
                    'correct' => strtoupper($row['correct_answer'])
                ];
            }
            $stmt->close();
        }

        // If fewer questions were returned than requested, fallback to filling remaining
        if (count($questions) < $limit) {
            $existingIds = array_column($questions, 'id');
            $placeholders = !empty($existingIds) ? 'AND id NOT IN (' . implode(',', array_fill(0, count($existingIds), '?')) . ')' : '';
            $needed = $limit - count($questions);

            $fallbackSql = "SELECT id, stage, question_text, option_a, option_b, option_c, option_d, correct_answer FROM course_questions WHERE degree_id = ? $placeholders ORDER BY stage ASC, RAND() LIMIT ?";
            $fbStmt = $conn->prepare($fallbackSql);

            if (!empty($existingIds)) {
                $types = 'i' . str_repeat('i', count($existingIds)) . 'i';
                $params = array_merge([$degree_id], $existingIds, [$needed]);
                $fbStmt->bind_param($types, ...$params);
            } else {
                $fbStmt->bind_param('ii', $degree_id, $needed);
            }

            $fbStmt->execute();
            $res = $fbStmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $questions[] = [
                    'id' => intval($row['id']),
                    'stage' => intval($row['stage']),
                    'text' => $row['question_text'],
                    'options' => [
                        'A' => $row['option_a'],
                        'B' => $row['option_b'],
                        'C' => $row['option_c'],
                        'D' => $row['option_d']
                    ],
                    'correct' => strtoupper($row['correct_answer'])
                ];
            }
            $fbStmt->close();
        }

        $conn->close();

        if (count($questions) > 0) {
            echo json_encode([
                'success' => true,
                'degree_title' => $degree_title,
                'total_available' => 50,
                'selected_limit' => count($questions),
                'questions' => $questions
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No questions found for this course. Please try again later.']);
        }
    }
}
