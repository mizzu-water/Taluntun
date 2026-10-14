<?php
$conn = new mysqli('localhost', 'root', '', 'riasec_db');
if ($conn->connect_error) die("Connection failed");

$abouts = [
    'Cavite State University' => "Cavite State University (CvSU) is a public university in Cavite dedicated to providing accessible higher education, research, extension services, and community development. Its Dasmariñas Learning Center serves students in the Dasmariñas area and contributes to CvSU's goal of making quality education accessible to local communities.",
    'De La Salle University - Dasmariñas' => "De La Salle University–Dasmariñas is a Catholic Lasallian institution committed to faith, excellence, and service. It provides human and Christian education while developing competent professionals, transformative leaders, and socially responsible citizens. The university is also recognized for its strong academic programs, research, community engagement, and sustainability initiatives.",
    'Emilio Aguinaldo College' => "Emilio Aguinaldo College–Cavite is a private higher education institution located in Dasmariñas. The Cavite campus was developed to expand access to education outside Metro Manila and offers programs in areas including health sciences, business, education, and other professional fields. The campus traces its development in Dasmariñas to 1977.",
    'FEAPITSAT' => "FEAPITSAT College of Dasmariñas is an educational and technical-vocational institution established to provide academic and skills-based education to students in Cavite. It began accepting applicants in Dasmariñas during School Year 2012–2013. The institution has offered TESDA-recognized competency programs including Bartending, Food and Beverage Services, Bookkeeping, Visual Graphics Design, and Event Management Services",
    'Kolehiyo' => "Kolehiyo ng Lungsod ng Dasmariñas is a city-established higher education institution created to provide quality and equitable tertiary education to qualified Dasmarineños. It was formally established through a city ordinance in 2021 and focuses on developing knowledgeable, capable, and socially responsible graduates. Its programs include Psychology, Information Systems, Nursing, Civil Engineering, Life Sciences, Computer Science, Social Work, and Midwifery.",
    'National College of Science and Technology' => "National College of Science and Technology (NCST) is an educational institution in Cavite focused on providing accessible education and preparing students for professional and technical careers. Its Dasmariñas campus is part of the NCST Education System and provides programs designed to develop students' academic knowledge, technical skills, and career readiness.",
    'National University' => "National University–Dasmariñas is a campus of National University established in 2021. It provides accessible and quality education for students in Cavite and Southern Luzon, with programs in areas such as engineering, business, accountancy, information technology, psychology, hospitality management, architecture, and education. The campus emphasizes preparing students to become future-ready professionals.",
    'Philippine Christian University' => "Philippine Christian University–Dasmariñas is a Christian higher education campus that combines academic excellence with Christian values and social responsibility. PCU expanded its educational offerings to the 97-hectare Union Theological Seminary campus in Dasmariñas through a partnership established in 1978. The campus offers programs in business, accountancy, hospitality and tourism, information technology, computer science, engineering, multimedia arts, and other fields",
    'PHINMA' => "PHINMA Saint Jude College–Dasmariñas is a private, non-sectarian institution located in Salitran IV, Dasmariñas. It became part of the PHINMA Education network in 2024. The school aims to provide accessible and quality education and offers programs including Nursing, Radiologic Technology, Psychology, Hospitality Management, Computer Science, and other academic programs.",
    'PNTC' => "PNTC Colleges is a private, non-sectarian maritime and business school based in Dasmariñas. Founded in 1994 as the Philippine Nautical Training Institute, it developed into PNTC Colleges and expanded its offerings beyond maritime education. The institution provides higher education, maritime training, and competency assessment, with a strong focus on producing competent and globally competitive maritime professionals.",
    'STI' => "STI College–Dasmariñas is a private educational institution offering senior high school, college, and technical-vocational programs. Its tertiary offerings include Computer Science, Information Technology, Business Administration, Accountancy, Accounting Information System, Hospitality Management, Multimedia Arts, Communication, and Tourism Management. The campus is located along N. Guevarra Street in Dasmariñas",
    'Technological University of the Philippines' => "Technological University of the Philippines–Cavite is a public technological university campus located in Salawag, Dasmariñas. The campus was established to address the need for technology education and skilled workers in the CALABARZON region. It offers technology-oriented programs, including three-year technology courses, bachelor's degrees, and master's programs."
];

foreach ($abouts as $key => $about) {
    $safe_about = $conn->real_escape_string($about);
    $conn->query("UPDATE colleges SET about = '$safe_about' WHERE name LIKE '%$key%'");
}
echo "DB Updated.\n";

// Update the static HTML files
$generic1 = "<p class=\"mb-4\">This university is a leading educational institution in the region, providing students with world-class facilities and a diverse range of academic programs. Established with a vision to nurture future leaders, the campus fosters an environment of innovation, research, and community service.</p>";
$generic2 = "<p>With an emphasis on both theoretical knowledge and practical application, graduates are well-prepared for the demands of the modern workforce.</p>";

$files = glob(__DIR__ . '/app/Views/*-profile.html');
foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Find the specific text for this file based on its name or just replace it with dynamic container for school-profile
    if (basename($file) == 'school-profile.html') {
        // Replace with dynamic DOM id
        $content = str_replace($generic1 . "\n                    " . $generic2, '<p id="college-about" class="mb-4 text-gray-600"></p>', $content);
        $content = str_replace($generic1 . "\r\n                    " . $generic2, '<p id="college-about" class="mb-4 text-gray-600"></p>', $content);
        $content = str_replace($generic1, '<p id="college-about" class="mb-4 text-gray-600"></p>', $content); // fallback
        $content = str_replace($generic2, '', $content);
    } else {
        // For static files, inject the correct text
        $specific_about = "";
        if (strpos($file, 'cvsu') !== false) $specific_about = $abouts['Cavite State University'];
        if (strpos($file, 'dlsu') !== false) $specific_about = $abouts['De La Salle University - Dasmariñas'];
        if (strpos($file, 'eac') !== false) $specific_about = $abouts['Emilio Aguinaldo College'];
        if (strpos($file, 'ncst') !== false) $specific_about = $abouts['National College of Science and Technology'];
        if (strpos($file, 'pcu') !== false) $specific_about = $abouts['Philippine Christian University'];
        if (strpos($file, 'tup') !== false) $specific_about = $abouts['Technological University of the Philippines'];
        
        if ($specific_about) {
            $replacement = "<p class=\"mb-4\">" . htmlspecialchars($specific_about) . "</p>";
            $content = str_replace($generic1 . "\n                " . $generic2, $replacement, $content);
            $content = str_replace($generic1 . "\r\n                " . $generic2, $replacement, $content);
            $content = str_replace($generic1 . "\n                    " . $generic2, $replacement, $content);
            $content = str_replace($generic1 . "\r\n                    " . $generic2, $replacement, $content);
            $content = str_replace($generic1, $replacement, $content);
            $content = str_replace($generic2, '', $content);
        }
    }
    
    file_put_contents($file, $content);
    echo "Updated " . basename($file) . "\n";
}
