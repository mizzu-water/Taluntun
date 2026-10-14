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
        if (!$degreeId || $degreeId < 1 || !is_array($answers)) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'A valid degree and answer set are required.']);
            exit;
        }

        $conn = getDB();
        $stmt = $conn->prepare('SELECT id, correct_answer FROM course_questions WHERE degree_id = ? ORDER BY stage ASC, id ASC');
        $stmt->bind_param('i', $degreeId);
        $stmt->execute();
        $result = $stmt->get_result();
        $correctById = [];
        while ($row = $result->fetch_assoc()) $correctById[(string)$row['id']] = strtoupper($row['correct_answer']);
        $stmt->close();
        if (!$correctById) {
            $conn->close();
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'No quiz questions were found for this degree.']);
            exit;
        }

        $correct = 0;
        $incorrect = 0;
        $skipped = 0;
        $normalizedAnswers = [];
        foreach ($correctById as $questionId => $correctAnswer) {
            $selected = $answers[$questionId] ?? null;
            $selected = is_string($selected) ? strtoupper($selected) : null;
            if (!in_array($selected, ['A', 'B', 'C', 'D'], true)) {
                $selected = null;
                $skipped++;
            } elseif ($selected === $correctAnswer) {
                $correct++;
            } else {
                $incorrect++;
            }
            $normalizedAnswers[$questionId] = $selected;
        }
        $total = count($correctById);
        $score = $correct;
        $answersJson = json_encode($normalizedAnswers);

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
        echo json_encode(['success' => true, 'attempt_id' => $attemptId, 'result' => [
            'score' => $score, 'total' => $total, 'correct' => $correct,
            'incorrect' => $incorrect, 'skipped' => $skipped,
            'percentage' => (int)round(($score / $total) * 100)
        ]]);
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

        // Fetch questions
        $stmt = $conn->prepare("SELECT id, stage, question_text, option_a, option_b, option_c, option_d, correct_answer FROM course_questions WHERE degree_id = ? ORDER BY stage ASC, RAND()");
        $stmt->bind_param("i", $degree_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $questions = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
                    'correct' => $row['correct_answer']
                ];
            }
        }
        $stmt->close();
        $conn->close();

        if (count($questions) > 0) {
            echo json_encode(['success' => true, 'degree_title' => $degree_title, 'questions' => $questions]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No questions found for this course. Please try again later.']);
        }
    }
}
