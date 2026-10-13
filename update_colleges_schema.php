<?php
require_once 'auth/config.php';
$db = getDB();

$columns = [];
$res = $db->query("SHOW COLUMNS FROM colleges");
while ($r = $res->fetch_assoc()) {
    $columns[] = $r['Field'];
}

if (!in_array('about', $columns)) {
    $db->query("ALTER TABLE colleges ADD COLUMN about TEXT NULL");
}
if (!in_array('address', $columns)) {
    $db->query("ALTER TABLE colleges ADD COLUMN address VARCHAR(255) NULL");
}
if (!in_array('map_query', $columns)) {
    $db->query("ALTER TABLE colleges ADD COLUMN map_query VARCHAR(255) NULL");
}

$abouts = [
    'DLSU-D' => [
        'name' => 'De La Salle University - Dasmariñas',
        'about' => 'De La Salle University–Dasmariñas (DLSU-D) is a premier Catholic Lasallian institution committed to faith, integrity, and academic excellence. Known for its lush, eco-friendly 27-hectare campus in Dasmariñas, DLSU-D offers comprehensive programs in business, sciences, engineering, liberal arts, and education, fostering innovative leaders and socially responsible professionals.',
        'address' => 'DBB-B, Dasmariñas City, Cavite',
        'map_query' => 'De La Salle University Dasmarinas'
    ],
    'TUP' => [
        'name' => 'Technological University of the Philippines - Cavite',
        'about' => 'Technological University of the Philippines–Cavite (TUP-Cavite) is a premier state technological university campus located in Salawag, Dasmariñas. Established to meet the surging demand for technical and engineering expertise in CALABARZON, TUP-Cavite provides hands-on, industry-standard training in engineering, applied sciences, and industrial technology.',
        'address' => 'Carlos Q. Trinidad Ave, Salawag, Dasmariñas City, Cavite',
        'map_query' => 'Technological University of the Philippines Cavite'
    ],
    'CvSU' => [
        'name' => 'Cavite State University - Dasmariñas Campus',
        'about' => 'Cavite State University (CvSU) is a distinguished public state institution in Cavite committed to providing accessible, high-quality tertiary education. Its Dasmariñas campus offers students from Cavite affordable programs across business, education, technology, and applied sciences, driven by core values of Truth, Excellence, and Service.',
        'address' => 'City of Dasmariñas, Cavite',
        'map_query' => 'Cavite State University Dasmarinas'
    ],
    'EAC-C' => [
        'name' => 'Emilio Aguinaldo College - Cavite',
        'about' => 'Emilio Aguinaldo College–Cavite (EAC-Cavite) is an autonomous private higher education institution in Dasmariñas. Renowned for its cutting-edge medical and health sciences programs, as well as business, criminology, and engineering, EAC-Cavite equips students with practical global competencies, state-of-the-art laboratory facilities, and extensive hospital affiliations.',
        'address' => 'Congressional East Ave, Burol Main, Dasmariñas City, Cavite',
        'map_query' => 'Emilio Aguinaldo College Cavite'
    ],
    'NCST' => [
        'name' => 'National College of Science and Technology',
        'about' => 'National College of Science and Technology (NCST) is a leading educational institution in Dasmariñas, Cavite, dedicated to career-focused education. NCST combines rigorous classroom fundamentals with intensive industry immersions across IT, computer studies, engineering technology, business administration, and hospitality.',
        'address' => 'Emilio Aguinaldo Hwy, Dasmariñas City, Cavite',
        'map_query' => 'National College of Science and Technology Dasmarinas'
    ],
    'PCU' => [
        'name' => 'Philippine Christian University - Dasmariñas',
        'about' => 'Philippine Christian University–Dasmariñas (PCU-D) is an ecumenical Christian university providing education rooted in faith, character, and service. Nestled in a serene campus environment, PCU offers diverse degree paths in business, information technology, maritime studies, education, and social sciences.',
        'address' => 'Emilio Aguinaldo Hwy, Sampaloc 1, Dasmariñas City, Cavite',
        'map_query' => 'Philippine Christian University Dasmarinas'
    ]
];

foreach ($abouts as $short_name => $info) {
    $stmt = $db->prepare("UPDATE colleges SET about = ?, address = ?, map_query = ? WHERE short_name = ?");
    $stmt->bind_param("ssss", $info['about'], $info['address'], $info['map_query'], $short_name);
    $stmt->execute();
    $stmt->close();
}

echo "Successfully updated colleges with rich descriptions!\n";
