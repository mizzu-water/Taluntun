<?php
$file = 'app/Controllers/AssessmentController.php';
$content = file_get_contents($file);

$new_methods = '
    public function pauseAssessment() {
        header("Content-Type: application/json");
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode(["success" => false, "error" => "Method not allowed"]);
            exit;
        }

        require_once "auth/config.php";
        startAuthSession();
        if (!isLoggedIn()) {
            echo json_encode(["success" => false, "error" => "Not logged in"]);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["test_type"]) || !isset($data["current_question_index"]) || !isset($data["answers"])) {
            echo json_encode(["success" => false, "error" => "Missing data"]);
            exit;
        }

        $user_id = intval($_SESSION["user_id"]);
        // Convert "standard"/"extended" to 60/120
        $test_type_int = ($data["test_type"] === "extended") ? 120 : 60;
        $current_index = intval($data["current_question_index"]);
        $answers_json = json_encode($data["answers"]);

        $conn = getDB();

        // Check if user already has an in-progress assessment
        $stmt = $conn->prepare("SELECT id FROM user_assessments WHERE user_id = ? AND status = \'in_progress\'");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            // Update
            $row = $res->fetch_assoc();
            $stmt_up = $conn->prepare("UPDATE user_assessments SET test_type=?, current_question_index=?, answers=?, updated_at=NOW() WHERE id=?");
            $stmt_up->bind_param("iisi", $test_type_int, $current_index, $answers_json, $row["id"]);
            $stmt_up->execute();
            $stmt_up->close();
        } else {
            // Insert
            $stmt_in = $conn->prepare("INSERT INTO user_assessments (user_id, test_type, status, current_question_index, answers) VALUES (?, ?, \'in_progress\', ?, ?)");
            $stmt_in->bind_param("iiis", $user_id, $test_type_int, $current_index, $answers_json);
            $stmt_in->execute();
            $stmt_in->close();
        }

        $stmt->close();
        $conn->close();

        echo json_encode(["success" => true, "message" => "Progress saved successfully"]);
        exit;
    }

    public function checkProgress() {
        header("Content-Type: application/json");
        require_once "auth/config.php";
        startAuthSession();
        
        if (!isLoggedIn()) {
            echo json_encode(["success" => true, "has_progress" => false]);
            exit;
        }

        $user_id = intval($_SESSION["user_id"]);
        $conn = getDB();
        
        $stmt = $conn->prepare("SELECT test_type, current_question_index, answers FROM user_assessments WHERE user_id = ? AND status = \'in_progress\' ORDER BY updated_at DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $row["test_type_str"] = ($row["test_type"] == 120) ? "extended" : "standard";
            $row["answers"] = json_decode($row["answers"], true);
            echo json_encode(["success" => true, "has_progress" => true, "progress" => $row]);
        } else {
            echo json_encode(["success" => true, "has_progress" => false]);
        }

        $stmt->close();
        $conn->close();
        exit;
    }
}
';

$content = preg_replace('/\}\s*$/', $new_methods, $content);
file_put_contents($file, $content);
echo "Backend pause logic added!";
?>
