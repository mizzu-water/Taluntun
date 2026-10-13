<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'riasec_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table
$sql = "CREATE TABLE IF NOT EXISTS course_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    degree_id INT NOT NULL,
    stage INT NOT NULL COMMENT '1: Basic, 2: Understanding, 3: Deep Analysis',
    question_text TEXT NOT NULL,
    option_a TEXT NOT NULL,
    option_b TEXT NOT NULL,
    option_c TEXT NOT NULL,
    option_d TEXT NOT NULL,
    correct_answer VARCHAR(1) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (degree_id) REFERENCES degrees(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table course_questions created successfully.\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Insert sample data for BS Nursing (id 27) if empty
$res = $conn->query("SELECT COUNT(*) as count FROM course_questions WHERE degree_id = 27");
$row = $res->fetch_assoc();

if ($row['count'] == 0) {
    $stmt = $conn->prepare("INSERT INTO course_questions (degree_id, stage, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Sample questions for BS Nursing
    $samples = [
        [27, 1, "What is the normal resting heart rate for adults?", "60-100 bpm", "40-60 bpm", "100-120 bpm", "120-140 bpm", "A"],
        [27, 1, "Which of the following is considered a vital sign?", "Blood Pressure", "Blood Sugar", "Cholesterol Level", "Hemoglobin A1C", "A"],
        [27, 2, "If a patient is experiencing shortness of breath, what is the best immediate nursing action?", "Administer oxygen as prescribed", "Give them a glass of water", "Tell them to lie flat", "Check their blood sugar", "A"],
        [27, 3, "A patient with heart failure is prescribed Lasix. What electrolyte imbalance should the nurse monitor for?", "Hypokalemia", "Hyperkalemia", "Hyponatremia", "Hypercalcemia", "A"]
    ];

    foreach ($samples as $q) {
        $stmt->bind_param("iissssss", $q[0], $q[1], $q[2], $q[3], $q[4], $q[5], $q[6], $q[7]);
        $stmt->execute();
    }
    $stmt->close();
    echo "Inserted sample questions for BS Nursing.\n";
}

$conn->close();
?>
