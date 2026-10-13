<?php
require_once 'auth/config.php';

$db = getDB();

$db->query("CREATE TABLE IF NOT EXISTS career_role_models (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255),
    description TEXT,
    career VARCHAR(255),
    degree_program VARCHAR(255),
    degree_program_id INT NULL,
    riasec_primary CHAR(1),
    riasec_secondary CHAR(1),
    image_path VARCHAR(255),
    match_description TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");
$db->query("TRUNCATE TABLE career_role_models");

$data = [
    [1, 'Diosdado “Dado” Banatao', 'BS Electrical Engineering', 'Silicon Valley Technology Engineer', 'Banatao graduated cum laude with a BS in Electrical Engineering. He became a major Filipino figure in Silicon Valley technology and semiconductor engineering, contributing to technologies associated with personal computers and chipsets. His story shows how electrical engineering can lead to computer technology and entrepreneurship.'],
    [2, 'Gregorio Y. Zara', 'BS Mechanical Engineering', 'Inventor and National Scientist', 'Zara earned a BS in Mechanical Engineering from MIT in 1926. He became a Filipino engineer, inventor, and National Scientist known for numerous inventions and engineering contributions, including an early two-way television-telephone system. His career is a direct example of engineering education leading to technological innovation.'],
    [3, 'Francisco “Bobby” Mañosa', 'BS Architecture', 'National Artist for Architecture', 'Mañosa graduated from UST in 1953 under the BS Architecture program. He became a National Artist for Architecture and was known for developing architecture that emphasized Filipino identity, indigenous materials, tropical design, and traditional forms.'],
    [4, 'Angel C. Alcala', 'BS Biology', 'Marine Biologist & Conservationist', 'Alcala graduated magna cum laude with a BS in Biology in 1951. He became a leading marine biologist and conservationist, established the Silliman Marine Laboratory, promoted marine protected areas, and was eventually named a National Scientist.'],
    [5, 'Clara Y. Lim-Sylianco', 'BS Chemistry', 'National Scientist (Chemist)', 'Lim-Sylianco earned a BS in Chemistry from Silliman University in 1949. She became an internationally recognized Filipino chemist and National Scientist whose research covered organic chemistry, biochemistry, genetic toxicology, mutagens, antimutagens, and molecular nutrition.'],
    [6, 'Arnel A. Salvador', 'BS Physics', 'Condensed-Matter Physicist', 'Salvador earned his BS Physics from UP in 1983 and became known for experimental condensed-matter and applied solid-state physics, including work related to semiconductors, optoelectronics, and spectroscopy.'],
    [7, 'Gavino C. Trono Jr.', 'BS Botany', 'Marine Botanist', 'Trono earned his BS in Botany from UP Diliman in 1954 and became internationally recognized for research on seaweeds and marine botany. His work also promoted seaweed cultivation as an environmentally friendly livelihood.'],
    [8, 'Dennis S. Mapa', 'BS Statistics', 'National Statistician', 'Mapa earned a BS in Statistics from UP Diliman and became a professor, researcher, and National Statistician of the Philippine Statistics Authority. His work covers poverty, population, forecasting, household economics, and other statistical applications important to government policy.'],
    [9, 'Ramon C. Barba', 'BS Agriculture', 'National Scientist (Agriculturist)', 'Barba completed a BS in Agriculture in 1958. He became famous for research that induced flowering in mangoes, helping make mango production less dependent on natural seasonal flowering. He was later named a National Scientist.'],
    [10, 'Benito S. Vergara', 'BS Botany', 'Rice Scientist', 'Vergara earned a BS in Botany and became one of the Philippines\' notable rice scientists at the International Rice Research Institute. His work helped explain and improve rice production, and his farmer-oriented publications helped communicate agricultural science.'],
    [11, 'Romulo G. Davide', 'BS Agriculture – Plant Pathology', 'Plant Pathologist', 'Davide earned his bachelor\'s degree in Agriculture with specialization in Plant Pathology. He became a distinguished agricultural scientist specializing in plant diseases and nematology and was eventually recognized as a National Scientist.'],
    [12, 'Dioscoro L. Umali', 'BS Agriculture', 'Father of Philippine Plant Breeding', 'Umali was a Filipino agriculturist and National Scientist known as the Father of Philippine Plant Breeding. His work focused on improving rice, corn, and other economically important crops, contributing to Philippine agricultural science and food production.'],
    [13, 'Isidro A. Consunji', 'BS Civil Engineering', 'Construction & Infrastructure Leader', 'Consunji graduated from UP with a BS in Civil Engineering in 1971 and became a major figure in Philippine construction and infrastructure through the DMCI group.'],
    [14, 'Manny Villar', 'BS Business Administration and Accountancy', 'Entrepreneur & Business Leader', 'Villar graduated from UP with a BS in Business Administration and Accountancy. He became a CPA and later built a major entrepreneurial and real-estate career before entering politics.'],
    [15, 'Dante B. Canlas', 'BS Mathematics', 'Economist & Public Policy Leader', 'Canlas earned a BS in Mathematics from UP Diliman before pursuing graduate studies in economics. He became an economist, professor, and former Director-General of NEDA and Secretary of Socioeconomic Planning.'],
    [16, 'Ramon S. Ang', 'BS Mechanical Engineering', 'Industrial & Infrastructure Leader', 'Ang earned a BS in Mechanical Engineering from Mapúa. As President and CEO of San Miguel Corporation, he leveraged his engineering background to direct major industrial operations, infrastructure, energy projects, and manufacturing expansions across the Philippines.'],
    [17, 'Tony Tan Caktiong', 'BS Chemical Engineering', 'Restaurant Entrepreneur', 'Founder and Chairman of Jollibee Foods Corporation, one of the world\'s fastest-growing restaurant companies. He applied his engineering background to systemize operations, quality control, and supply chain management.'],
    [18, 'Jesse Robredo', 'BS Industrial Engineering', 'Public Servant & Good Governance Advocate', 'Robredo earned a BS in Industrial Engineering from UP. As Mayor of Naga City and Secretary of the DILG, he applied industrial engineering principles to optimize local government systems, improve public service delivery, and implement transparent, efficient governance practices.'],
    [19, 'Mar Roxas', 'BS Economics', 'Economist & Public Servant', 'Roxas earned a BS in Economics from Wharton. Serving as Secretary of Trade and Industry, Senator, and DILG Secretary, he utilized his economic and financial training to spearhead trade policies and promote industrial growth.'],
    [20, 'Carl Balita', 'BS Nursing', 'Educational Entrepreneur', 'Balita earned a BS in Nursing from UST in 1991. He was named one of seven The Outstanding Filipino (TOFIL) awardees in 2024 for his review centers, which help people pass licensure exams.'],
    [21, 'Dr. Laura D. Garcia', 'BS Nursing', 'Nursing Professional & Leader', 'Garcia earned a BS in Nursing from Silliman University in 1981 and was a recipient of the 2021 Presidential Award for Filipinos Overseas, recognizing her professional contributions and service.'],
    [22, 'Dr. Leorey N. Saligan', 'BS Medical Technology', 'Health Science Researcher', 'Saligan earned a BS in Medical Technology from Silliman University in 1988. He was named an Outstanding Sillimanian in 2018 for his research contributions in health science and nursing.'],
    [23, 'Annaflor Feliprada-Patrizio', 'BS Pharmacy', 'Healthcare Entrepreneur', 'Feliprada-Patrizio graduated with a BS in Pharmacy from CEU in 2001. She built a career in pharmaceutical care and healthcare entrepreneurship in Canada and was named one of the 2022 Most Influential Filipina Women in the World.'],
    [24, 'Dr. Melvin J. Sanicas', 'BS Biology', 'Physician-Scientist', 'Sanicas earned his BS in Biology from UP Manila in 2011 and became a physician-scientist specializing in infectious diseases, vaccines, and global health.'],
    [25, 'David L. Almirol Jr.', 'BS Computer Science', 'Software & Digital Infrastructure Leader', 'Almirol graduated with a BS in Computer Science in 2002. He founded and serves as CEO of Multisys Technologies Corporation, leading software development and digital infrastructure projects in the Philippines.'],
    [26, 'Benito C. Bengzon Jr.', 'BS Hotel and Restaurant Administration', 'Tourism Administrator', 'Bengzon earned his degree in Hotel and Restaurant Administration from UP and pursued a career in tourism administration, serving as Undersecretary of the Department of Tourism.'],
    [27, 'Alfredo M. Velayo', 'BS Commerce major in Accounting', 'CPA & Business Leader', 'Velayo earned his degree from UST and became a prominent certified public accountant and business leader. He co-founded SyCip Gorres Velayo & Co. (SGV).'],
    [28, 'Maria Ressa', 'BA English', 'Journalist & Nobel Peace Prize Laureate', 'Ressa graduated cum laude with a BA in English from Princeton University in 1986. She became a prominent journalist, author, and co-founder of Rappler, and in 2021 became the first Filipino recipient of the Nobel Peace Prize.'],
    [29, 'Dr. Lourdes J. Cruz', 'BS Chemistry', 'National Scientist (Biochemist)', 'Cruz earned a BS in Chemistry from UP Diliman in 1962. She became a National Scientist renowned for her research on the venom of Conus marine snails, which helped advance understanding of neurotoxins.'],
    [30, 'Dr. Edgardo D. Gomez', 'BS Education', 'Marine Conservationist & Scientist', 'Gomez graduated summa cum laude with a dual degree in Education and Social Sciences from DLSU. He founded the UP Marine Science Institute and led pioneering efforts in coral reef restoration.'],
    [31, 'Dr. Rafael D. Guerrero III', 'BS Zoology', 'Aquaculture Innovator', 'Guerrero earned a BS in Zoology from UP Diliman. Known as the Father of Tilapia Sex Reversal, his groundbreaking work in aquaculture transformed tilapia farming into a major food industry in the Philippines.'],
    [32, 'Dr. Julian A. Banzon', 'BS Chemistry', 'Alternative Fuels Pioneer', 'Banzon earned a BS in Chemistry from UP Diliman in 1909. Named a National Scientist, his pioneering research focused on alternative fuels and coconut processing.'],
    [33, 'Dr. Fe del Mundo', 'MD (Pre-med studies)', 'Pioneering Pediatrician', 'Del Mundo completed her medical degree at UP Manila. A pioneer in pediatrics and the first female student admitted to Harvard Medical School, she founded the first pediatric hospital in the Philippines.'],
    [34, 'Washington SyCip', 'BS Commerce major in Accounting', 'Accounting & Business Titan', 'SyCip graduated summa cum laude from UST with a degree in Accounting. He co-founded SyCip Gorres Velayo & Co. (SGV) and the Asian Institute of Management (AIM).'],
    [35, 'Lance Gokongwei', 'BS Applied Science and BS Economics', 'Corporate Executive', 'Gokongwei earned dual degrees in Applied Science and Economics from Wharton. As President and CEO of JG Summit Holdings, he has led key operations across aviation, retail, real estate, and food manufacturing.'],
    [36, 'Arthur Tan', 'BS Electronics and Communications Engineering', 'Electronics Manufacturing Leader', 'Tan graduated with a BS in Electronics and Communications Engineering from Mapúa. He serves as Senior Managing Director at Ayala Corporation and CEO of Integrated Micro-Electronics, Inc. (IMI).'],
    [37, 'Lucio C. Tan', 'BS Chemical Engineering', 'Business Magnate', 'Tan studied Chemical Engineering at FEU. He built a vast business empire spanning banking, airline, tobacco, liquor, and real estate, serving as Chairman of LT Group and Philippine Airlines.'],
    [38, 'David M. Consunji', 'BS Civil Engineering', 'Grand Builder of Philippine Construction', 'Consunji earned a BS in Civil Engineering from UP in 1946. Known as the Grand Builder of Philippine Construction, he founded DMCI and served as Secretary of Public Works and Highways.'],
    [39, 'Dr. Carmen C. Velasquez', 'BS Zoology', 'Parasitologist & National Scientist', 'Velasquez earned a BS in Zoology from UP in 1931. She was a pioneering parasitologist named a National Scientist for her extensive research on fish parasites and public health impacts in aquaculture.'],
    [40, 'Dr. Geminiano T. de Ocampo', 'MD (Pre-med studies)', 'Pioneer of Philippine Ophthalmology', 'De Ocampo earned his medical degree from UP Manila. Named a National Scientist, he was the pioneer of Philippine ophthalmology, established the first eye hospital in the country, and introduced corneal transplantation.'],
    [41, 'Dr. Casimiro del Rosario', 'BS Civil Engineering', 'Physicist & Astronomer', 'Del Rosario earned his degree from UP and went on to study physics. Named a National Scientist, he made major contributions to physics, meteorology, and astronomy, serving as Director of the Weather Bureau.'],
    [42, 'Dr. Perla D. Santos Ocampo', 'MD (Pre-med studies)', 'Pediatrician & National Scientist', 'Santos Ocampo completed her medical degree at UP Manila. A National Scientist and leading pediatrician, she contributed significantly to child health, malnutrition research, and medical education.'],
    [43, 'Dr. Caesar A. Saloma', 'BS Physics', 'Physicist & Optical Scientist', 'Saloma earned a BS in Physics from UP Diliman. An internationally acclaimed physicist, he pioneered optical signal processing and microscopy development and served as Chancellor of UP Diliman.'],
    [44, 'Dr. William G. Padolina', 'BS Agricultural Chemistry', 'Agricultural Scientist & Leader', 'Padolina earned his degree in Agricultural Chemistry magna cum laude from UPLB. He served as Secretary of the Department of Science and Technology (DOST) and President of the National Academy of Science and Technology.'],
    [45, 'Dr. Fabian M. Dayrit', 'BS Chemistry', 'Chemist & Academician', 'Dayrit earned a BS in Chemistry cum laude from Ateneo de Manila University. An Academician of NAST, his research focuses on natural products chemistry, herbal medicine, and coconut oil chemistry.'],
    [46, 'Dr. Dolores A. Ramirez', 'BS Agriculture', 'Biochemical Geneticist', 'Ramirez earned a BS in Agriculture from UPLB in 1956. Named a National Scientist, her biochemical genetics research advanced plant breeding and crop genetics in the Philippines.'],
    [47, 'Dr. Encarnacion Alzona', 'BA and MA History', 'Historian & Suffragist', 'Alzona earned her history degrees from UP. Named a National Scientist, she was the first Filipino woman to earn a Ph.D. and a pioneering historian and suffragist advocating for women\'s rights.'],
    [48, 'Jose Mañosa', 'BS Architecture', 'Architect & Urban Planner', 'Mañosa earned his BS Architecture from UST. Alongside his brothers, he contributed significantly to Philippine architectural design and urban planning through the Mañosa Brothers firm.'],
    [49, 'Dr. Mercedes B. Concepcion', 'BS Chemistry', 'Mother of Philippine Demography', 'Concepcion earned a BS in Chemistry from UP. Known as the Mother of Philippine Demography, she was named a National Scientist for her groundbreaking research on population and development studies.'],
    [50, 'Dr. Gelia T. Castillo', 'BS Psychology', 'Rural Sociologist', 'Castillo earned a BS in Psychology magna cum laude from UP in 1953. Named a National Scientist, she was a pioneering rural sociologist whose research on agricultural development and rural poverty influenced global development policy.']
];

$stmt = $db->prepare("INSERT INTO career_role_models (name, degree_program, title, description, image_path) VALUES (?, ?, ?, ?, ?)");
foreach ($data as $row) {
    $imgPath = '/riasec/assets/role-models/image' . $row[0] . '.png';
    $stmt->bind_param('sssss', $row[1], $row[2], $row[3], $row[4], $imgPath);
    $stmt->execute();
}
echo "Imported 50 role models.\n";
