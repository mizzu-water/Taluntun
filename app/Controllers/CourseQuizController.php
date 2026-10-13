<?php
require_once 'auth/config.php';

class CourseQuizController extends Controller {
    public function index() {
        $this->view('course-quiz');
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
