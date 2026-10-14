<?php
/**
 * Master 50-Degree Quiz Seeder
 * Populates 50 curriculum-accurate questions for all 50 degree programs in riasec_db.
 * Total: 2,500 questions across Stages 1, 2, 3, and 4
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'riasec_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error . "\n");
}
$conn->set_charset("utf8mb4");

echo "Connected to database successfully.\n";

// Ensure clean table
$conn->query("CREATE TABLE IF NOT EXISTS course_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    degree_id INT NOT NULL,
    stage INT NOT NULL DEFAULT 1,
    question_text TEXT NOT NULL,
    option_a TEXT NOT NULL,
    option_b TEXT NOT NULL,
    option_c TEXT NOT NULL,
    option_d TEXT NOT NULL,
    correct_answer VARCHAR(1) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_degree_stage (degree_id, stage),
    CONSTRAINT fk_cq_degree FOREIGN KEY (degree_id) REFERENCES degrees(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

$conn->query("TRUNCATE TABLE course_questions");
echo "Cleared existing course questions.\n";

// Load all degree records from degrees table
$res = $conn->query("SELECT id, title, category FROM degrees ORDER BY id ASC");
$degrees = [];
while ($row = $res->fetch_assoc()) {
    $degrees[$row['id']] = $row;
}

echo "Found " . count($degrees) . " degrees in database.\n";

require_once __DIR__ . '/quiz_seeds/data_cluster_1.php';
$c1 = getCluster1Data();

$stmt = $conn->prepare("INSERT INTO course_questions (degree_id, stage, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$totalCount = 0;

// Insert cluster 1 (degrees 1-8)
for ($degId = 1; $degId <= 8; $degId++) {
    if (isset($c1[$degId])) {
        foreach ($c1[$degId] as $q) {
            $stmt->bind_param("iissssss", $degId, $q[0], $q[1], $q[2], $q[3], $q[4], $q[5], $q[6]);
            $stmt->execute();
            $totalCount++;
        }
        echo "Degree #$degId ({$degrees[$degId]['title']}): seeded 50 questions.\n";
    }
}

// Generate authentic curriculum questions for degrees 9 through 50
require_once __DIR__ . '/quiz_seeds/domain_curricula.php';
$domainCurricula = getDomainCurriculaBank();

for ($degId = 9; $degId <= 50; $degId++) {
    $degTitle = $degrees[$degId]['title'] ?? "Degree #$degId";
    $curriculum = $domainCurricula[$degId] ?? null;
    if (!$curriculum) {
        die("Missing curriculum definition for degree $degId: $degTitle\n");
    }

    $qCount = 0;
    foreach ($curriculum as $q) {
        $stmt->bind_param("iissssss", $degId, $q[0], $q[1], $q[2], $q[3], $q[4], $q[5], $q[6]);
        $stmt->execute();
        $qCount++;
        $totalCount++;
    }
    echo "Degree #$degId ($degTitle): seeded $qCount questions.\n";
}

$stmt->close();

// Verification query
$verify = $conn->query("SELECT degree_id, COUNT(*) as count FROM course_questions GROUP BY degree_id ORDER BY degree_id");
echo "\n--- VERIFICATION SUMMARY ---\n";
$allFifty = true;
while ($r = $verify->fetch_assoc()) {
    if ($r['count'] != 50) {
        echo "WARNING: Degree {$r['degree_id']} has {$r['count']} questions instead of 50!\n";
        $allFifty = false;
    }
}
$totalDb = $conn->query("SELECT COUNT(*) as total FROM course_questions")->fetch_assoc()['total'];
echo "Total questions in database: $totalDb\n";
if ($allFifty && $totalDb == 2500) {
    echo "SUCCESS: Exactly 50 questions seeded for all 50 degrees (2,500 questions total)!\n";
} else {
    echo "Check discrepancies above.\n";
}

$conn->close();
