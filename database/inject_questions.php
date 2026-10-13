<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'riasec_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clear old questions first just in case
$conn->query("TRUNCATE TABLE questions");

$questions = [
    // REALISTIC
    // Standard (1-10)
    ['R', "I enjoy assembling, repairing, or building things with my hands.", 'standard', 0],
    ['R', "I would like a job that requires physical activity or working outdoors.", 'standard', 0],
    ['R', "I prefer working with tools, machines, or equipment rather than talking to people.", 'standard', 0],
    ['R', "I enjoy fixing hardware components of a computer or electronic device.", 'standard', 0],
    ['R', "I like doing maintenance or mechanical work on cars or appliances.", 'standard', 0],
    ['R', "I prefer practical, straightforward tasks with visible, tangible results.", 'standard', 0],
    ['R', "I would enjoy operating heavy machinery or specialized equipment.", 'standard', 0],
    ['R', "I like activities that require physical coordination and dexterity.", 'standard', 0],
    ['R', "I would rather build a physical prototype than write an essay about it.", 'standard', 0],
    ['R', "I am interested in jobs related to engineering, construction, or agriculture.", 'standard', 0],
    // Extended (11-20)
    ['R', "I like figuring out how machines and physical systems work.", 'extended', 0],
    ['R', "I enjoy setting up home networks, routers, or cabling.", 'extended', 0],
    ['R', "I would like a career where I am moving around, not sitting at a desk all day.", 'extended', 0],
    ['R', "I find it satisfying to follow a blueprint or diagram to construct something.", 'extended', 0],
    ['R', "I prefer learning by doing rather than reading instructions.", 'extended', 0],
    ['R', "I am comfortable getting my hands dirty to solve a physical problem.", 'extended', 0],
    ['R', "I enjoy working with raw materials like wood, metal, or circuitry.", 'extended', 0],
    ['R', "I would enjoy a job in robotics assembly or hardware testing.", 'extended', 0],
    ['R', "I like activities like hiking, farming, or landscaping.", 'extended', 0],
    ['R', "I trust practical testing more than theoretical models.", 'extended', 0],

    // INVESTIGATIVE
    // Standard
    ['I', "I enjoy solving complex math, logic, or scientific problems.", 'standard', 0],
    ['I', "I like analyzing data to find hidden patterns or trends.", 'standard', 0],
    ['I', "I prefer working on intellectual challenges rather than physical tasks.", 'standard', 0],
    ['I', "I would enjoy writing code, developing software, or designing algorithms.", 'standard', 0],
    ['I', "I like conducting research and learning how things work on a deep level.", 'standard', 0],
    ['I', "I prefer to make decisions based on facts and data rather than emotions.", 'standard', 0],
    ['I', "I am curious about biology, chemistry, physics, or computer science.", 'standard', 0],
    ['I', "I enjoy reading technical articles, scientific journals, or documentation.", 'standard', 0],
    ['I', "I would like a job where I spend my time investigating mysteries or anomalies.", 'standard', 0],
    ['I', "I enjoy troubleshooting complex software bugs or system errors.", 'standard', 0],
    // Extended
    ['I', "I like to ask 'why' and dig deep into the root cause of a problem.", 'extended', 0],
    ['I', "I enjoy working independently in a lab or a quiet focused environment.", 'extended', 0],
    ['I', "I would enjoy designing an experiment to test a hypothesis.", 'extended', 0],
    ['I', "I like playing strategy games or solving puzzles in my free time.", 'extended', 0],
    ['I', "I am interested in artificial intelligence and machine learning concepts.", 'extended', 0],
    ['I', "I prefer abstract thinking and theoretical concepts.", 'extended', 0],
    ['I', "I like to continuously learn new, complex topics just for fun.", 'extended', 0],
    ['I', "I would enjoy analyzing statistics to predict future outcomes.", 'extended', 0],
    ['I', "I find analyzing cybersecurity threats or network vulnerabilities fascinating.", 'extended', 0],
    ['I', "I value precision, accuracy, and rigorous testing in my work.", 'extended', 0],

    // ARTISTIC
    // Standard
    ['A', "I enjoy creating original art, music, or creative writing.", 'standard', 0],
    ['A', "I like designing user interfaces (UI/UX) or creating digital graphics.", 'standard', 0],
    ['A', "I prefer tasks where there are no strict rules, allowing for self-expression.", 'standard', 0],
    ['A', "I am drawn to acting, theater, filmmaking, or video production.", 'standard', 0],
    ['A', "I value aesthetics and making things look beautiful and visually appealing.", 'standard', 0],
    ['A', "I enjoy coming up with out-of-the-box, unconventional ideas.", 'standard', 0],
    ['A', "I would like a job in architecture, interior design, or fashion.", 'standard', 0],
    ['A', "I like expressing my feelings and thoughts through a creative medium.", 'standard', 0],
    ['A', "I prefer working in unstructured environments that encourage creativity.", 'standard', 0],
    ['A', "I enjoy brainstorming wild concepts rather than organizing details.", 'standard', 0],
    // Extended
    ['A', "I like attending concerts, art exhibits, or theater performances.", 'extended', 0],
    ['A', "I would enjoy designing the visual layout of a magazine or website.", 'extended', 0],
    ['A', "I find it easy to imagine new worlds, stories, or characters.", 'extended', 0],
    ['A', "I rely heavily on my intuition and imagination to solve problems.", 'extended', 0],
    ['A', "I like customizing my workspace or personal items to reflect my style.", 'extended', 0],
    ['A', "I am interested in composing music, playing instruments, or audio engineering.", 'extended', 0],
    ['A', "I prefer projects that require a strong sense of style and originality.", 'extended', 0],
    ['A', "I would enjoy creating animations or 3D models for games or movies.", 'extended', 0],
    ['A', "I feel restricted when I have to follow a strict, step-by-step procedure.", 'extended', 0],
    ['A', "I consider myself a highly imaginative and expressive person.", 'extended', 0],

    // SOCIAL
    // Standard
    ['S', "I enjoy helping people solve their personal problems or giving advice.", 'standard', 0],
    ['S', "I would like a career in teaching, training, or mentoring others.", 'standard', 0],
    ['S', "I prefer working closely with a team rather than working alone.", 'standard', 0],
    ['S', "I am interested in healthcare, nursing, counseling, or therapy.", 'standard', 0],
    ['S', "I find it fulfilling to volunteer or participate in community service.", 'standard', 0],
    ['S', "I am highly empathetic and can easily understand how others are feeling.", 'standard', 0],
    ['S', "I enjoy organizing events or activities that bring people together.", 'standard', 0],
    ['S', "I prefer a cooperative environment over a highly competitive one.", 'standard', 0],
    ['S', "I am patient when explaining difficult concepts to someone learning for the first time.", 'standard', 0],
    ['S', "I would like a job focused on improving human well-being and society.", 'standard', 0],
    // Extended
    ['S', "I am usually the person my friends come to when they are stressed.", 'extended', 0],
    ['S', "I enjoy mediating conflicts and helping people reach an understanding.", 'extended', 0],
    ['S', "I would enjoy a career in human resources or employee development.", 'extended', 0],
    ['S', "I find it rewarding to care for people who are sick, elderly, or disabled.", 'extended', 0],
    ['S', "I prefer having deep, meaningful conversations over small talk.", 'extended', 0],
    ['S', "I actively seek out ways to make the people around me feel included.", 'extended', 0],
    ['S', "I would enjoy hosting workshops or seminars to share knowledge.", 'extended', 0],
    ['S', "I am interested in sociology, psychology, and understanding human behavior.", 'extended', 0],
    ['S', "I feel best when I know my work is directly making someone else's life better.", 'extended', 0],
    ['S', "I enjoy collaborating on group projects where everyone contributes.", 'extended', 0],

    // ENTERPRISING
    // Standard
    ['E', "I enjoy taking charge of a project and leading a group of people.", 'standard', 0],
    ['E', "I would like to start my own business or become an entrepreneur.", 'standard', 0],
    ['E', "I like pitching ideas, selling products, or negotiating deals.", 'standard', 0],
    ['E', "I am motivated by reaching ambitious goals, financial success, and status.", 'standard', 0],
    ['E', "I enjoy debating, public speaking, and persuading others to my point of view.", 'standard', 0],
    ['E', "I thrive in competitive environments where I can prove my skills.", 'standard', 0],
    ['E', "I prefer making high-level strategic decisions rather than handling the minor details.", 'standard', 0],
    ['E', "I would enjoy a career in marketing, sales, law, or politics.", 'standard', 0],
    ['E', "I am comfortable taking calculated risks to achieve a big reward.", 'standard', 0],
    ['E', "I enjoy networking and building relationships with influential people.", 'standard', 0],
    // Extended
    ['E', "I often find myself naturally taking the role of a leader in group settings.", 'extended', 0],
    ['E', "I enjoy managing a budget and finding ways to maximize profit.", 'extended', 0],
    ['E', "I would enjoy managing a team of software developers or creatives.", 'extended', 0],
    ['E', "I like organizing campaigns, rallies, or major promotional events.", 'extended', 0],
    ['E', "I am confident when presenting an idea to a large audience or executives.", 'extended', 0],
    ['E', "I enjoy the challenge of convincing a skeptical person to agree with me.", 'extended', 0],
    ['E', "I am interested in investing, the stock market, or real estate.", 'extended', 0],
    ['E', "I prefer a fast-paced environment where quick decisions are required.", 'extended', 0],
    ['E', "I want a career where I have significant authority and influence.", 'extended', 0],
    ['E', "I am driven by the idea of scaling a project to reach millions of people.", 'extended', 0],

    // CONVENTIONAL
    // Standard
    ['C', "I enjoy organizing data, files, or information into structured systems.", 'standard', 0],
    ['C', "I prefer to follow a clear, established set of rules and procedures.", 'standard', 0],
    ['C', "I am highly detail-oriented and rarely make careless mistakes.", 'standard', 0],
    ['C', "I would enjoy a career in accounting, finance, or database administration.", 'standard', 0],
    ['C', "I like working with spreadsheets, numbers, and maintaining accurate records.", 'standard', 0],
    ['C', "I prefer tasks where the expectations are clearly defined from the start.", 'standard', 0],
    ['C', "I am good at managing schedules, logistics, and keeping things on track.", 'standard', 0],
    ['C', "I prefer a predictable, stable work environment over a chaotic one.", 'standard', 0],
    ['C', "I enjoy proofreading, checking for errors, or ensuring compliance with rules.", 'standard', 0],
    ['C', "I like categorized systems and keeping my workspace highly organized.", 'standard', 0],
    // Extended
    ['C', "I enjoy creating step-by-step documentation or manuals.", 'extended', 0],
    ['C', "I would enjoy a job tracking inventory, payroll, or supply chains.", 'extended', 0],
    ['C', "I find satisfaction in balancing budgets and tracking financial expenses.", 'extended', 0],
    ['C', "I prefer knowing exactly what is expected of me on a day-to-day basis.", 'extended', 0],
    ['C', "I am interested in careers involving data entry, bookkeeping, or administration.", 'extended', 0],
    ['C', "I am cautious and prefer to plan ahead rather than act spontaneously.", 'extended', 0],
    ['C', "I like to sort and classify things (like emails, documents, or code).", 'extended', 0],
    ['C', "I am strict about meeting deadlines and being punctual.", 'extended', 0],
    ['C', "I feel stressed when rules keep changing or when things are disorganized.", 'extended', 0],
    ['C', "I enjoy reviewing contracts or code to make sure all standards are met.", 'extended', 0]
];

// Add some reverse-coded questions randomly to test the lie detector (we will set is_reverse_coded = 1)
// For example, replace the last question of Extended sets with a reverse coded one.
$questions[19] = ['R', "I strongly dislike getting my hands dirty or working with physical tools.", 'extended', 1];
$questions[39] = ['I', "I prefer not to overthink things and just go with my gut instinct instead of data.", 'extended', 1];
$questions[59] = ['A', "I prefer strictly following instructions rather than coming up with my own creative ideas.", 'extended', 1];
$questions[79] = ['S', "I find it exhausting to be around people and listen to their problems.", 'extended', 1];
$questions[99] = ['E', "I dislike taking leadership roles and prefer someone else to make the decisions.", 'extended', 1];
$questions[119] = ['C', "I hate organizing data and keeping detailed records.", 'extended', 1];


$stmt = $conn->prepare("INSERT INTO questions (trait, question_text, test_set, is_reverse_coded) VALUES (?, ?, ?, ?)");
foreach ($questions as $q) {
    $stmt->bind_param("sssi", $q[0], $q[1], $q[2], $q[3]);
    $stmt->execute();
}

echo "Successfully injected " . count($questions) . " questions into the database!";
$stmt->close();
$conn->close();
?>
