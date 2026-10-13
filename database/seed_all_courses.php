<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'riasec_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the table is clear so we can re-seed cleanly
$conn->query("DELETE FROM course_questions");

// Some real questions for key programs to prove it works dynamically
$seed_data = [
    // 1 BS Business Administration
    1 => [
        [1, "What is the primary goal of marketing?", "To increase expenses", "To create, communicate, and deliver value to customers", "To hire more employees", "To close the business", "B"],
        [2, "What does ROI stand for?", "Return on Investment", "Rate of Interest", "Return on Income", "Ratio of Inflation", "A"],
        [3, "Which document summarizes a company's assets, liabilities, and equity at a specific point in time?", "Income Statement", "Cash Flow Statement", "Balance Sheet", "Annual Report", "C"]
    ],
    // 2 BS Accountancy
    2 => [
        [1, "What is the fundamental accounting equation?", "Assets = Liabilities - Equity", "Assets = Liabilities + Equity", "Equity = Assets + Liabilities", "Liabilities = Assets + Equity", "B"],
        [2, "Which account is normally credited when cash is received?", "Cash", "Accounts Receivable", "Accounts Payable", "Inventory", "A"],
        [3, "What is the process of allocating the cost of a tangible asset over its useful life?", "Amortization", "Depreciation", "Depletion", "Valuation", "B"]
    ],
    // 15 BS Information Technology
    15 => [
        [1, "What does HTML stand for?", "Hyper Text Markup Language", "High Tech Modern Language", "Hyperlink and Text Markup Language", "Home Tool Markup Language", "A"],
        [2, "Which protocol is used for secure communication over a computer network?", "HTTP", "FTP", "HTTPS", "SMTP", "C"],
        [3, "What is the main function of a DNS?", "To assign IP addresses", "To encrypt web traffic", "To translate domain names to IP addresses", "To host websites", "C"]
    ],
    // 16 BS Computer Science
    16 => [
        [1, "Which data structure uses LIFO (Last In, First Out)?", "Queue", "Stack", "Tree", "Graph", "B"],
        [2, "What is the time complexity of binary search?", "O(1)", "O(n)", "O(log n)", "O(n^2)", "C"],
        [3, "Which paradigm does Java primarily follow?", "Functional Programming", "Procedural Programming", "Object-Oriented Programming", "Logic Programming", "C"]
    ],
    // 26 BS Architecture
    26 => [
        [1, "Who is known as the 'Father of Modern Architecture'?", "Frank Lloyd Wright", "Le Corbusier", "Louis Sullivan", "Zaha Hadid", "C"],
        [2, "What is the purpose of a load-bearing wall?", "To provide aesthetic appeal", "To support the weight of the elements above it", "To act as a partition", "To insulate the building", "B"],
        [3, "What architectural style is characterized by pointed arches, ribbed vaults, and flying buttresses?", "Classical", "Baroque", "Gothic", "Renaissance", "C"]
    ],
    // 27 BS Nursing (keeping original sample plus some)
    27 => [
        [1, "What is the normal resting heart rate for adults?", "60-100 bpm", "40-60 bpm", "100-120 bpm", "120-140 bpm", "A"],
        [2, "Which of the following is considered a vital sign?", "Blood Pressure", "Blood Sugar", "Cholesterol Level", "Hemoglobin A1C", "A"],
        [3, "If a patient is experiencing shortness of breath, what is the best immediate nursing action?", "Administer oxygen as prescribed", "Give them a glass of water", "Tell them to lie flat", "Check their blood sugar", "A"]
    ],
    // 40 BS Criminology
    40 => [
        [1, "What is the primary study of criminology?", "The biological traits of humans", "The nature, extent, causes, and control of criminal behavior", "The history of police forces", "The procedures of the court system", "B"],
        [2, "Which theory suggests that individuals learn criminal behavior through interaction with others?", "Strain Theory", "Social Learning Theory", "Labeling Theory", "Rational Choice Theory", "B"],
        [3, "What is 'mens rea' in criminal law?", "The criminal act", "The guilty mind or intent", "The victim's perspective", "The evidence", "B"]
    ],
    // 44 BS Social Work
    44 => [
        [1, "What is a core value of the social work profession according to the NASW Code of Ethics?", "Profit maximization", "Social justice", "Competitive advantage", "Individual isolation", "B"],
        [2, "Which of the following is a primary role of a social worker?", "Diagnosing physical illnesses", "Prescribing medication", "Advocating for vulnerable populations", "Arresting offenders", "C"],
        [3, "What does 'empowerment' mean in the context of social work?", "Giving clients money", "Helping clients recognize and build upon their own strengths", "Making decisions for the client", "Ignoring the client's problems", "B"]
    ]
];

$stmt = $conn->prepare("INSERT INTO course_questions (degree_id, stage, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$total_inserted = 0;

// Insert custom questions
foreach ($seed_data as $deg_id => $questions) {
    foreach ($questions as $q) {
        $stmt->bind_param("iissssss", $deg_id, $q[0], $q[1], $q[2], $q[3], $q[4], $q[5], $q[6]);
        $stmt->execute();
        $total_inserted++;
    }
}

// Generate fallback realistic-looking questions for all other degrees so the system works dynamically
for ($deg_id = 1; $deg_id <= 50; $deg_id++) {
    if (isset($seed_data[$deg_id])) continue;
    
    $fallbacks = [
        [1, "What is a foundational concept studied in this program?", "Basic Principles", "Advanced Mechanics", "Management Protocols", "Global Policies", "A"],
        [2, "When applying core skills from this degree, what is the best approach to problem-solving?", "Ignoring the data", "Analytical reasoning", "Guessing", "Delegating everything", "B"],
        [3, "Which professional ethic is most critical for graduates of this program?", "Integrity and accountability", "Speed over accuracy", "Profit at all costs", "Avoiding responsibility", "A"]
    ];
    
    foreach ($fallbacks as $q) {
        $stmt->bind_param("iissssss", $deg_id, $q[0], $q[1], $q[2], $q[3], $q[4], $q[5], $q[6]);
        $stmt->execute();
        $total_inserted++;
    }
}

$stmt->close();
$conn->close();

echo "Successfully seeded $total_inserted questions across all 50 degrees!\n";
?>
