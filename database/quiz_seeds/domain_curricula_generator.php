<?php
/**
 * Automated Domain Curricula Generator for Degrees 10 to 50
 * Generates 50 authentic, curriculum-specific questions per degree across Stages 1 to 4.
 */

function generateDegrees10To50Curricula() {
    $out = [];

    // Master domain knowledge definitions for Degrees 10 to 50
    $profiles = [
        10 => [
            'name' => 'Bachelor of Secondary Education (BSEd)',
            'field' => 'Secondary Education and Adolescent Pedagogy',
            'terms' => [
                'Bloom\'s Revised Taxonomy', 'Adolescent Cognitive Development (Erikson)', 'Backward Design (UbD)',
                'Authentic Assessment and Rubrics', 'Inquiry-Based Learning', 'Classroom Discipline in High School',
                'Table of Specifications (TOS)', 'DepEd Grading System (DO 8, s. 2015)', 'Code of Ethics for Professional Teachers',
                'Differentiated Instruction for Teens', 'Formative vs Summative Assessment', 'Constructivist Learning Environment',
                'Universal Design for Learning (UDL)'
            ],
            'core_principles' => [
                'Learner-centered secondary pedagogy and subject specialization',
                'Aligning learning competencies with high-order cognitive evaluation',
                'Scaffolding abstract conceptual frameworks for adolescent learners',
                'Developing metacognitive strategies for independent student study',
                'Formulating criterion-referenced assessment rubrics for projects',
                'Integrating educational technology into subject-specific instruction',
                'Facilitating critical debate and respectful classroom discourse',
                'Maintaining professional teacher-student boundaries under the Code of Ethics',
                'Applying pedagogical content knowledge (PCK) in specialized domains',
                'Conducting diagnostic pre-assessments to identify learning gaps',
                'Fostering intrinsic motivation and growth mindset in high schoolers',
                'Utilizing cooperative learning structures with individual accountability',
                'Designing culturally responsive teaching units for diverse learners'
            ],
            'scenario_types' => [
                'A high school science class consistently struggles with analyzing lab experiment data',
                'A secondary English teacher notices widespread plagiarism in term papers',
                'Several Grade 10 students disengage during lectures on abstract mathematics',
                'A teacher faces conflicting grading criteria between project outputs and written exams',
                'Adolescent peer conflicts disrupt collaborative group presentations',
                'A student with moderate test anxiety underperforms on high-stakes timed tests',
                'Designing a remediation module for students who failed the mid-quarter assessment',
                'Evaluating student multimedia presentations using a multi-criteria analytic rubric',
                'Handling controversial social issues during high school social studies seminars',
                'Structuring a debate where opposing student groups maintain academic decorum',
                'Adapting a heavy chemistry curriculum for students with mixed reading levels',
                'Calculating final quarterly grades under the DepEd weighted formula accurately'
            ],
            'advanced_standards' => [
                'Philippine Professional Standards for Teachers (PPST) Career Stages',
                'Curriculum design under DepEd K to 12 Enhanced Basic Education Act (RA 10533)',
                'Classroom Action Research methodology for instructional intervention',
                'Legal accountability of teachers under in loco parentis doctrine',
                'Child Protection Policy and anti-bullying compliance (RA 10627)',
                'Standardized assessment analysis (NAT and international PISA/TIMSS benchmarks)',
                'Curriculum mapping and horizontal/vertical articulation across grade levels',
                'Ethics in student records management and the Data Privacy Act (RA 10173)',
                'Integrating Education for Sustainable Development (ESD) across secondary subjects',
                'Designing multidisciplinary capstone research projects for Senior High School',
                'Professional learning communities (PLC) and peer instructional coaching',
                'Special education mainstreaming and inclusive education policy implementation'
            ]
        ],

        11 => [
            'name' => 'Bachelor of Early Childhood Education',
            'field' => 'Early Childhood Development and Preschool Pedagogy',
            'terms' => [
                'Developmentally Appropriate Practice (DAP)', 'Sensory-Motor Play Milestones', 'Montessori Sensory Materials',
                'Reggio Emilia Environment Concept', 'Early Childhood Care and Development (ECCD)', 'Anecdotal Record Observation',
                'Phonological Awareness in Toddlers', 'Fine and Gross Motor Integration', 'Emotional Self-Regulation Strategies',
                'Emergent Literacy and Print Awareness', 'Parent-Teacher Collaborative Partnerships', 'Learning Centers & Play Corners',
                'Executive Functioning in Early Years'
            ],
            'core_principles' => [
                'Child-centered play as the primary vehicle for early childhood learning',
                'Holistic physical, socio-emotional, and cognitive developmental tracking',
                'Scaffolding language acquisition through immersive storytelling and rhymes',
                'Creating safe, aesthetically stimulating, and accessible learning spaces',
                'Implementing positive discipline and emotional labeling for toddler tantrums',
                'Utilizing hands-on manipulatives before introducing symbolic numbers or letters',
                'Respecting individual developmental timetables without premature academic pressure',
                'Observing and documenting authentic child behaviors through portfolio collection',
                'Fostering curiosity and autonomous discovery through sensory exploration',
                'Establishing predictable daily routines to promote toddler emotional security',
                'Integrating family and community culture into preschool learning themes',
                'Promoting peer socialization, sharing, and empathetic conflict resolution',
                'Identifying early developmental delays for timely early intervention referral'
            ],
            'scenario_types' => [
                'A 4-year-old child experiences severe separation anxiety during morning drop-off',
                'Two toddlers engage in a physical conflict over a single wooden puzzle',
                'A preschooler refuses to participate in circle time and sits alone in the corner',
                'Designing a sensory motor obstacle course for gross motor coordination',
                'A parent requests formal written homework sheets for a 3-year-old child',
                'Observing a child who exhibits delayed expressive vocabulary compared to peers',
                'Structuring transition times between messy art activities and quiet reading',
                'Assessing fine motor pencil grip readiness using developmentally appropriate tools',
                'Addressing tactile defensiveness in a child during finger-painting sessions',
                'Creating an inclusive play center for a young child with physical mobility challenges',
                'Managing a classroom snack routine that reinforces autonomy and hygiene habits',
                'Conducting an ECCD checklist assessment session with an anxious young learner'
            ],
            'advanced_standards' => [
                'National Early Learning Framework (NELF) standards and competencies',
                'Early Years Act of 2013 (Republic Act No. 10410) policy implementation',
                'Ethical guidelines of the National Association for the Education of Young Children (NAEYC)',
                'Screening protocols for neurodevelopmental and sensory processing disorders',
                'Designing universal preschool screening and transition programs into kindergarten',
                'Child rights advocacy and protection protocols under RA 7610',
                'Evidence-based research on brain architecture and neuroplasticity in early years',
                'Preschool leadership, licensing, and facility safety accreditation standards',
                'Designing home-school intervention packages for at-risk developmental profiles',
                'Evaluation of commercial preschool curricula against developmental appropriateness',
                'Professional ethics regarding child observation confidentiality and parental consent',
                'Continuous professional development in pediatric psychology and trauma-informed care'
            ]
        ],

        12 => [
            'name' => 'Bachelor of Physical Education',
            'field' => 'Physical Education, Sports Science & Human Movement',
            'terms' => [
                'FITT Principle (Frequency, Intensity, Time, Type)', 'Aerobic vs Anaerobic Energy Systems (ATP-PC, Glycolytic)',
                'Biomechanics of Human Movement', 'PRICE Protocol for Sports Injuries', 'Cardiovascular Endurance Testing (Beep Test)',
                'Motor Learning Stages (Cognitive, Associative, Autonomous)', 'Sports Officiating Rules and Ethics',
                'Body Mass Index and Body Composition', 'Kinematics of Sprinting and Jumping', 'Flexibility and Goniometric Measurement',
                'Physical Literacy and Lifelong Fitness', 'Hydration and Heat Exhaustion Prevention', 'Periodization of Athletic Training'
            ],
            'core_principles' => [
                'Promoting lifelong physical activity, motor competency, and health-related fitness',
                'Applying anatomical and biomechanical principles to optimize athletic performance',
                'Progressive overload and specificity principles in exercise prescription',
                'Structuring safe warm-up, dynamic stretching, and cooldown sequences',
                'Teaching sportsmanship, teamwork, and fair play values through athletic games',
                'Differentiating physical drills to accommodate varying student fitness levels',
                'Executing prompt first aid protocols for acute sprains, strains, and contusions',
                'Measuring physiological adaptations to cardiorespiratory and muscular training',
                'Analyzing human gait, posture, and kinetic chain alignment during movement',
                'Designing inclusive physical education activities for students with disabilities',
                'Utilizing objective fitness rubrics and authentic skill assessment stations',
                'Enforcing sports safety standards and equipment inspections across facilities',
                'Coaching tactics, strategies, and psychological readiness in team sports'
            ],
            'scenario_types' => [
                'A student collapses with signs of heat exhaustion during an outdoor afternoon track drill',
                'An overweight high school student feels embarrassed to participate in fitness testing',
                'A basketball player suffers an acute lateral ankle sprain during a scrimmage game',
                'Calculating target heart rate training zones using the Karvonen formula for a 16-year-old',
                'Adapting a high-intensity volleyball unit for an asthmatic student',
                'Addressing unsportsmanlike conduct and verbal taunting between rival intramural teams',
                'Correcting improper lifting posture and lumbar rounding during weight training class',
                'Structuring a 6-week progressive cardiorespiratory training program for sedentary youth',
                'Evaluating fundamental movement skills (throwing, catching, striking) using rubric checklists',
                'Managing large PE classes (50+ students) with limited gym space and sports equipment',
                'Designing a low-impact aquatic or chair-exercise module for mobility-impaired learners',
                'Resolving a contested out-of-bounds call while officiating a championship soccer match'
            ],
            'advanced_standards' => [
                'CHED Memorandum Order governing the Bachelor of Physical Education curriculum',
                'World Health Organization (WHO) physical activity guidelines across the lifespan',
                'Biomechanics and ergonomic standards in preventing sports-related microtrauma',
                'Exercise physiology research on pediatric cardiovascular adaptations',
                'Legal liability and risk management protocols for athletic directors and PE teachers',
                'Anti-doping regulations under the World Anti-Doping Agency (WADA) code',
                'Adapted Physical Education (APE) legal mandates and IEP fitness adaptations',
                'Sports psychology interventions: visualization, arousal control, and self-efficacy',
                'Sports tournament scheduling algorithms (single elimination, double elimination, round-robin)',
                'Kinanthropometry and athletic talent identification screening protocols',
                'Ethics in competitive sports coaching and athlete safeguarding from harassment',
                'Community wellness and public health campaign development frameworks'
            ]
        ],

        13 => [
            'name' => 'Bachelor of Special Needs Education',
            'field' => 'Special Needs and Inclusive Education',
            'terms' => [
                'Individualized Education Program (IEP)', 'Autism Spectrum Disorder (ASD) Interventions',
                'Universal Design for Learning (UDL)', 'Least Restrictive Environment (LRE)', 'Assistive Learning Technology',
                'Applied Behavior Analysis (ABA)', 'Braille Literacy and Orientation & Mobility', 'Filipino Sign Language (FSL) Basics',
                'Sensory Integration Dysfunction', 'Attention Deficit Hyperactivity Disorder (ADHD) Accommodations',
                'Intellectual Disability Functional Academics', 'Transition Planning into Adulthood', 'Differentiated Evaluation Protocols'
            ],
            'core_principles' => [
                'Formulating measurable, individualized annual goals within multidisciplinary IEPs',
                'Creating accessible physical and digital learning materials across modalities',
                'Utilizing positive behavioral intervention supports (PBIS) for challenging behaviors',
                'Modifying general education curricula without compromising core concepts',
                'Fostering peer empathy, social inclusion, and neurodiversity acceptance',
                'Collaborating closely with occupational, speech, and physical therapists',
                'Structuring visual schedules, sensory cool-down corners, and predictable routines',
                'Teaching functional life skills, self-advocacy, and vocational competencies',
                'Implementing prompt fading and task analysis for complex multistep skills',
                'Employing high-tech and low-tech augmentative and alternative communication (AAC)',
                'Conducting ecological assessments to evaluate student performance across settings',
                'Ensuring non-discriminatory assessment and culturally sensitive evaluation',
                'Supporting family empowerment and educational rights awareness'
            ],
            'scenario_types' => [
                'A child with autism exhibits severe sensory overload during a loud school assembly',
                'A visually impaired learner needs immediate adaptation for visual math geometry diagrams',
                'A student with ADHD cannot maintain focus during independent seatwork sessions',
                'Conducting an IEP meeting where parents disagree with the proposed resource room placement',
                'A non-verbal pupil uses a picture exchange communication system (PECS) to request items',
                'A student with cerebral palsy requires assistive technology for typing and communication',
                'Breaking down a complex grooming or cooking task into sequential micro-steps',
                'Handling aggressive self-injurious behavior safely and recording Antecedent-Behavior-Consequence (ABC) data',
                'Designing a co-teaching lesson plan with a mainstream general education high school teacher',
                'Transitioning a young adult with Down syndrome into a supported community employment role',
                'Modifying high-stakes exam questions into accessible simplified formats with extra time',
                'Facilitating social interactions between neurotypical peers and special needs classmates'
            ],
            'advanced_standards' => [
                'Republic Act No. 11650 (Instituting a Policy of Inclusion and Services for Learners with Disabilities)',
                'UN Convention on the Rights of Persons with Disabilities (UNCRPD) mandates',
                'Psychometric standards in diagnosing learning disabilities and cognitive profiles',
                'Special education legal protections, procedural due process, and parental rights',
                'Advanced behavior intervention plans (BIP) and functional behavior assessments (FBA)',
                'Neurodevelopmental genetics and etiology of childhood neurological conditions',
                'Universal Design for Learning guidelines by CAST: Multiple Means of Representation/Action',
                'Deaf culture and bilingual-bicultural Deaf education frameworks',
                'Curriculum adaptation for severe and multiple disabilities (SAMD)',
                'Ethics in administering psychoeducational diagnostic test batteries',
                'Transition services policy from school to independent living and vocational placement',
                'Inclusive school leadership, resource room management, and advocacy'
            ]
        ],

        14 => [
            'name' => 'Bachelor of Technology and Livelihood Education',
            'field' => 'Technology, Livelihood & Technical-Vocational Education',
            'terms' => [
                'Four Areas of TLE (HE, IA, AFA, ICT)', 'Occupational Safety and Health (OSH) & PPE',
                'HACCP Food Safety and Sanitation Standards', 'Technical Drafting and Orthographic Projection',
                'Electrical Wiring Standards & Safety (PEC)', 'Woodworking Joinery and Power Tool Operations',
                'Garment Construction and Pattern Drafting', 'Small Business Costing and Pricing in Vocational Trades',
                'TESDA Training Regulations (TR) & Competency Assessment', 'Aquaponics and Urban Agriculture Techniques',
                'Computer Hardware Servicing (CHS)', 'Preventive Maintenance of Workshop Machinery', 'Entrepreneurship in Trade Skills'
            ],
            'core_principles' => [
                'Competency-based training and experiential vocational skill acquisition',
                'Strict compliance with workshop hazard prevention and industrial hygiene standards',
                'Integrating entrepreneurial mindset and micro-business planning into trade projects',
                'Teaching precision technical drawing, blueprint reading, and measurement tolerances',
                'Mastering standard culinary preparation, knife skills, and food cost calculations',
                'Applying fundamental electrical principles safely in residential wiring installations',
                'Operating industrial machinery, wood lathes, and power equipment with guarding protocols',
                'Developing sustainable agricultural practices and urban container gardening',
                'Troubleshooting PC hardware, operating system installations, and local networks',
                'Utilizing competency rubrics and performance checklists aligned with TESDA NC levels',
                'Fostering craftsmanship, environmental sustainability, and material waste reduction',
                'Designing modular vocational learning packages for secondary livelihood education',
                'Aligning trade curriculum with local industry manpower needs and employment pathways'
            ],
            'scenario_types' => [
                'A student experiences a minor electrical shock from an ungrounded drill in the carpentry shop',
                'A commercial cookery batch of chicken mayonnaise violates safe temperature holding guidelines',
                'Drafting a 3-view orthographic drawing of an isometric mechanical machine bracket',
                'Calculating selling price per piece for handmade baked goods factoring labor, overhead, and margin',
                'Troubleshooting a desktop PC that fails to POST (Power-On Self-Test) with continuous beeps',
                'A student cuts fabric incorrectly due to failing to align pattern grainlines with the selvage',
                'Designing an automated drip irrigation setup for a school greenhouse vegetable patch',
                'Wiring a residential duplex convenience outlet and single-pole switch control according to code',
                'Managing flammable chemical storage (thinners, lacquers, solvents) in an industrial arts lab',
                'Conducting a pre-assessment mock evaluation for TESDA National Certificate (NC II)',
                'A welding student notices excessive porosity in an arc-welded steel joint',
                'Creating an eco-friendly upcycled wood product line from discarded wooden pallets'
            ],
            'advanced_standards' => [
                'TESDA Training Regulations (TR) and Competency-Based Assessment System',
                'Occupational Safety and Health Standards (OSHS) by the Department of Labor and Employment',
                'Philippine Electrical Code (PEC) guidelines for low-voltage residential branch circuits',
                'Food and Drug Administration (FDA) sanitation guidelines and commercial kitchen codes',
                'Curriculum integration of Industry 4.0 automation and CNC machining in vocational education',
                'Design thinking and sustainable product lifecycle analysis in industrial technology',
                'Management of vocational school production units and enterprise incubation hubs',
                'Intellectual property rights and trademark registration for student vocational inventions',
                'Quality control systems (ISO 9001) applied to technical-vocational workshop operations',
                'Environmental waste disposal standards for electronic and chemical workshop hazards (RA 6969)',
                'International TVET frameworks and cross-border skills mobility standards (ASEAN Qualifications)',
                'Ethics in client billing, trade warranty execution, and fair labor practices'
            ]
        ],

        // --- IT AND COMPUTING (15 to 19) ---
        15 => [
            'name' => 'BS Information Technology',
            'field' => 'Information Technology, Infrastructure & Networking',
            'terms' => [
                'OSI and TCP/IP Networking Models', 'IPv4 Subnetting & CIDR Calculation', 'DNS, DHCP & Active Directory Services',
                'Relational Database SQL (SELECT, JOIN, GROUP BY)', 'Symmetric vs Asymmetric Encryption (AES, RSA)',
                'Linux Terminal Administration (chmod, chown, grep)', 'Web Application Stacks (LAMP, MERN)',
                'Cloud Infrastructure (IaaS, PaaS, SaaS)', 'Cybersecurity CIA Triad (Confidentiality, Integrity, Availability)',
                'Virtualization vs Docker Containers', 'IT Service Management (ITIL Framework)',
                'Firewalls, VPNs & Network Access Control', 'Disaster Recovery: RPO and RTO Metrics'
            ],
            'core_principles' => [
                'Architecting scalable, resilient, and secure enterprise IT infrastructure',
                'Configuring switching, VLAN segmentation, and dynamic routing protocols (OSPF)',
                'Deploying relational and NoSQL database schemas with proper indexing',
                'Automating system administration tasks using shell and PowerShell scripts',
                'Enforcing principle of least privilege and zero-trust security postures',
                'Managing full-stack web and mobile application deployment pipelines',
                'Monitoring server uptime, load balancing, and network bandwidth utilization',
                'Implementing multi-layered defense-in-depth against malware and phishing',
                'Containerizing microservices and orchestrating workloads with Kubernetes',
                'Establishing automated backup schedules and offsite cloud replication',
                'Managing IT helpdesk incidents, service requests, and SLA compliance',
                'Conducting vulnerability assessments and patch management lifecycles',
                'Adhering to data privacy regulations and enterprise security governance'
            ],
            'scenario_types' => [
                'A network engineer needs to allocate subnets for 5 departments from a 192.168.1.0/24 address block',
                'A web server experiences 100% CPU utilization and unresponsiveness during a sudden traffic surge',
                'Employees report intermittent internet loss after a rogue DHCP server connects to the LAN switch',
                'A database query takes 45 seconds to return records from a 2-million-row customer table',
                'A remote branch office needs a secure encrypted tunnel to connect to corporate headquarters',
                'Configuring file permissions on a shared Linux directory so marketing can write while guests only read',
                'A critical production server crashes; the backup system restores data with an RPO of 15 minutes',
                'A user clicks a malicious email link, triggering ransomware that begins encrypting shared drives',
                'Migrating a legacy monolithic desktop accounting tool to a multi-tenant cloud SaaS platform',
                'Setting up an SSL/TLS certificate on an Nginx reverse proxy to achieve HTTPS grade A compliance',
                'Troubleshooting packet loss and high latency between two campus buildings over fiber connections',
                'Designing a disaster recovery plan that guarantees system restoration within an RTO of 2 hours'
            ],
            'advanced_standards' => [
                'National Privacy Commission (NPC) and Data Privacy Act of 2012 (RA 10173) compliance',
                'ISO/IEC 27001 Information Security Management System (ISMS) controls',
                'NIST Cybersecurity Framework (Identify, Protect, Detect, Respond, Recover)',
                'ITIL v4 Service Value System and Continuous Service Improvement',
                'Enterprise cloud architecture patterns (Multi-cloud, Hybrid cloud, High Availability)',
                'SOC 2 Type II trust criteria and third-party vendor security audits',
                'DevSecOps pipeline integration with automated static/dynamic code scanning',
                'Zero Trust Architecture (ZTA) standards under NIST SP 800-207',
                'Software Defined Networking (SDN) and Network Function Virtualization (NFV)',
                'Digital forensics evidence acquisition guidelines (chain of custody, bitstream imaging)',
                'Payment Card Industry Data Security Standard (PCI-DSS) for electronic commerce',
                'Business continuity planning (ISO 22301) and operational risk governance'
            ]
        ],

        16 => [
            'name' => 'BS Computer Science',
            'field' => 'Computer Science, Algorithms & Theory of Computation',
            'terms' => [
                'Asymptotic Analysis & Big-O Notation', 'Linear vs Non-linear Data Structures (Trees, Graphs)',
                'Stack (LIFO) and Queue (FIFO) Implementations', 'Binary Search Trees & Self-Balancing Trees (AVL, Red-Black)',
                'Dijkstra\'s & A* Shortest Path Algorithms', 'Dynamic Programming & Memoization',
                'Turing Machines & Computability Theory', 'Context-Free Grammars & Parsing Algorithms',
                'Operating System Deadlock (Coffman Conditions)', 'Virtual Memory Paging & Cache Replacement (LRU)',
                'Discrete Mathematics & Graph Theory', 'Cryptographic Hashing (SHA-256) vs Asymmetric RSA',
                'NP-Complete Problems (Traveling Salesperson)'
            ],
            'core_principles' => [
                'Designing efficient algorithms and mathematically proving their time/space bounds',
                'Implementing robust object-oriented, functional, and imperative software architectures',
                'Formal verification of computational correctness and loop invariants',
                'Optimizing recursive algorithms using bottom-up tabulation and top-down memoization',
                'Managing concurrency, thread synchronization, mutexes, and race conditions',
                'Analyzing compiler construction phases: lexical analysis, AST generation, code emission',
                'Traversing complex graph networks via Breadth-First Search (BFS) and Depth-First Search (DFS)',
                'Structuring database internal indexing using B-Trees and Hash Index structures',
                'Understanding finite automata, regular expressions, and Chomsky grammar hierarchy',
                'Managing memory hierarchies, cache line misses, and virtual page fault mechanisms',
                'Applying discrete probability, combinatorics, and modular arithmetic to cryptography',
                'Developing distributed consensus protocols (Raft, Paxos) in network topologies',
                'Classifying algorithmic tractability into P, NP, NP-Hard, and NP-Complete classes'
            ],
            'scenario_types' => [
                'A programmer needs to search for an item in a sorted array of 1,000,000 integers in minimum time',
                'A recursive Fibonacci function experiences exponential time O(2^n); refactoring it to linear time',
                'Two concurrent threads freeze permanently while competing for shared database resources',
                'An application experiences memory leaks in C++ due to unmanaged heap allocations',
                'Building a GPS navigation pathfinder to find the absolute shortest driving distance between cities',
                'Detecting cycles in a directed graph representing module dependencies in a build system',
                'A web crawler needs to traverse billions of URLs without revisiting duplicates in limited RAM',
                'Implementing an LRU (Least Recently Used) cache with O(1) get and put operations',
                'Analyzing whether a proposed polynomial-time reduction solves a known NP-complete problem',
                'Optimizing matrix multiplication using Strassen\'s divide-and-conquer approach',
                'Designing a lexer and parser to evaluate mathematical expressions with operator precedence',
                'Balancing a binary search tree after successive insertions to prevent O(n) degeneration'
            ],
            'advanced_standards' => [
                'ACM/IEEE Computer Science Curricula Guidelines and Competency Standards',
                'P vs NP Millennium Prize Problem formulations and computational complexity theory',
                'Asymptotic lower bound proofs using adversary arguments and decision trees',
                'Byzantine Fault Tolerance and decentralized consensus algorithms',
                'Quantum computing algorithms: Shor\'s factoring and Grover\'s search algorithms',
                'Compiler optimization techniques: loop unrolling, register allocation, SSA form',
                'Formal methods: Hoare logic, model checking, and Z specification language',
                'Advanced cryptographic protocols: Zero-Knowledge Proofs and Homomorphic Encryption',
                'Deep learning neural network backpropagation mathematics and gradient descent proofs',
                'Memory consistency models: Sequential Consistency vs Release Consistency',
                'Lock-free data structures using atomic Compare-And-Swap (CAS) primitives',
                'ACM Code of Ethics and Professional Conduct for Computing Professionals'
            ]
        ],

        17 => [
            'name' => 'BS Information Systems',
            'field' => 'Enterprise Information Systems, Business Process & Analytics',
            'terms' => [
                'Enterprise Resource Planning (ERP Modules)', 'Systems Development Life Cycle (SDLC)',
                'Agile Scrum Ceremonies (Sprint, Standup, Review)', 'Entity Relationship Diagrams (ERD) & 3NF Normalization',
                'Business Process Model and Notation (BPMN)', 'Decision Support Systems (DSS & BI Dashboards)',
                'IT Governance Frameworks (COBIT, ITIL)', 'Data Warehousing & ETL Data Pipelines',
                'Cloud Computing Deployment Models (Public, Private, Hybrid)', 'Supply Chain Management (SCM) Systems',
                'Customer Relationship Management (CRM)', 'Change Management in Enterprise Tech Adoption',
                'Big Data Analytics & Predictive Modeling'
            ],
            'core_principles' => [
                'Bridging organizational business requirements with technological software architectures',
                'Modeling, analyzing, and reengineering core business workflows using standard BPMN',
                'Designing normalized, high-performance relational schemas for transactional databases',
                'Implementing enterprise governance to align IT strategy with corporate profitability',
                'Facilitating Agile iterative development, user story mapping, and sprint backlogs',
                'Extracting, transforming, and loading cross-departmental data into unified warehouses',
                'Evaluating total cost of ownership (TCO) and return on investment (ROI) for IT solutions',
                'Managing stakeholder expectations and organizational resistance during system rollouts',
                'Configuring automated business intelligence dashboards for executive decision support',
                'Securing enterprise information assets and ensuring audit regulatory compliance',
                'Architecting seamless API integration between legacy systems and modern SaaS platforms',
                'Conducting feasibility studies (technical, economic, operational) for enterprise systems',
                'Optimizing supply chain visibility through real-time logistics tracking systems'
            ],
            'scenario_types' => [
                'A retail corporation suffers inventory discrepancies between online web orders and physical stores',
                'Drafting a BPMN diagram to streamline an inefficient 8-step employee expense approval process',
                'Normalizing an unorganized sales spreadsheet with redundant customer data into Third Normal Form (3NF)',
                'Selecting between purchasing a commercial off-the-shelf ERP versus building a custom solution',
                'A manufacturing firm needs a Decision Support System to forecast raw material demand fluctuations',
                'Managing an Agile sprint where user story scope creep threatens the scheduled release date',
                'Designing a star schema data warehouse with fact and dimension tables for retail analytics',
                'A hospital system encounters major physician resistance when transitioning to electronic health records',
                'Auditing IT controls using COBIT 2019 to identify vulnerabilities in financial transaction authorizations',
                'A bank plans a major cloud migration and must evaluate regulatory compliance regarding customer data storage',
                'Implementing a CRM pipeline that automatically tracks lead conversion rates and sales velocity',
                'Conducting an economic feasibility analysis using Net Present Value for a $500,000 software upgrade'
            ],
            'advanced_standards' => [
                'ISACA COBIT 2019 Enterprise IT Governance Framework',
                'TOGAF (The Open Group Architecture Framework) for Enterprise Architecture',
                'Project Management Institute (PMI) PMBOK and Agile Practice Standards',
                'Data Management Association (DAMA-DMBOK) Data Governance Standards',
                'ISO/IEC 38500 Corporate Governance of Information Technology',
                'Sarbanes-Oxley Act (SOX) Section 404 IT General Controls compliance',
                'Enterprise Data Security and Privacy regulations under the Philippine Data Privacy Act',
                'Business Process Reengineering (BPR) methodology by Hammer and Champy',
                'Predictive analytics, machine learning integration, and data lake architectures',
                'Software asset management (SAM) and cloud multi-tenant SLA management',
                'Disaster recovery and business impact analysis (BIA) for critical enterprise databases',
                'Ethical leadership, artificial intelligence governance, and corporate accountability'
            ]
        ],

        18 => [
            'name' => 'BS Computer Engineering',
            'field' => 'Computer Engineering, Hardware Architecture & Embedded Systems',
            'terms' => [
                'Digital Logic Gates & Boolean Algebra', 'Karnaugh Maps (K-Maps) Minimization',
                'Microprocessors vs Microcontrollers', 'Von Neumann vs Harvard Computer Architecture',
                'Instruction Pipelining Hazards (Data, Structural, Control)', 'Assembly Language Programming (x86/ARM)',
                'Analog-to-Digital Conversion (ADC) & Sampling', 'Interrupt Service Routines (ISR)',
                'Embedded C Programming for Microcontrollers', 'FPGA Architecture & Verilog/VHDL Hardware Description',
                'Printed Circuit Board (PCB) Design & Schematics', 'IoT Sensors & Serial Communication (I2C, SPI, UART)',
                'Memory Hierarchy & Cache Coherence (MESI Protocol)'
            ],
            'core_principles' => [
                'Synthesizing combinational and sequential digital logic circuits from truth tables',
                'Architecting CPU datapaths, control units, arithmetic logic units (ALU), and registers',
                'Interfacing microcontrollers with physical sensors, actuators, and analog peripherals',
                'Writing optimized, deterministic bare-metal code for real-time embedded systems',
                'Minimizing pipeline stalls through branch prediction and forwarding/bypassing techniques',
                'Designing hardware-accelerated processing blocks using FPGA Verilog/VHDL description',
                'Routing multi-layer printed circuit boards ensuring signal integrity and minimal EMI',
                'Implementing asynchronous and synchronous serial communication protocols (I2C, SPI)',
                'Managing hardware interrupts and prioritizing time-critical embedded task execution',
                'Analyzing semiconductor logic families (TTL, CMOS) regarding voltage, speed, and power',
                'Developing Internet of Things (IoT) edge computing nodes with low-power sleep modes',
                'Debugging hardware timing violations, propagation delays, and clock skew issues',
                'Adhering to electrical safety standards and computer engineering professional ethics'
            ],
            'scenario_types' => [
                'Designing a digital combinational logic circuit that controls a 4-way traffic light intersection',
                'Minimizing a 4-variable Boolean logic function using a Karnaugh map to reduce gate count',
                'An embedded microcontroller system misses sensor readings due to blocking delay functions in the main loop',
                'A CPU execution pipeline stalls for 3 clock cycles due to a Read-After-Write (RAW) data hazard',
                'Connecting an analog temperature sensor to a 10-bit ADC and calculating temperature from voltage',
                'Interfacing an OLED display and an accelerometer on the same I2C bus with distinct slave addresses',
                'A microcontroller draws excessive battery current; configuring deep sleep modes and wake-on-interrupt',
                'Writing an ARM assembly subroutine to perform fast array sum calculations using registers',
                'Synthesizing a digital frequency divider on a Xilinx FPGA board using Verilog HDL',
                'Debugging ringing noise and electromagnetic interference on high-speed PCB clock traces',
                'Configuring a watchdog timer (WDT) to automatically reboot an unattended remote weather station upon freeze',
                'Designing a dual-port RAM interface ensuring data integrity during simultaneous read/write requests'
            ],
            'advanced_standards' => [
                'IEEE Computer Society and ACM Curriculum Guidelines for Computer Engineering',
                'Philippine Electronics Code and Professional Computer Engineering practice standards',
                'Real-Time Operating Systems (RTOS) scheduling algorithms (Rate-Monotonic, Earliest-Deadline)',
                'Very Large Scale Integration (VLSI) CMOS layout rules and propagation delay modeling',
                'Hardware security: Physical Unclonable Functions (PUF) and side-channel attack countermeasures',
                'Automotive embedded safety standards (ISO 26262 ASIL ratings and CAN bus protocols)',
                'RISC-V open standard instruction set architecture design and hardware extensions',
                'System-on-Chip (SoC) design methodologies and AMBA bus interconnect standards',
                'High-performance computing (HPC) parallel architectures and GPU CUDA thread scheduling',
                'Signal Integrity (SI) and Power Integrity (PI) simulations for gigahertz circuit boards',
                'Environmental compliance for electronic hardware (RoHS, WEEE directives)',
                'Code of Ethics for Professional Computer Engineers in design safety and public welfare'
            ]
        ],

        19 => [
            'name' => 'BS Entertainment and Multimedia Computing',
            'field' => 'Game Development, Computer Graphics & Interactive Media',
            'terms' => [
                'Game Loop Architecture (Process Input, Update, Render)', '2D & 3D Graphics Rendering Pipeline',
                'Collision Detection (AABB, Raycasting, SAT)', 'Game Physics Simulation (Rigidbodies, Friction, Gravity)',
                'Shader Programming (Vertex & Fragment/Pixel Shaders)', 'Frame Rate & Draw Call Optimization',
                'Finite State Machines (FSM) for Non-Player Character (NPC) AI', 'UI/UX Design for Interactive Games & Apps',
                'Audio Engineering & 3D Spatial Audio Integration', 'Game Engine Scripting (Unity C#, Unreal C++/Blueprints)',
                'Sprite Animation & 3D Skeletal Rigging', 'Virtual Reality (VR) & Augmented Reality (AR) Mechanics',
                'Game Monetization & Core Engagement Loops'
            ],
            'core_principles' => [
                'Structuring modular, high-performance game loops operating at stable 60+ FPS',
                'Implementing mathematical transformations (vectors, matrices, quaternions) for 3D worlds',
                'Writing custom shader programs to simulate realistic lighting, water, and shadow effects',
                'Calculating accurate physical collisions, elastic impacts, and ragdoll kinematics',
                'Designing intuitive user interfaces, HUDs, and responsive interactive menu systems',
                'Scripting intelligent NPC behaviors using state machines, behavior trees, and NavMesh pathfinding',
                'Optimizing texture atlases, 3D polygon counts, and level of detail (LOD) for mobile hardware',
                'Integrating immersive 3D spatialized sound effects and adaptive background soundtracks',
                'Designing balanced gameplay mechanics, progression curves, and rewarding player feedback',
                'Architecting multiplayer client-server synchronization, latency compensation, and interpolation',
                'Developing cross-platform interactive multimedia experiences for PC, mobile, and VR headsets',
                'Executing version control workflows (Git LFS, Perforce) for large multimedia binary assets',
                'Adhering to intellectual property laws, licensing, and ethical game design standards'
            ],
            'scenario_types' => [
                'A 3D mobile game experiences severe lag and frame rate drops below 20 FPS during combat scenes',
                'A player character falls through the floor terrain when moving at high speeds; fixing collision tunneling',
                'Writing a fragment shader in GLSL/HLSL to create a glowing cartoon outline (cel-shading) effect',
                'An NPC guard needs to patrol waypoints, chase the player on sight, and search when lost using a Behavior Tree',
                'Designing a smooth third-person camera system using quaternions to prevent gimbal lock rotations',
                'Optimizing 500 individual 3D tree models in a forest scene using dynamic Level of Detail (LOD)',
                'Synchronizing player positions in an online multiplayer game using client-side prediction and dead reckoning',
                'Balancing a weapon damage system where one gun type completely dominates competitive matches',
                'A VR application causes motion sickness; modifying movement mechanics from smooth locomotion to teleportation',
                'Managing memory footprint when loading 4K textures on mobile devices using ASTC texture compression',
                'Implementing raycasting from the mouse cursor into 3D world space to select and move tactical units',
                'Designing an onboarding tutorial level that teaches mechanics implicitly without intrusive text walls'
            ],
            'advanced_standards' => [
                'IGDA (International Game Developers Association) Best Practices and Ethics Code',
                'Real-time computer graphics mathematics: Bidirectional Reflectance Distribution Functions (BRDF)',
                'Modern low-level graphics APIs: Vulkan, DirectX 12, and Metal architecture',
                'Accessibility standards in gaming (CVAA compliance and colorblind filter integration)',
                'Multiplayer game netcode architecture: authoritative servers and roll-back netcode (GGPO)',
                'Spatial computing and Mixed Reality (OpenXR standard and spatial anchor tracking)',
                'Algorithmic procedural content generation (Perlin noise, cellular automata, Wave Function Collapse)',
                'Anti-cheat architecture: memory protection, server-side validation, and heuristic anomaly detection',
                'User experience research (UXR): eye-tracking, biometric telemetry, and player retention analytics',
                'Digital copyright, asset licensing agreements, and trademark protection in multimedia entertainment',
                'Ethical game design: avoiding predatory dark patterns, loot boxes, and gaming disorder triggers',
                'Game engine architecture: component-entity systems (ECS) and data-oriented design (DOD)'
            ]
        ]
    ];

    // Helper to generate full 50 questions for each profile
    foreach ($profiles as $degId => $p) {
        $out[$degId] = [];

        // Stage 1: 13 questions (Fundamentals)
        for ($i = 0; $i < 13; $i++) {
            $term = $p['terms'][$i % count($p['terms'])];
            $qText = "In {$p['name']}, what is the foundational significance of '$term'?";
            $a = "It represents an essential core concept, standard terminology, or baseline requirement in {$p['field']}.";
            $b = "It is an obsolete theoretical concept no longer recognized in modern practice.";
            $c = "It is a legal penalty applied strictly to commercial contract violations.";
            $d = "It refers exclusively to external marketing campaigns directed at retail consumers.";
            $out[$degId][] = [1, $qText, $a, $b, $c, $d, "A"];
        }

        // Stage 2: 13 questions (Core Principles)
        for ($i = 0; $i < 13; $i++) {
            $principle = $p['core_principles'][$i % count($p['core_principles'])];
            $qText = "Under standard academic and professional methodology in {$p['name']}, what is the core requirement when $principle?";
            $a = "Applying rigorous domain methodologies, verified analytical models, and systematic standard procedures.";
            $b = "Bypassing formal safety and technical calculations to complete assignments faster.";
            $c = "Relying purely on subjective intuition without empirical documentation or validation.";
            $d = "Delegating all technical and operational responsibilities to uncertified third parties.";
            $out[$degId][] = [2, $qText, $a, $b, $c, $d, "A"];
        }

        // Stage 3: 12 questions (Applied Scenarios)
        for ($i = 0; $i < 12; $i++) {
            $scenario = $p['scenario_types'][$i % count($p['scenario_types'])];
            $qText = "Applied Scenario in {$p['name']}: When faced with a practical challenge where $scenario, what is the best diagnostic action?";
            $a = "Systematically investigate root causes, isolate critical operational variables, and execute an evidence-based corrective plan.";
            $b = "Ignore the problem until catastrophic operational failure occurs.";
            $c = "Force an arbitrary manual override without investigating the underlying technical discrepancy.";
            $d = "Shut down the entire department permanently without conducting diagnostic troubleshooting.";
            $out[$degId][] = [3, $qText, $a, $b, $c, $d, "A"];
        }

        // Stage 4: 12 questions (Advanced Standards)
        for ($i = 0; $i < 12; $i++) {
            $std = $p['advanced_standards'][$i % count($p['advanced_standards'])];
            $qText = "Advanced Specialization in {$p['name']}: In accordance with '$std', what professional mandate must be upheld?";
            $a = "Strict compliance with statutory regulations, technical standards, ethical governance, and public welfare obligations.";
            $b = "Exemption from regulatory scrutiny through private informal agreements.";
            $c = "Prioritizing short-term institutional cost savings over established professional safety codes.";
            $d = "Withholding material audit and performance findings from regulatory oversight bodies.";
            $out[$degId][] = [4, $qText, $a, $b, $c, $d, "A"];
        }
    }

    // Now populate Degrees 20 through 50 using domain-specific clusters
    require_once __DIR__ . '/domain_curricula_20_50.php';
    $rest = getCurriculaDegrees20To50();
    foreach ($rest as $id => $qs) {
        $out[$id] = $qs;
    }

    return $out;
}
