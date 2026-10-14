<?php
$conn = new mysqli('localhost', 'root', '', 'riasec_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add column if not exists
$conn->query("ALTER TABLE colleges ADD COLUMN requirements JSON NULL");

$requirements = [
    'CvSU' => [
        ['title' => 'Entrance Exam', 'desc' => 'Required admission test for incoming students.', 'status' => 'Required'],
        ['title' => 'Grade 12 Report Card', 'desc' => 'Form 138 / SF9 showing general weighted average.', 'status' => 'Required'],
        ['title' => 'Good Moral Certificate', 'desc' => 'Issued by the high school principal or guidance counselor.', 'status' => 'Required'],
        ['title' => '1x1 Pictures', 'desc' => 'Recent colored ID pictures with white background.', 'status' => 'Required'],
        ['title' => 'Short Folder', 'desc' => 'For compiling all documentary requirements.', 'status' => 'Required'],
        ['title' => 'Medical Examination', 'desc' => 'Health clearance from the university clinic.', 'status' => 'Required'],
        ['title' => 'Course-specific Grade', 'desc' => 'Must meet minimum grade requirements for the chosen course.', 'status' => 'Required'],
        ['title' => 'STEM Requirement', 'desc' => 'Required for all Engineering programs.', 'status' => 'Required']
    ],
    'DLSU-D' => [
        ['title' => 'DSAT Entrance Exam', 'desc' => 'De La Salle University - Dasmariñas Admission Test.', 'status' => 'Required'],
        ['title' => 'Academic Records/SHS Grades', 'desc' => 'High school report card or transcript of records.', 'status' => 'Required'],
        ['title' => 'GPA Requirement', 'desc' => 'Must meet the applicable GPA requirement for the desired program.', 'status' => 'Required']
    ],
    'EAC-C' => [
        ['title' => 'Application Form', 'desc' => 'Duly accomplished EAC admission form.', 'status' => 'Required'],
        ['title' => 'Form 138/Report Card', 'desc' => 'Grade 12 Senior High School Card.', 'status' => 'Required'],
        ['title' => 'Good Moral Certificate', 'desc' => 'Official certificate from previous school.', 'status' => 'Required'],
        ['title' => 'PSA Birth Certificate', 'desc' => 'Original PSA-authenticated copy and photocopy.', 'status' => 'Required'],
        ['title' => 'ID Pictures', 'desc' => 'Recent formal ID photographs.', 'status' => 'Required']
    ],
    'FEAPITSAT' => [
        ['title' => 'Entrance Exam', 'desc' => 'Please verify specific testing schedules with the admissions office.', 'status' => 'Verify'],
        ['title' => 'Birth Certificate', 'desc' => 'PSA or NSO authenticated copy.', 'status' => 'Required'],
        ['title' => 'Form 138/Report Card', 'desc' => 'Original copy of high school report card.', 'status' => 'Required'],
        ['title' => 'Good Moral Certificate', 'desc' => 'Certificate of good moral character.', 'status' => 'Required']
    ],
    'KLD' => [
        ['title' => 'KLD Admission Test', 'desc' => 'Required entrance examination for all applicants.', 'status' => 'Required'],
        ['title' => 'Academic Records/Grades', 'desc' => 'Form 138 showing minimum GPA requirements.', 'status' => 'Required'],
        ['title' => 'Valid ID', 'desc' => 'Student ID or any government-issued valid ID.', 'status' => 'Required'],
        ['title' => 'Enrollment Form', 'desc' => 'Accomplished KLD enrollment application form.', 'status' => 'Required'],
        ['title' => 'Interview', 'desc' => 'Department interview, if applicable for the program.', 'status' => 'Verify'],
        ['title' => 'Minimum GPA', 'desc' => 'Must meet the college minimum GPA requirements.', 'status' => 'Required']
    ],
    'NCST' => [
        ['title' => 'Admission Form', 'desc' => 'Completed NCST application form.', 'status' => 'Required'],
        ['title' => '2x2 Pictures', 'desc' => 'Recent colored 2x2 ID pictures.', 'status' => 'Required'],
        ['title' => '1x1 Pictures', 'desc' => 'Recent colored 1x1 ID pictures.', 'status' => 'Required'],
        ['title' => 'Form 138/Report Card', 'desc' => 'Grade 12 Report Card.', 'status' => 'Required'],
        ['title' => 'Good Moral Certificate', 'desc' => 'Issued by the previous school.', 'status' => 'Required'],
        ['title' => 'Long Brown Envelope', 'desc' => 'For documentary compilation.', 'status' => 'Required']
    ],
    'NU' => [
        ['title' => 'NU Quest Application', 'desc' => 'Online application through the NU Quest portal.', 'status' => 'Required'],
        ['title' => 'Academic Records', 'desc' => 'Original high school report card or transcript.', 'status' => 'Required']
    ],
    'PCU' => [
        ['title' => 'Entrance Exam', 'desc' => 'Verify testing requirements with the admissions office.', 'status' => 'Verify'],
        ['title' => 'Birth Certificate', 'desc' => 'Original and photocopy of Birth Certificate.', 'status' => 'Required'],
        ['title' => 'Report Card', 'desc' => 'Form 138 / Grade 12 Report Card.', 'status' => 'Required'],
        ['title' => 'Permanent Record', 'desc' => 'Form 137 / SF10 from previous school.', 'status' => 'Required'],
        ['title' => 'Good Moral Certificate', 'desc' => 'Certificate of good moral character.', 'status' => 'Required'],
        ['title' => 'Pictures', 'desc' => 'Recent formal ID pictures.', 'status' => 'Required']
    ],
    'PHINMA' => [
        ['title' => 'Form 138 with LRN', 'desc' => 'Grade 12 Report Card containing Learner Reference Number.', 'status' => 'Required'],
        ['title' => 'PSA Birth Certificate', 'desc' => 'Original PSA-authenticated copy.', 'status' => 'Required'],
        ['title' => '2x2 Pictures', 'desc' => 'Recent 2x2 ID pictures.', 'status' => 'Required'],
        ['title' => 'Long Brown Envelope', 'desc' => 'For compiling documentary requirements.', 'status' => 'Required']
    ],
    'PNTC' => [
        ['title' => 'PNTC Admission Test', 'desc' => 'Required for incoming freshmen.', 'status' => 'Required'],
        ['title' => 'Notification Letter', 'desc' => 'Admission notice from the university.', 'status' => 'Required'],
        ['title' => 'Medical Waiver', 'desc' => 'Signed medical waiver form.', 'status' => 'Required'],
        ['title' => 'Vaccination Card', 'desc' => 'Proof of vaccination.', 'status' => 'Required'],
        ['title' => 'Parent\'s ID', 'desc' => 'Photocopy of parent or guardian\'s valid ID.', 'status' => 'Required'],
        ['title' => 'Good Moral Certificate', 'desc' => 'Certificate of good moral character.', 'status' => 'Required'],
        ['title' => 'PSA Birth Certificate', 'desc' => 'Original PSA-authenticated copy.', 'status' => 'Required'],
        ['title' => '1x1 & 2x2 Pictures', 'desc' => 'Recent colored ID pictures.', 'status' => 'Required'],
        ['title' => 'Form 138/SF9', 'desc' => 'Senior High School Report Card.', 'status' => 'Required'],
        ['title' => 'Medical Examination', 'desc' => 'Physical and medical clearance.', 'status' => 'Required'],
        ['title' => 'Ishihara Test', 'desc' => 'Color blindness test, required for maritime programs.', 'status' => 'Required']
    ],
    'STI' => [
        ['title' => 'Form 138/SF9', 'desc' => 'Grade 12 Report Card.', 'status' => 'Required'],
        ['title' => 'Form 137/SF10', 'desc' => 'Student Permanent Record.', 'status' => 'Required'],
        ['title' => 'PSA Birth Certificate', 'desc' => 'Original PSA-authenticated copy.', 'status' => 'Required'],
        ['title' => 'Good Moral Certificate', 'desc' => 'Certificate of good moral character.', 'status' => 'Required'],
        ['title' => 'Medical Cert & X-ray', 'desc' => 'Medical clearance and chest X-ray results.', 'status' => 'Required'],
        ['title' => 'Health Screening', 'desc' => 'Additional health screening where applicable.', 'status' => 'Required']
    ],
    'TUP' => [
        ['title' => 'TUPSAT', 'desc' => 'TUP Scholastic Aptitude Test.', 'status' => 'Required'],
        ['title' => 'Online Application', 'desc' => 'Completed online registration form from the official TUP Admission Portal.', 'status' => 'Required'],
        ['title' => 'Form 138 (Report Card)', 'desc' => 'Grade 12 Senior High School Card.', 'status' => 'Required'],
        ['title' => 'PSA Birth Certificate', 'desc' => 'Original PSA-authenticated copy.', 'status' => 'Required'],
        ['title' => 'Good Moral Certificate', 'desc' => 'Official Certificate of Good Moral Character.', 'status' => 'Required'],
        ['title' => '2x2 ID Pictures', 'desc' => 'Recent colored photographs with formal attire.', 'status' => 'Required'],
        ['title' => 'Long Brown Envelope', 'desc' => 'Labeled envelope for document screening.', 'status' => 'Required'],
        ['title' => 'Department Interview', 'desc' => 'Interview with the respective department head.', 'status' => 'Required'],
        ['title' => 'Medical Examination', 'desc' => 'Health clearance from the university clinic.', 'status' => 'Required']
    ]
];

foreach ($requirements as $short_name => $reqs) {
    $json = json_encode($reqs);
    $stmt = $conn->prepare("UPDATE colleges SET requirements = ? WHERE short_name = ?");
    $stmt->bind_param("ss", $json, $short_name);
    $stmt->execute();
}
echo "Requirements added to database.\n";
