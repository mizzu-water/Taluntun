<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'riasec_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Ensure table exists
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
    INDEX (degree_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// 2. Clear old data
$conn->query("TRUNCATE TABLE course_questions");

// 3. Question bank for all 31 degrees
$questions_by_degree = [
    // 1: BS Computer Science
    1 => [
        [1, "Which data structure operates on a Last In, First Out (LIFO) principle?", "Queue", "Stack", "Binary Search Tree", "Linked List", "B"],
        [1, "What is the worst-case time complexity of standard QuickSort?", "O(n log n)", "O(n)", "O(n²)", "O(1)", "C"],
        [2, "In Object-Oriented Programming, which principle allows a child class to provide a specific implementation of a parent method?", "Polymorphism", "Encapsulation", "Abstraction", "Composition", "A"],
        [2, "Which algorithm is commonly used to find the shortest path in a weighted graph without negative edges?", "Dijkstra's Algorithm", "Depth-First Search", "Bubble Sort", "Kruskal's Algorithm", "A"],
        [3, "What is the primary difference between a process and a thread in modern operating systems?", "A thread has its own private virtual memory space", "Threads share the memory space of their parent process", "Processes cannot be scheduled by the OS", "Threads cannot communicate with other threads", "B"]
    ],

    // 2: BS Information Technology
    2 => [
        [1, "What does HTTP stand for in web technologies?", "Hyperlink Text Transmission Protocol", "HyperText Transfer Protocol", "High-speed Text Transfer Protocol", "Host Terminal Transport Protocol", "B"],
        [1, "Which protocol is responsible for securely encrypting web traffic between a browser and a server?", "FTP", "SNMP", "HTTPS", "Telnet", "C"],
        [2, "What is the primary function of a Domain Name System (DNS)?", "Encrypting passwords", "Translating domain names into IP addresses", "Allocating bandwidth", "Filtering malware", "B"],
        [2, "In relational database design, what is the role of a Foreign Key?", "Ensure column values are never null", "Uniquely identify each row in the same table", "Establish a relationship linking to the primary key of another table", "Create an automated backup index", "C"],
        [3, "Which cybersecurity principle refers to granting users only the minimum permissions necessary to perform their jobs?", "Defense in Depth", "Principle of Least Privilege", "Separation of Duties", "Zero-Day Hardening", "B"]
    ],

    // 3: BS Civil Engineering
    3 => [
        [1, "In civil engineering, what property measures a concrete mix's ability to resist compression?", "Tensile strength", "Compressive strength", "Shear modulus", "Ductility", "B"],
        [1, "Which instrument is traditionally used in land surveying to measure both horizontal and vertical angles?", "Theodolite", "Manometer", "Anemometer", "Barometer", "A"],
        [2, "What is the primary purpose of steel rebar embedded in reinforced concrete structures?", "Resist compressive loads", "Provide tensile strength to prevent cracking under tension", "Lower the curing temperature", "Prevent water absorption", "B"],
        [2, "In soil mechanics, what does the Atterberg limits test determine?", "The moisture thresholds of fine-grained soil between liquid, plastic, and solid states", "The soil's electrical resistivity", "The depth of the water table", "The chemical pH of the subsoil", "A"],
        [3, "When analyzing a bridge truss, what type of structural force attempts to pull a member apart?", "Torsion", "Tension", "Compression", "Bearing", "B"]
    ],

    // 4: BS Mechanical Engineering
    4 => [
        [1, "According to the First Law of Thermodynamics, energy cannot be created or destroyed, but can only be what?", "Doubled", "Transformed from one form to another", "Converted to negative mass", "Dissipated into absolute zero", "B"],
        [1, "What unit is commonly used to measure torque in the SI system?", "Joule (J)", "Newton-meter (N·m)", "Pascal (Pa)", "Watt (W)", "B"],
        [2, "What is the primary purpose of a governor in mechanical machinery?", "To cool lubricating oil", "To automatically regulate the engine's speed regardless of load changes", "To amplify hydraulic pressure", "To ignite air-fuel mixture", "B"],
        [2, "In fluid dynamics, what non-dimensional number helps predict whether a fluid flow will be laminar or turbulent?", "Mach number", "Reynolds number", "Prandtl number", "Froude number", "B"],
        [3, "Which thermodynamic cycle serves as the ideal benchmark cycle for steam power plants?", "Carnot Cycle", "Rankine Cycle", "Otto Cycle", "Diesel Cycle", "B"]
    ],

    // 5: BS Electrical Engineering
    5 => [
        [1, "According to Ohm's Law, what is the mathematical relationship between Voltage (V), Current (I), and Resistance (R)?", "V = I × R", "V = I / R", "V = I + R", "V = R / I", "A"],
        [1, "What electrical component is designed to store energy in an electrostatic field?", "Inductor", "Resistor", "Capacitor", "Diode", "C"],
        [2, "What is the primary function of an electrical transformer in power distribution?", "Convert direct current (DC) into alternating current (AC)", "Step up or step down AC voltage levels via electromagnetic induction", "Filter electromagnetic interference", "Store excess electrical energy for peak hours", "B"],
        [2, "In three-phase electrical power systems, how many degrees out of phase are the three AC voltage waveforms?", "60 degrees", "90 degrees", "120 degrees", "180 degrees", "C"],
        [3, "Which law states that the induced electromotive force in a circuit is directly proportional to the time rate of change of magnetic flux?", "Ampere's Law", "Faraday's Law of Induction", "Coulomb's Law", "Kirchhoff's Current Law", "B"]
    ],

    // 6: BS Architecture
    6 => [
        [1, "Which prominent 20th-century architect coined the famous modernist maxim 'Form follows function'?", "Louis Sullivan", "Frank Gehry", "Zaha Hadid", "Antoni Gaudí", "A"],
        [1, "In architectural drafting, what does an 'Elevation' drawing depict?", "A horizontal cut through the building showing room layout", "A flat vertical view of one exterior or interior side of the building", "A 3D perspective with shadows", "A structural foundation detail", "B"],
        [2, "What architectural feature characterized Gothic cathedrals and allowed for taller walls and larger stained glass windows?", "Corbel arches", "Flying buttresses", "Doric columns", "Geodesic domes", "B"],
        [2, "In sustainable tropical architecture, what is the primary benefit of installing brise-soleil (sun shades) on facades?", "Increase acoustic reverberation", "Block direct solar glare and heat gain while allowing natural ventilation", "Reinforce building shear strength", "Prevent seismic vibrations", "B"],
        [3, "Which famous residential masterpiece designed by Frank Lloyd Wright is celebrated for its cantilevered terraces over an active waterfall?", "Villa Savoye", "Fallingwater", "The Glass House", "Farnsworth House", "B"]
    ],

    // 7: BS Computer Engineering
    7 => [
        [1, "What logic gate produces a HIGH (1) output only when both of its inputs are HIGH (1)?", "OR gate", "AND gate", "XOR gate", "NOR gate", "B"],
        [1, "What is the purpose of the ALU (Arithmetic Logic Unit) inside a central microprocessor?", "Manage peripheral device power", "Perform fundamental integer arithmetic and bitwise logic operations", "Store user files permanently", "Synchronize the system clock signal", "B"],
        [2, "In embedded system design, what does an Interrupt Service Routine (ISR) do?", "Halts the microcontroller permanently", "Temporarily pauses main execution to immediately service a hardware event", "Clears cache memory on boot", "Translates assembly code to machine code", "B"],
        [2, "Which communication protocol uses two bidirectional lines called SDA (Serial Data) and SCL (Serial Clock)?", "SPI", "UART", "I2C", "CAN Bus", "C"],
        [3, "What is the primary benefit of RISC (Reduced Instruction Set Computer) architecture over CISC?", "Simpler instructions that execute in fewer clock cycles per instruction", "Larger memory footprint", "Variable-length instruction words", "Elimination of hardware registers", "A"]
    ],

    // 8: BS Nursing
    8 => [
        [1, "What is the normal resting adult pulse rate under standard physiological conditions?", "40–60 bpm", "60–100 bpm", "100–120 bpm", "120–140 bpm", "B"],
        [1, "Which of the following is considered one of the five primary vital signs assessed by nurses?", "Blood pressure", "Blood urea nitrogen", "Total cholesterol", "Serum creatinine", "A"],
        [2, "What is the first phase in the standard Five-Step Nursing Process (ADPIE)?", "Diagnosis", "Assessment", "Planning", "Implementation", "B"],
        [2, "When administering intramuscular injections into the vastus lateralis muscle, which patient population is this site most recommended for?", "Infants and young toddlers", "Elite athletes", "Elderly patients with hip replacements", "Post-operative spine patients", "A"],
        [3, "A patient receiving IV loop diuretic therapy requires close nursing surveillance for which common electrolyte imbalance?", "Hypernatremia", "Hypokalemia", "Hypercalcemia", "Hyperphosphatemia", "B"]
    ],

    // 9: BS Medical Technology
    9 => [
        [1, "In routine clinical hematology, what instrument is traditionally used to manually count blood cells under a microscope?", "Refractometer", "Hemocytometer", "Centrifuge", "Colorimeter", "B"],
        [1, "Which anticoagulant is standardly found in lavender-top evacuated blood tubes used for Complete Blood Count (CBC)?", "Sodium citrate", "EDTA (Ethylenediaminetetraacetic acid)", "Sodium fluoride", "Heparin", "B"],
        [2, "What is the primary purpose of performing an automated Crossmatching procedure in a hospital blood bank?", "Determine patient's blood cholesterol", "Ensure compatibility between donor red blood cells and recipient serum", "Measure coagulation factors", "Sterilize blood units", "B"],
        [2, "In clinical microbiology, what color do Gram-positive bacteria stain under Gram-staining protocol?", "Pink or red", "Deep violet or purple", "Bright green", "Colorless", "B"],
        [3, "An elevated serum level of Troponin I or Troponin T is a clinical laboratory biomarker primarily indicating what condition?", "Acute Myocardial Infarction (heart attack)", "Chronic renal failure", "Hepatitis C infection", "Bacterial pneumonia", "A"]
    ],

    // 10: BS Pharmacy
    10 => [
        [1, "What branch of pharmacology studies how the body affects a drug through absorption, distribution, metabolism, and excretion?", "Pharmacodynamics", "Pharmacokinetics", "Toxicology", "Pharmacogenomics", "B"],
        [1, "Which organ serves as the primary site of drug metabolism in the human body?", "Kidneys", "Liver", "Lungs", "Spleen", "B"],
        [2, "What is the meaning of the Latin medical prescription abbreviation 'b.i.d.'?", "Once daily", "Twice daily", "Three times daily", "As needed", "B"],
        [2, "Which drug interaction phenomenon occurs when two drugs with similar pharmacological actions produce an effect greater than the sum of their individual effects?", "Synergism", "Antagonism", "Tolerance", "Idiosyncrasy", "A"],
        [3, "What warning must pharmacists explicitly emphasize when dispensing a full course of systemic antibiotics to a patient?", "Discontinue as soon as symptoms subside", "Complete the full prescribed course even if symptoms resolve earlier", "Double the dosage if a day is missed", "Take solely with grapefruit juice", "B"]
    ],

    // 11: BS Physical Therapy
    11 => [
        [1, "What anatomical motion describes moving a limb away from the midline of the body?", "Adduction", "Abduction", "Flexion", "Inversion", "B"],
        [1, "What instrument is routinely used by physical therapists to measure joint range of motion (ROM)?", "Goniometer", "Dynamometer", "Stadiometer", "Pedometer", "A"],
        [2, "Which type of muscle contraction occurs when the muscle develops tension while lengthening under load?", "Concentric contraction", "Isometric contraction", "Eccentric contraction", "Isokinetic contraction", "C"],
        [2, "In post-stroke neurological rehabilitation, what is the primary objective of Constraint-Induced Movement Therapy (CIMT)?", "Rest the affected limb completely", "Encourage functional use of the impaired limb by restraining the unaffected limb", "Strengthen only cardiovascular endurance", "Prevent sensory feedback", "B"],
        [3, "The rotator cuff complex in the human shoulder is composed of four muscles. Which of the following is NOT part of the rotator cuff?", "Supraspinatus", "Infraspinatus", "Biceps brachii", "Teres minor", "C"]
    ],

    // 12: BS Radiologic Technology
    12 => [
        [1, "What form of electromagnetic radiation is utilized in conventional diagnostic radiography?", "Microwaves", "X-rays", "Radio waves", "Infrared radiation", "B"],
        [1, "In radiation safety, what fundamental principle stands for 'As Low As Reasonably Achievable'?", "ALARA", "HAZMAT", "OSHA", "RADSAFE", "A"],
        [2, "What imaging modality uses high-frequency sound waves rather than ionizing radiation to visualize soft tissues?", "Computed Tomography (CT)", "Magnetic Resonance Imaging (MRI)", "Ultrasonography", "Nuclear Medicine", "C"],
        [2, "Which contrast media agent is standardly administered orally or rectally for radiographic examinations of the gastrointestinal tract?", "Iodinated intravenous contrast", "Barium sulfate suspension", "Technetium-99m", "Gadolinium chelate", "B"],
        [3, "What lead apron thickness is standardly mandated for radiologic technologists operating during fluoroscopy procedures?", "0.05 mm lead equivalent", "0.25 mm to 0.5 mm lead equivalent", "5.0 mm lead equivalent", "10.0 mm lead equivalent", "B"]
    ],

    // 13: BS Psychology
    13 => [
        [1, "Which Austrian physician founded psychoanalysis and proposed the structure of id, ego, and superego?", "B.F. Skinner", "Sigmund Freud", "Carl Rogers", "Ivan Pavlov", "B"],
        [1, "In behavioral psychology, what type of conditioning was demonstrated by Pavlov using dogs, bells, and meat powder?", "Operant conditioning", "Classical conditioning", "Observational conditioning", "Cognitive mapping", "B"],
        [2, "What psychological term describes the mental discomfort experienced by an individual holding two contradictory beliefs or attitudes?", "Cognitive dissonance", "Confirmation bias", "Fundamental attribution error", "Self-serving bias", "A"],
        [2, "According to Abraham Maslow's Hierarchy of Needs, what need sits at the base of the pyramid?", "Self-actualization", "Physiological needs (food, water, warmth)", "Esteem needs", "Love and belonging needs", "B"],
        [3, "What clinical diagnostic manual published by the American Psychiatric Association is standardly used to classify mental disorders?", "ICD-11", "DSM-5-TR", "PDR-4", "APA Guidebook", "B"]
    ],

    // 14: BS Business Administration
    14 => [
        [1, "What does the financial acronym 'ROI' stand for in business operations?", "Rate of Inflation", "Return on Investment", "Revenue Over Income", "Risk on Insolvency", "B"],
        [1, "Which strategic marketing framework analyzes Strengths, Weaknesses, Opportunities, and Threats?", "PESTEL Analysis", "SWOT Analysis", "Porter's Five Forces", "BCG Matrix", "B"],
        [2, "What is the primary function of working capital in corporate financial management?", "Finance long-term real estate investments", "Fund daily operational activities and meet short-term debt obligations", "Distribute dividends exclusively to shareholders", "Pay corporate income taxes annually", "B"],
        [2, "In supply chain management, what does the 'Just-In-Time' (JIT) inventory strategy aim to achieve?", "Stockpile excess materials in warehouses", "Minimize holding costs by receiving goods only as they are needed in the production process", "Order inventory once every fiscal quarter", "Ensure suppliers hold full liability for freight", "B"],
        [3, "Which document summarizes a company's revenue, cost of goods sold, and operating expenses over a specific accounting period?", "Balance Sheet", "Income Statement (Profit & Loss)", "Statement of Cash Flows", "Shareholders' Equity Ledger", "B"]
    ],

    // 15: BS Accountancy
    15 => [
        [1, "What is the fundamental accounting equation?", "Assets = Liabilities - Equity", "Assets = Liabilities + Equity", "Equity = Assets + Liabilities", "Liabilities = Assets + Equity", "B"],
        [1, "In double-entry bookkeeping, an increase in an asset account is recorded as which of the following?", "A Debit", "A Credit", "A Dividend", "A Contra-revenue", "A"],
        [2, "What is the accounting process of allocating the depreciable cost of a tangible fixed asset over its estimated useful life?", "Amortization", "Depreciation", "Depletion", "Impairment", "B"],
        [2, "Which qualitative characteristic ensures financial statements are free from material error and bias?", "Verifiability", "Faithful Representation", "Timeliness", "Understandability", "B"],
        [3, "Under standard GAAP and IFRS, revenue should be recognized when which condition is fulfilled?", "When cash is received in the bank", "When performance obligations are satisfied and control transfers to the customer", "When an invoice is issued", "When a purchase order is signed", "B"]
    ],

    // 16: BS Hospitality Management
    16 => [
        [1, "What key hotel performance metric is calculated by dividing total room revenue by the total number of available rooms?", "ADR (Average Daily Rate)", "RevPAR (Revenue Per Available Room)", "GOPPAR", "Occupancy Percentage", "B"],
        [1, "What food safety management system identifies and controls biological, chemical, and physical hazards in food preparation?", "OSHA", "HACCP", "FDA 510K", "ISO 9000", "B"],
        [2, "In front office operations, what term refers to a guest who arrives at the hotel seeking accommodation without a prior booking?", "No-show", "Walk-in", "Overstay", "Sleep-out", "B"],
        [2, "What is the proper temperature danger zone for potentially hazardous foods according to standard food sanitation codes?", "0°C to 10°C", "4°C to 60°C (40°F to 140°F)", "65°C to 100°C", "-18°C to 0°C", "B"],
        [3, "In fine dining service, from which side of the guest is food traditionally served in classic American table service?", "Left side", "Right side", "Front center", "Any side depending on waiter preference", "A"]
    ],

    // 17: BS Tourism Management
    17 => [
        [1, "What specialized form of tourism focuses on visiting fragile, pristine, and relatively undisturbed natural areas?", "Heritage tourism", "Ecotourism", "Dark tourism", "Culinary tourism", "B"],
        [1, "Which specialized agency of the United Nations is responsible for the promotion of responsible and sustainable tourism?", "UNICEF", "UN Tourism (formerly UNWTO)", "UNESCO", "UNEP", "B"],
        [2, "What does the abbreviation 'GDS' stand for in travel reservation technologies?", "General Destination System", "Global Distribution System", "Geographic Direction Satellite", "Guest Domestic Service", "B"],
        [2, "In airline ticketing, what term describes a flight ticket that takes a passenger from point A to point B and back to point A?", "Open-jaw ticket", "Round-trip ticket", "Circle-trip ticket", "One-way ticket", "B"],
        [3, "What concept describes the maximum number of tourists an ecosystem or heritage site can sustain without irreversible degradation?", "Economic multiplier", "Carrying capacity", "Destination lifecycle", "Tourism yield", "B"]
    ],

    // 18: BS Real Estate Management
    18 => [
        [1, "What official document proves legal ownership and title over a parcel of real property in the Philippines?", "Tax Declaration", "Transfer Certificate of Title (TCT)", "Contract to Sell", "Building Permit", "B"],
        [1, "In property valuation, which approach estimates value by comparing recent sales prices of similar nearby properties?", "Cost Approach", "Sales Comparison (Market Data) Approach", "Income Capitalization Approach", "Residual Land Approach", "B"],
        [2, "What Philippine law, also known as the Real Estate Service Act (RESA), regulates real estate practitioners?", "Republic Act No. 9646", "Republic Act No. 7279", "Republic Act No. 6552", "Presidential Decree No. 957", "A"],
        [2, "In commercial real estate leases, what is a triple-net (NNN) lease?", "A lease where the tenant pays base rent plus property taxes, insurance, and maintenance costs", "A lease where rent is paid every three years", "A lease shared by three separate business entities", "A rent-to-own residential contract", "A"],
        [3, "What government agency in the Philippines is responsible for registering land titles and deeds?", "Land Registration Authority (LRA)", "Bureau of Internal Revenue (BIR)", "Department of Human Settlements (DHSUD)", "Department of Agrarian Reform (DAR)", "A"]
    ],

    // 19: BS Customs Administration
    19 => [
        [1, "Which government bureau in the Philippines is tasked with revenue collection from imported commodities and border border control?", "Bureau of Internal Revenue", "Bureau of Customs (BOC)", "Department of Trade and Industry", "Philippine Ports Authority", "B"],
        [1, "What international nomenclature standardized by the WCO is used worldwide to classify traded goods for tariff rates?", "Harmonized System (HS) Code", "Universal Product Code (UPC)", "Stock Keeping Unit (SKU)", "Standard Industrial Code (SIC)", "A"],
        [2, "What official document prepared by an importer declares particulars of imported goods, valuation, and duties payable?", "Bill of Lading", "Goods Declaration (Customs Entry)", "Commercial Invoice", "Certificate of Origin", "B"],
        [2, "What is the primary purpose of customs bonded warehouses (CBWs)?", "Store domestic goods for local supermarkets", "Store imported dutiable goods without paying duty until withdrawn for domestic consumption or export manufacturing", "Hold seized contraband indefinitely", "Inspect air passenger baggage exclusively", "B"],
        [3, "What comprehensive law in the Philippines governs customs modernization and tariff administration?", "Customs Modernization and Tariff Act (CMTA / RA 10863)", "TRAIN Law", "CREATE Act", "Anti-Smuggling Act of 1957", "A"]
    ],

    // 20: B Elementary Education
    20 => [
        [1, "According to Jean Piaget's cognitive development theory, which stage is typical for elementary school children (ages 7 to 11)?", "Sensorimotor stage", "Concrete operational stage", "Preoperational stage", "Formal operational stage", "B"],
        [1, "What term describes teacher assistance that supports a child's learning within their Zone of Proximal Development (ZPD)?", "Conditioning", "Scaffolding", "Assimilation", "Extinction", "B"],
        [2, "In formative classroom assessment, what is the primary purpose of providing continuous feedback during instruction?", "Assign a final letter grade for the report card", "Identify learning gaps and adjust ongoing instructional strategies", "Rank students from highest to lowest", "Determine student disciplinary measures", "B"],
        [2, "Which teaching strategy involves small groups of students working together toward a common learning objective?", "Didactic lecturing", "Cooperative learning", "Rote memorization", "Silent reading drill", "B"],
        [3, "What is phonemic awareness in early elementary literacy instruction?", "The ability to write complex sentences", "The ability to hear, identify, and manipulate individual sounds in spoken words", "The skill of memorizing whole vocabulary words by sight", "The comprehension of story themes and morality", "B"]
    ],

    // 21: B Secondary Education (English)
    21 => [
        [1, "What figure of speech makes an explicit comparison between two dissimilar things using the words 'like' or 'as'?", "Metaphor", "Simile", "Personification", "Hyperbole", "B"],
        [1, "In English grammar, what part of speech connects words, phrases, or clauses (such as 'and', 'but', 'or')?", "Preposition", "Conjunction", "Interjection", "Adverb", "B"],
        [2, "What literary term refers to the main perspective or voice through which a story is narrated?", "Point of view", "Tone", "Motif", "Allegory", "A"],
        [2, "In linguistics, what subfield studies how context influences the interpretation of meaning in communication?", "Phonetics", "Pragmatics", "Morphology", "Syntax", "B"],
        [3, "Which classic tragedy written by William Shakespeare centers on themes of vaulting ambition and regicide in Scotland?", "Hamlet", "Macbeth", "Othello", "King Lear", "B"]
    ],

    // 22: B Secondary Education (Mathematics)
    22 => [
        [1, "In Euclidean geometry, what is the sum of the interior angles of any triangle?", "90 degrees", "180 degrees", "270 degrees", "360 degrees", "B"],
        [1, "What is the derivative of the polynomial function f(x) = x³ with respect to x?", "3x²", "3x", "x²", "x⁴ / 4", "A"],
        [2, "What is the quadratic formula used to solve equations of the form ax² + bx + c = 0?", "x = (-b ± √(b² - 4ac)) / (2a)", "x = (-b ± √(b² + 4ac)) / (2a)", "x = (b ± √(b² - 4ac)) / (a)", "x = -b / (2a)", "A"],
        [2, "In trigonometry, what is the exact value of sin(30°)?", "0", "1/2", "√2/2", "√3/2", "B"],
        [3, "What mathematical property states that for real numbers a and b, a + b = b + a and a × b = b × a?", "Associative property", "Commutative property", "Distributive property", "Identity property", "B"]
    ],

    // 23: B Secondary Education (Science)
    23 => [
        [1, "What organelle is famously known as the powerhouse of eukaryotic cells due to ATP production?", "Ribosome", "Mitochondrion", "Endoplasmic reticulum", "Golgi apparatus", "B"],
        [1, "What is the chemical symbol for the element Potassium on the periodic table?", "P", "K", "Pt", "Po", "B"],
        [2, "Which of Newton's Laws of Motion states that for every action, there is an equal and opposite reaction?", "First Law", "Third Law", "Second Law", "Law of Universal Gravitation", "B"],
        [2, "In the rock cycle, what type of rock is formed from the cooling and solidification of molten magma or lava?", "Sedimentary rock", "Igneous rock", "Metamorphic rock", "Conglomerate rock", "B"],
        [3, "What biological process converts carbon dioxide and water into glucose and oxygen using solar energy?", "Cellular respiration", "Photosynthesis", "Fermentation", "Transpiration", "B"]
    ],

    // 24: B Physical Education
    24 => [
        [1, "What component of physical fitness refers to the heart and lungs' ability to supply oxygen during sustained exercise?", "Muscular strength", "Cardiorespiratory endurance", "Flexibility", "Body composition", "B"],
        [1, "What does the 'FITT' principle stand for in exercise prescription?", "Fitness, Intensity, Timing, Technique", "Frequency, Intensity, Time, Type", "Force, Interval, Tension, Training", "Fast, Isometric, Total, Target", "B"],
        [2, "In sports physiology, what energy system provides instantaneous ATP for high-intensity, short-duration activities under 10 seconds?", "ATP-PCr (Phosphagen) system", "Aerobic glycolysis", "Beta-oxidation", "Krebs cycle", "A"],
        [2, "What static stretching technique involves passively stretching a muscle to its end range and holding it for 15 to 30 seconds?", "Ballistic stretching", "Static stretching", "Dynamic stretching", "PNF stretching", "B"],
        [3, "In team sports officiating, what is the fundamental purpose of the 'rule of advantage'?", "Punish every infraction with an immediate stoppage", "Allow play to continue if stopping play would penalize the team that suffered the foul", "Ensure equal playing time for all players", "Disqualify coaches who argue with referees", "B"]
    ],

    // 25: B Special Needs Education
    25 => [
        [1, "What legal acronym designates an individualized instructional blueprint designed for a student with special educational needs?", "IEP (Individualized Education Plan)", "SAT", "GED", "ESL", "A"],
        [1, "What educational philosophy advocates educating students with disabilities in general classrooms alongside peers?", "Institutionalization", "Inclusive Education", "Segregation", "Exclusion", "B"],
        [2, "Which neurodevelopmental condition is characterized by persistent challenges in social communication and restricted, repetitive behaviors?", "Dyscalculia", "Autism Spectrum Disorder (ASD)", "Expressive aphasia", "Dysgraphia", "B"],
        [2, "What is the difference between an accommodation and a modification in special education?", "Accommodations alter what is taught; modifications alter how it is taught", "Accommodations change how a student learns; modifications change what the student is expected to learn", "They are identical terms", "Accommodations apply only during standardized exams", "B"],
        [3, "In behavioral support, what is the primary purpose of a Functional Behavior Assessment (FBA)?", "Identify the underlying purpose or trigger maintaining an undesirable behavior", "Issue administrative penalties", "Medicate the student", "Assign a permanent classroom aide", "A"]
    ],

    // 26: BA Communication
    26 => [
        [1, "In linear models of communication (such as Shannon-Weaver), what element interferes with the transmission of a message?", "Encoder", "Noise", "Feedback", "Channel", "B"],
        [1, "What ethical journalistic principle requires reporters to verify facts, cross-check sources, and present unbiased truths?", "Sensationalism", "Objectivity and Accuracy", "Clickbait", "Advocacy campaigning", "B"],
        [2, "In rhetoric, which mode of persuasion appeals to the audience's emotions, values, and sympathies?", "Logos", "Pathos", "Ethos", "Kairos", "B"],
        [2, "What mass communication theory posits that media may not tell people what to think, but tells them what to think about?", "Hypodermic Needle Theory", "Agenda-Setting Theory", "Cultivation Theory", "Spiral of Silence", "B"],
        [3, "What document sets the strategic public relations roadmap, communication objectives, key messages, and target audiences?", "PR Campaign Plan", "Press Release", "Media Kit", "Fact Sheet", "A"]
    ],

    // 27: BA Political Science
    27 => [
        [1, "Which 16th-century Italian political philosopher authored 'The Prince', analyzing political realism and power dynamics?", "John Locke", "Niccolò Machiavelli", "Thomas Hobbes", "Jean-Jacques Rousseau", "B"],
        [1, "What principle separates government powers among Executive, Legislative, and Judiciary branches to prevent tyranny?", "Checks and Balances & Separation of Powers", "Federalism", "Parliamentary Supremacy", "Totalitarianism", "A"],
        [2, "In international relations theory, what perspective emphasizes the anarchic nature of the international system and self-help state survival?", "Realism", "Liberalism", "Constructivism", "Marxism", "A"],
        [2, "What Philippine constitutional provision guarantees that no person shall be deprived of life, liberty, or property without due process of law?", "Bill of Rights (Article III, Section 1)", "Preamble", "Article VI", "Article VIII", "A"],
        [3, "What form of government is characterized by citizen participation where voters elect representatives to formulate laws and policies?", "Direct democracy", "Representative democracy (Republic)", "Autocracy", "Oligarchy", "B"]
    ],

    // 28: BA Multimedia Arts
    28 => [
        [1, "In digital design and color theory, what color model is used for screen displays consisting of red, green, and blue light?", "CMYK", "RGB", "Pantone (PMS)", "Monochrome", "B"],
        [1, "What type of digital graphics is made of mathematical vectors and can be scaled infinitely without losing quality?", "Raster (bitmap) graphics", "Vector graphics", "JPEG files", "GIF animations", "B"],
        [2, "In video production, what frame rate is traditionally standard for cinematic motion pictures?", "12 fps", "24 fps", "60 fps", "120 fps", "B"],
        [2, "According to Disney's 12 Principles of Animation, what principle gives a sense of weight, flexibility, and elasticity to drawn objects?", "Squash and Stretch", "Anticipation", "Staging", "Follow Through", "A"],
        [3, "In UI/UX design, what visual artifact represents a low-fidelity skeletal outline of a digital interface before visual styling?", "Moodboard", "Wireframe", "Color palette", "High-res mockup", "B"]
    ],

    // 29: BA History
    29 => [
        [1, "What term distinguishes firsthand evidence created during the historical period being studied (e.g. diaries, letters, official decrees)?", "Secondary source", "Primary source", "Tertiary source", "Historiographical review", "B"],
        [1, "Who is widely celebrated as the national hero of the Philippines who authored 'Noli Me Tángere' and 'El Filibusterismo'?", "Andrés Bonifacio", "Dr. José Rizal", "Emilio Aguinaldo", "Apolinario Mabini", "B"],
        [2, "In Philippine revolutionary history, what secret society was founded by Andrés Bonifacio in 1892 to gain independence from Spain?", "La Liga Filipina", "Katipunan (KKK)", "Propaganda Movement", "Hukbalahap", "B"],
        [2, "What methodology examines the writing of history, the evolution of historical interpretations, and critical source evaluation?", "Epistemology", "Historiography", "Paleontology", "Numismatics", "B"],
        [3, "What landmark event on June 12, 1898 in Kawit, Cavite marked the proclamation of Philippine independence?", "Cry of Pugad Lawin", "Declaration of Philippine Independence", "Pact of Biak-na-Bato", "Battle of Manila Bay", "B"]
    ],

    // 30: BA English Language
    30 => [
        [1, "What branch of linguistics studies the physical production, acoustic transmission, and auditory perception of human speech sounds?", "Semantics", "Phonetics", "Pragmatics", "Syntax", "B"],
        [1, "In morphological analysis, what is the smallest meaningful unit of language that cannot be divided further?", "Phoneme", "Morpheme", "Grapheme", "Lexeme", "B"],
        [2, "What linguistic subdiscipline analyzes the structural rules governing how words combine into phrases and sentences?", "Syntax", "Etymology", "Phonology", "Orthography", "A"],
        [2, "In English sociolinguistics, what term refers to a regional or social variety of a language distinguished by pronunciation, grammar, and vocabulary?", "Pidgin", "Dialect", "Idiolect", "Jargon", "B"],
        [3, "What semantic phenomenon occurs when a single lexical item possesses multiple related conceptual meanings (e.g., 'head' of a person vs. 'head' of a department)?", "Homophony", "Polysemy", "Synonymy", "Antonymy", "B"]
    ],

    // 31: BS Criminology
    31 => [
        [1, "What term refers to the scientific study of the causes, correction, and prevention of crime, and the rehabilitation of offenders?", "Criminology", "Penology", "Forensic ballistics", "Dactyloscopy", "A"],
        [1, "In criminalistics, what scientific discipline focuses on the identification of individuals through the study of friction ridge patterns on fingerprints?", "Graphology", "Dactyloscopy", "Toxicology", "Anthropometry", "B"],
        [2, "In criminal law, what Latin phrase describes the mental state of criminal intent or a guilty mind required for conviction?", "Actus reus", "Mens rea", "Corpus delicti", "Subpoena duces tecum", "B"],
        [2, "Which criminological theory posits that individuals choose to commit crime after weighing the anticipated benefits versus the potential costs and punishments?", "Biological determinism", "Rational Choice Theory", "Differential Association Theory", "Strain Theory", "B"],
        [3, "What branch of forensic science examines firearms, discharged cartridge cases, bullets, and gunshot residue at crime scenes?", "Forensic Odontology", "Forensic Ballistics", "Forensic Entomology", "Forensic Serology", "B"]
    ]
];

// 4. Insert into database
$stmt = $conn->prepare("INSERT INTO course_questions (degree_id, stage, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$total_inserted = 0;
foreach ($questions_by_degree as $deg_id => $questions) {
    foreach ($questions as $q) {
        $stage = $q[0];
        $text = $q[1];
        $a = $q[2];
        $b = $q[3];
        $c = $q[4];
        $d = $q[5];
        $ans = $q[6];
        $stmt->bind_param("iissssss", $deg_id, $stage, $text, $a, $b, $c, $d, $ans);
        if ($stmt->execute()) {
            $total_inserted++;
        }
    }
}

$stmt->close();
$conn->close();

echo "Successfully seeded $total_inserted questions across all 31 degrees in riasec_db!\n";
?>
