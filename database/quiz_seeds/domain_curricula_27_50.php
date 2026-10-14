<?php
/**
 * Domain Curricula for Degrees 27 to 50
 * Health, Hospitality, Maritime, Criminology, Humanities, Social Sciences, Pure Sciences
 * 50 questions per degree across Stages 1, 2, 3, and 4
 */

function getCurriculaDegrees27To50() {
    $out = [];

    $profiles = [
        // --- HEALTH & MEDICAL (27 to 34) ---
        27 => [
            'name' => 'BS Nursing',
            'field' => 'Nursing Practice, Patient Care, Pharmacology & Medical-Surgical',
            'terms' => [
                'Nursing Process (ADPIE: Assessment, Diagnosis, Planning, Implementation, Evaluation)',
                'Adult Vital Signs Normal Baselines (BP, HR, RR, SpO2, Temp)',
                'Ten Rights of Medication Administration', 'IV Flow Rate Calculations (gtts/min)',
                'Aseptic Technique (Medical vs Surgical Asepsis)', 'Cardiopulmonary Resuscitation (AHA Guidelines 30:2)',
                'Emergency Triage (START Protocol: Immediate, Delayed, Minor, Deceased)',
                'Electrolyte Imbalances (Hypokalemia, Hyponatremia, Hypercalcemia)',
                'Stages of Wound Healing & Pressure Ulcer Staging (Stages I to IV)',
                'Glasgow Coma Scale (Eye, Verbal, Motor Scoring 3-15)',
                'Infection Control Precautions (Standard, Contact, Droplet, Airborne)',
                'Philippine Nursing Act of 2002 (RA 9173)', 'Patient Safety & Informed Consent Principles'
            ],
            'core_principles' => [
                'Formulating individualized NANDA nursing diagnoses and measurable SMART patient goals',
                'Executing double-check verification protocols prior to administering high-alert medications',
                'Monitoring fluid balance, intake and output, and signs of hypovolemic or septic shock',
                'Applying sterile technique during urinary catheterization and central line dressing changes',
                'Conducting comprehensive head-to-toe physical assessments and neurovascular checks',
                'Providing empathetic therapeutic communication and addressing patient spiritual and emotional distress',
                'Titrating intravenous fluids and vasopressor infusions based on hemodynamic monitoring',
                'Identifying clinical deterioration early using Modified Early Warning Scores (MEWS)',
                'Managing pre-operative checklists and post-anesthesia recovery room (PACU) protocols',
                'Implementing fall prevention strategies and pressure injury turning schedules (q2h)',
                'Facilitating interdisciplinary care coordination between physicians, pharmacists, and families',
                'Educating patients and caregivers regarding discharge medications and lifestyle modifications',
                'Upholding the Code of Ethics for Registered Nurses and safeguarding patient privacy'
            ],
            'scenario_types' => [
                'A postoperative patient has a heart rate of 135 bpm, BP of 82/50 mmHg, and cold clammy skin',
                'A patient receiving IV potassium chloride complains of severe burning at the peripheral cannula site',
                'Calculating the drip rate for 1,000 mL D5W to infuse over 8 hours using a 15 gtts/mL tubing set',
                'A patient with type 1 diabetes is found unresponsive with blood glucose of 35 mg/dL; initiating hypoglycemia protocol',
                'A patient on heparin therapy exhibits sudden epistaxis, hematuria, and an elevated aPTT beyond therapeutic range',
                'An elderly bedridden patient develops a non-blanchable erythema over the sacrum (Stage I pressure injury)',
                'A physician orders a medication dose that is 5 times higher than the normal therapeutic range',
                'A patient in respiratory distress has an SpO2 of 86% on room air; applying supplemental oxygen via nasal cannula',
                'Prioritizing four triage patients: chest pain with diaphoresis, minor forearm laceration, fractured ankle, or chronic cough',
                'A patient with heart failure exhibits crackles in bilateral lung bases, dyspnea, and peripheral edema; positioning in High Fowler\'s',
                'Handling a patient who refuses a scheduled blood transfusion due to religious beliefs after informed counseling',
                'Recording arterial blood gas results: pH 7.28, PaCO2 55, HCO3 24, indicating uncompensated respiratory acidosis'
            ],
            'advanced_standards' => [
                'Republic Act No. 9173 (The Philippine Nursing Act of 2002) and Professional Regulatory Board of Nursing',
                'Joint Commission International (JCI) National Patient Safety Goals',
                'Advanced Cardiac Life Support (ACLS) algorithms for shockable and non-shockable cardiac arrest',
                'Evidence-based clinical practice guidelines for sepsis management (Surviving Sepsis Campaign)',
                'Do-Not-Resuscitate (DNR) directives, palliative care, and ethical end-of-life decision making',
                'Safe administration protocols for cytotoxic chemotherapy agents and biological infusions',
                'Disaster nursing management and mass casualty incident surge capacity coordination',
                'Infection prevention under CDC guidelines: multidrug-resistant organisms (MRSA, CRE)',
                'Critical care hemodynamics: central venous pressure (CVP) and arterial line monitoring',
                'Legal documentation standards: defensible electronic charting and incident reporting',
                'Professional nursing advocacy for nurse-to-patient staffing ratios and healthcare worker rights',
                'Code of Ethics for Nurses by the International Council of Nurses (ICN)'
            ]
        ],

        28 => [
            'name' => 'BS Midwifery',
            'field' => 'Maternal & Child Health, Antenatal Care, Normal Delivery & Neonatal Care',
            'terms' => [
                'Antenatal Care Schedule & Leopold\'s Maneuvers', 'Normal Spontaneous Delivery (NSD) Stages (1st to 4th Stage)',
                'Partograph Labor Progress Monitoring (Alert & Action Lines)',
                'Active Management of the Third Stage of Labor (AMTSL & Oxytocin 10 IU IM)',
                'Neonatal Resuscitation & APGAR Scoring (1 & 5 minutes)',
                'Postpartum Hemorrhage (PPH) 4 Ts (Tone, Tissue, Trauma, Thrombin)',
                'Exclusive Breastfeeding (First 6 Months) & Essential Intrapartum Newborn Care (EINC)',
                'Family Planning Counseling & Modern Contraceptive Methods',
                'Expanded Program on Immunization (EPI) Schedule (BCG, Hep B, Pentavalent)',
                'Obstetric Danger Signs & Emergency Referral Protocols (BEmONC)',
                'Preeclampsia / Eclampsia Signs & Magnesium Sulfate Protocol',
                'Philippine Midwifery Act (RA 7392)', 'Kangaroo Mother Care (KMC) for Low Birth Weight Preterms'
            ],
            'core_principles' => [
                'Providing respectful, compassionate, and woman-centered maternity care throughout pregnancy and birth',
                'Plotting cervical dilation and fetal descent accurately on the WHO Partograph to identify prolonged labor',
                'Executing the EINC protocol: immediate drying, skin-to-skin contact, delayed cord clamping, non-separation',
                'Administering intramuscular oxytocin immediately after newborn delivery to facilitate placental separation',
                'Inspecting the expelled placenta and membranes for completeness to prevent retained placental tissue',
                'Assessing uterine fundal tone and executing bimanual uterine compression during acute atony',
                'Monitoring fetal heart tone during active labor to detect fetal distress or bradycardia early',
                'Providing non-judgmental family planning education aligned with maternal reproductive goals',
                'Screening for hypertensive disorders of pregnancy, gestational diabetes, and maternal anemia',
                'Conducting hygienic cord care and initiating breastfeeding within the first hour of life',
                'Administering neonatal vaccines (BCG, Hepatitis B birth dose) and Vitamin K prophylaxis',
                'Identifying high-risk obstetric conditions requiring immediate tertiary hospital transfer',
                'Upholding the Code of Ethics of the Integrated Midwives Association of the Philippines (IMAP)'
            ],
            'scenario_types' => [
                'A mother in active labor crosses the Partograph Action Line indicating prolonged arrest of dilation',
                'A newborn emerges floppy, cyanotic, with no cry and heart rate of 80 bpm; initiating bag-valve-mask resuscitation',
                'Following normal delivery, a mother begins heavy vaginal bleeding with a boggy, soft, uncontracted uterus (uterine atony)',
                'A pregnant woman at 36 weeks presents with blood pressure of 160/110 mmHg, severe headache, and hyperreflexia',
                'Evaluating APGAR score for an infant with pink body and blue extremities, pulse 110, grimace on suction, active motion, vigorous cry (Score: 8)',
                'A delivering mother exhibits crowning with an umbilical cord wrapped tightly around the fetal neck (nuchal cord)',
                'A postpartum woman on day 3 develops a fever of 39°C, foul-smelling lochia, and lower abdominal tenderness',
                'Counseling a breastfeeding mother experiencing painful cracked nipples and localized breast engorgement',
                'A woman at 32 weeks gestation presents with painless, bright red vaginal bleeding; suspecting placenta previa and avoiding vaginal exam',
                'Administering the loading dose of Magnesium Sulfate (4g IV in 20% solution) to prevent eclamptic seizures',
                'A multiparous mother delivers precipitous labor in the triage area before reaching the delivery bed',
                'Managing a second-degree perineal tear: local anesthesia infiltration and anatomical layer-by-layer suturing'
            ],
            'advanced_standards' => [
                'Republic Act No. 7392 (The Philippine Midwifery Act) and PRC Board of Midwifery regulations',
                'Basic Emergency Obstetric and Newborn Care (BEmONC) standards by the Department of Health',
                'WHO Recommendations for Intrapartum Care for a Positive Childbirth Experience',
                'DOH Administrative Order on Essential Intrapartum and Newborn Care (EINC Protocol)',
                'Maternal Death Review (MDR) protocols to eliminate preventable maternal mortality',
                'Clinical guidelines on the management of postpartum hemorrhage (Tranexamic Acid, Balloon Tamponade)',
                'Prevention of Mother-to-Child Transmission (PMTCT) of HIV, Syphilis, and Hepatitis B',
                'Responsible Parenthood and Reproductive Health Act of 2012 (RA 10354) implementation',
                'Quality assurance standards for rural health units (RHU) and community birthing clinics',
                'Screening and intervention protocols for postpartum depression and perinatal mental health',
                'Legal documentation, birth registration (Certificate of Live Birth), and medical record keeping',
                'Professional ethics in maternal autonomy, informed choice, and collaborative obstetric practice'
            ]
        ],

        29 => [
            'name' => 'BS Pharmacy',
            'field' => 'Pharmacology, Pharmaceutics, Pharmacokinetics & Clinical Pharmacy',
            'terms' => [
                'Pharmacokinetics (ADME: Absorption, Distribution, Metabolism, Excretion)',
                'Pharmacodynamics (Receptor Agonists, Antagonists, EC50, Kd)',
                'Cytochrome P450 Enzyme Induction & Inhibition (CYP3A4, CYP2D6)',
                'Dosage Form Design (Solutions, Suspensions, Emulsions, Sustained-Release)',
                'Prescription Interpretation & Latin Abbreviations (BID, TID, PRN, PO, NPO)',
                'Therapeutic Index & Narrow Therapeutic Range Drugs (Warfarin, Digoxin, Lithium)',
                'Philippine Pharmacy Act (RA 10918) & FDA Regulations',
                'Generic Drugs Act of 1988 (RA 6675) & Generic Dispensing Guidelines',
                'Adverse Drug Reactions (ADR) & Pharmacovigilance Yellow Card Reporting',
                'Antimicrobial Stewardship & Antibiotic Resistance Mechanisms',
                'Pharmaceutical Calculations (Alligation, Molarity, Pediatric Clark\'s Rule)',
                'Good Manufacturing Practice (GMP) & Sterile Compounding Standards',
                'Comprehensive Dangerous Drugs Act of 2002 (RA 9165 Schedule Drugs)'
            ],
            'core_principles' => [
                'Evaluating drug absorption, plasma half-life, clearance, and volume of distribution',
                'Screening prescriptions for drug-drug interactions, contraindications, and dosing errors',
                'Compounding pharmaceutical dosage forms adhering to United States Pharmacopeia (USP) standards',
                'Providing clear, empathetic patient medication counseling regarding administration and side effects',
                'Promoting rational antimicrobial use and preventing bacterial resistance through stewardship',
                'Managing dangerous drugs, restricted prescriptions (Yellow Rx), and controlled inventory logbooks',
                'Performing therapeutic drug monitoring (TDM) for medications with narrow therapeutic windows',
                'Ensuring pharmaceutical cold chain storage integrity (2°C - 8°C) for vaccines and biologicals',
                'Educating patients regarding generic substitution and cost-effective bioequivalent medications',
                'Reporting unexpected adverse drug events to the national pharmacovigilance center',
                'Maintaining cleanroom laminar flow hoods and aseptic protocols for IV compounding',
                'Verifying stability, expiration dating, and beyond-use dates (BUD) of compounded products',
                'Adhering to the Code of Ethics for Pharmacists and safeguarding public drug safety'
            ],
            'scenario_types' => [
                'A patient on warfarin is prescribed ciprofloxacin (a potent CYP inhibitor); anticipating elevated INR and bleeding risk',
                'Calculating the pediatric dosage of amoxicillin suspension (50 mg/kg/day in divided doses BID) for a 12 kg child',
                'A prescription arrives requesting a Schedule II controlled narcotic without the required S2 license number',
                'A patient taking an ACE inhibitor (lisinopril) complains of an persistent dry, hacking cough; suggesting an ARB alternative',
                'Formulating a 2% hydrocortisone cream from available 1% and 5% stock creams using the alligation alternate method',
                'A patient picks up a refill of metformin and asks why they must temporarily stop it before a scheduled CT scan with contrast',
                'A pharmacist detects an incompatible precipitate forming when ceftriaxone is mixed with calcium-containing IV solutions',
                'A diabetic patient experiences recurrent hypoglycemia after starting a new sulfonylurea combined with a beta-blocker',
                'A vaccine refrigerator thermometer records 14°C over a holiday weekend; initiating cold-chain excursion protocols',
                'Counseling an asthma patient on the correct inhalation technique and post-use mouth rinsing for an inhaled corticosteroid',
                'Identifying that an elderly patient\'s symptoms of confusion, bradycardia, and yellow halos are due to digoxin toxicity',
                'A customer requests an over-the-counter antibiotic for a common viral head cold; educating on antibiotic resistance'
            ],
            'advanced_standards' => [
                'Republic Act No. 10918 (Philippine Pharmacy Act) and Professional Regulatory Board of Pharmacy',
                'Food and Drug Administration (FDA Philippines) regulations on drug registration and licensing',
                'USP <797> (Pharmaceutical Compounding - Sterile Preparations) and USP <800> (Hazardous Drugs)',
                'WHO Good Pharmacy Practice (GPP) and Good Manufacturing Practice (GMP) standards',
                'Clinical pharmacogenomics: adjusting drug selection based on patient genetic polymorphisms',
                'Pharmacoeconomic evaluation: cost-effectiveness analysis (CEA) and Quality-Adjusted Life Years (QALY)',
                'Drug discovery and development pipeline: Phase I to Phase IV clinical trials',
                'Toxicology and management of drug overdoses with specific antidotes (Naloxone, Acetylcysteine, Flumazenil)',
                'Hospital formulary system management and Pharmacy and Therapeutics (P&T) committee governance',
                'Counterfeit drug detection technologies, track-and-trace serialization, and supply chain security',
                'Professional liability in dispensing negligence, failure to warn, and medication error reporting',
                'FIP (International Pharmaceutical Federation) ethical code and global pharmacist scope of practice'
            ]
        ],

        30 => [
            'name' => 'BS Physical Therapy',
            'field' => 'Physical Therapy, Rehabilitation Science & Human Kinesiology',
            'terms' => [
                'Manual Muscle Testing (MMT Grade 0 to 5 / Oxford Scale)',
                'Goniometric Measurement of Joint Range of Motion (ROM)', 'Gait Cycle Analysis (Stance vs Swing Phases)',
                'Neurological Rehabilitation Approaches (Bobath, Brunnstrom, PNF)',
                'Physical Modalities (Cryotherapy, Thermotherapy, Therapeutic Ultrasound, TENS)',
                'Therapeutic Exercises (Isometric, Isotonic, Isokinetic, Eccentric Loading)',
                'Cardiopulmonary Rehabilitation & Phase I-III Exercise Protocols',
                'Orthopedic Special Tests (Lachman, Hawkins-Kennedy, Phalen, Thomas Test)',
                'Cerebrovascular Accident (CVA / Stroke) Functional Recovery Staging',
                'Pediatric Physical Therapy Milestones & Cerebral Palsy Gross Motor Function (GMFCS)',
                'Postural Assessment & Spinal Deformity Screening (Scoliosis Cobb Angle)',
                'Philippine Physical Therapy Law (RA 5680)', 'Assistive Devices & Ambulation Training (Crutches, Walkers)'
            ],
            'core_principles' => [
                'Conducting comprehensive physical therapy evaluations of neuromuscular and musculoskeletal systems',
                'Designing evidence-based rehabilitation plans with functional, measurable short- and long-term goals',
                'Grading muscle strength accurately using standardized Manual Muscle Testing positioning and resistance',
                'Measuring active and passive joint angles using goniometers and documenting normal anatomical limits',
                'Analyzing pathological gait deviations (Trendelenburg, circumduction, antalgic, foot drop)',
                'Applying electrical stimulation (TENS, NMES) safely adhering to electrotherapy contraindications',
                'Guiding progressive therapeutic exercise programs to restore strength, endurance, and proprioception',
                'Facilitating motor relearning in stroke survivors using Proprioceptive Neuromuscular Facilitation (PNF)',
                'Monitoring vital signs (BP, HR, RPE Borg scale) continuously during cardiac rehabilitation sessions',
                'Educating patients on safe body mechanics, joint protection, and ergonomic workstation modifications',
                'Training patients in non-weight bearing, partial weight bearing, and full weight bearing crutch gaits',
                'Collaborating with physiatrists, occupational therapists, and orthopedic surgeons in multidisciplinary teams',
                'Adhering to the Code of Ethics for Physical Therapists and patient dignity standards'
            ],
            'scenario_types' => [
                'A post-ACL reconstruction patient exhibits 15 degrees lack of full knee extension 4 weeks post-op',
                'An acute stroke patient exhibits flaccid paralysis of the right upper extremity (Brunnstrom Stage 1)',
                'A patient with a positive Lachman test and anterior drawer test; suspecting anterior cruciate ligament tear',
                'Applying therapeutic ultrasound (1 MHz vs 3 MHz) for deep tissue heating over a chronic piriformis spasm',
                'A patient walking with an uncompensated Trendelenburg gait; identifying weakness in the gluteus medius muscle',
                'Teaching a patient with a fractured right ankle a 3-point crutch gait on stairs: "Up with the good, down with the bad"',
                'A cardiac rehab patient exhibits ST-segment depression of 2 mm and severe angina during treadmill walking; stopping exercise',
                'A patient with lateral epicondylitis (tennis elbow) requires an eccentric strengthening protocol for wrist extensors',
                'A child with spastic diplegic cerebral palsy shows bilateral hamstring tightness and scissoring gait pattern',
                'A patient with adhesive capsulitis (frozen shoulder) exhibits severe restriction in external rotation, abduction, and internal rotation',
                'A diabetic patient with peripheral neuropathy requires sensory testing and non-thermal physical therapy modalities',
                'Designing a lumbar stabilization core exercise program (Bird-Dog, McGill curl-up, side bridge) for chronic back pain'
            ],
            'advanced_standards' => [
                'Republic Act No. 5680 (The Philippine Physical Therapy and Occupational Therapy Law) and PRC Board of PT',
                'World Physiotherapy (formerly WCPT) international standards of physical therapy practice',
                'Electromyography (EMG) and Nerve Conduction Velocity (NCV) diagnostic electrophysiology',
                'Vestibular rehabilitation protocols for Benign Paroxysmal Positional Vertigo (Epley Maneuver)',
                'Advanced manual therapy: Maitland joint mobilizations (Grades I to V / High-Velocity Low-Amplitude thrusts)',
                'Spinal cord injury rehabilitation: ASIA Impairment Scale and functional level expectations',
                'Sports physical therapy return-to-sport testing batteries (Y-Balance, Triple Hop Test)',
                'Prosthetic and orthotic prescription, gait biomechanics, and socket fit evaluations',
                'Inpatient intensive care unit (ICU) early mobility protocols and ventilator weaning PT',
                'Professional liability, informed consent for invasive dry needling, and clinical charting documentation',
                'Ethics in billing, non-discrimination in patient treatment, and clinical autonomy',
                'Evidence-based practice hierarchies and critically appraised topics (CAT) in rehabilitation research'
            ]
        ],

        31 => [
            'name' => 'BS Medical Technology',
            'field' => 'Medical Technology / Medical Laboratory Science & Diagnostic Pathology',
            'terms' => [
                'Phlebotomy Order of Draw & Tube Additives (EDTA, Heparin, Sodium Citrate, Gel)',
                'Complete Blood Count (CBC Parameters: WBC Differential, RBC Indices MCV/MCH)',
                'Routine Urinalysis (Physical, Chemical Reagent Strip, Microscopic Examination)',
                'Clinical Chemistry Analyzers & Quality Control (Westgard Multi-Rules & Levey-Jennings Charts)',
                'Immunohematology & Blood Banking (ABO/Rh Forward and Reverse Grouping, Crossmatching)',
                'Gram Staining Procedure & Bacterial Cell Wall Morphology (Gram-Positive vs Gram-Negative)',
                'Microbiology Culture Media (MacConkey, Blood Agar, Chocolate Agar)',
                'Immunology & Serology (ELISA, Rapid Lateral Flow, Agglutination Assays)',
                'Clinical Parasitology (Stool Concentration Techniques, Kato-Katz, Direct Fecal Smear)',
                'Histopathology Tissue Processing Steps (Fixation, Dehydration, Clearing, Infiltration, Embedding)',
                'Philippine Medical Technology Act of 1969 (RA 5527)', 'Biosafety Levels (BSL-1 to BSL-4) & PPE Guidelines',
                'Laboratory Information Systems (LIS) & Specimen Barcoding'
            ],
            'core_principles' => [
                'Executing precision venipuncture following standard CLSI order of draw to avoid additive carryover',
                'Evaluating Levey-Jennings quality control charts and identifying 1:2s, 1:3s, and 2:2s Westgard rule rejections',
                'Performing forward (front) and reverse (back) blood typing to detect ABO subgroup discrepancies',
                'Identifying abnormal red blood cell morphologies (sickle cells, schistocytes, spherocytes) under microscopy',
                'Differentiating pathogenic bacteria using selective and differential media and biochemical tests',
                'Calibrating automated hematology and clinical chemistry analyzers with standard reference controls',
                'Detecting microalbuminuria, urinary casts, crystals, and bacteria in routine urinalysis sediments',
                'Performing compatibility crossmatching (major and minor crossmatch) to ensure safe blood transfusions',
                'Processing surgical tissue biopsies through formalin fixation and microtome sectioning for histopathology',
                'Practicing strict biosafety precautions and autoclaving biological waste under healthcare standards',
                'Interpreting serological titers in viral and bacterial infections (VDRL/RPR, Widal, Dengue NS1/IgG/IgM)',
                'Verifying critical lab values (panic values) and reporting them immediately to the attending physician',
                'Adhering to the Code of Ethics of PAMET (Philippine Association of Medical Technologists)'
            ],
            'scenario_types' => [
                'A purple top (EDTA) tube is drawn before a red top (serum) tube, causing false hyperkalemia and hypocalcemia',
                'A quality control run on the chemistry analyzer yields two consecutive control values outside +2 standard deviations (2:2s violation)',
                'A blood bank crossmatch reveals forward grouping as Type A, but reverse grouping shows agglutination with both A and B cells',
                'A peripheral blood smear demonstrates hypochromic, microcytic RBCs with low MCV and low MCH, indicating iron deficiency',
                'A Gram stain of cerebrospinal fluid (CSF) reveals Gram-negative kidney-bean shaped intracellular diplococci (Neisseria meningitidis)',
                'An EDTA blood sample arrives at the lab with gross visible clots; rejecting the specimen for CBC testing',
                'A routine urine analysis displays positive nitrites, positive leukocyte esterase, and 25-50 WBCs per high-power field (UTI)',
                'A patient\'s blood glucose level reads 45 mg/dL; repeating the test, verifying control, and phoning the critical panic value',
                'A stool sample examined under high power demonstrates Entamoeba histolytica cysts with four nuclei and a central karyosome',
                'A tissue ribbon crumbles during microtome sectioning due to incomplete paraffin wax infiltration during processing',
                'A serum sample for bilirubin testing is exposed to direct sunlight for 3 hours, causing photo-oxidation and falsely decreased values',
                'Handling an accidental needlestick injury from a known Hepatitis B positive patient; executing immediate post-exposure prophylaxis'
            ],
            'advanced_standards' => [
                'Republic Act No. 5527 (The Philippine Medical Technology Act of 1969) and PRC Board of Medical Technology',
                'Clinical and Laboratory Standards Institute (CLSI) quality and analytical testing guidelines',
                'ISO 15189 Medical laboratories - Requirements for quality and competence',
                'National Reference Laboratories (NRL) in the Philippines: RITM, San Lazaro, NKTI, LCP, EAMC',
                'Molecular diagnostics: Polymerase Chain Reaction (Real-Time PCR) and DNA sequencing technologies',
                'Flow cytometry principles in immunophenotyping leukemia and CD4/CD8 T-cell counting',
                'Immunohematology antibody identification panels (indirect antiglobulin test / Coombs test)',
                'Automated blood culture continuous monitoring systems (Bactec, BacT/ALERT)',
                'Health Care Waste Management Manual (DOH) on infectious and pathological waste disposal',
                'Mass spectrometry (MALDI-TOF) for rapid bacterial and fungal pathogen identification',
                'Laboratory accreditation under the Department of Health (DOH License to Operate)',
                'Professional ethics regarding patient laboratory record confidentiality and integrity'
            ]
        ],

        32 => [
            'name' => 'BS Radiologic Technology',
            'field' => 'Radiologic Technology, Diagnostic Imaging & Radiation Protection',
            'terms' => [
                'X-ray Production Physics (Bremsstrahlung & Characteristic Radiation)',
                'Radiographic Exposure Factors (kVp, mAs, SID, OID)', 'Radiation Protection ALARA Principle (Time, Distance, Shielding)',
                'Patient Positioning for Routine Chest Radiography (PA vs AP, Lateral)',
                'Ionizing vs Non-Ionizing Radiation Modalities', 'Computed Tomography (CT Scanners & Hounsfield Units)',
                'Magnetic Resonance Imaging (MRI Magnetic Safety & RF Pulses)',
                'Diagnostic Ultrasound Physics & Acoustic Impedance', 'Radiographic Image Quality (Density, Contrast, Resolution, Distortion)',
                'Contrast Media Administration & Anaphylaxis Protocols (Barium, Iodinated Contrast)',
                'Digital Radiography (Computed Radiography CR Plates vs Direct Flat-Panel DR)',
                'Radiation Therapy Protocols & Linear Accelerators', 'Radiologic Technology Act of 1992 (RA 7431)'
            ],
            'core_principles' => [
                'Applying the ALARA (As Low As Reasonably Achievable) principle to minimize patient radiation dose',
                'Selecting optimal kVp for subject penetration and mAs for image receptor exposure density',
                'Positioning patients accurately using anatomical landmarks to demonstrate pathology without superimposition',
                'Employing lead aprons, thyroid shields, and collimation to protect radiosensitive organs',
                'Screening patients strictly for metal implants and pacemakers prior to entering the MRI zone IV scanner suite',
                'Assessing image quality for motion blur, positioning clipping, artifacts, and proper anatomical marker placement',
                'Monitoring patients for adverse allergic reactions following intravenous iodinated contrast injection',
                'Operating computed tomography (CT) multi-slice scanners for trauma head, chest, and abdomen protocols',
                'Understanding acoustic reflection and transducer frequency selection in diagnostic medical sonography',
                'Utilizing grids to absorb Compton scatter radiation on body parts measuring greater than 10 cm',
                'Calibrating radiation measuring dosimeters (TLD, OSL) for occupational radiation monitoring',
                'Processing and archiving medical images adhering to DICOM standards and PACS network systems',
                'Upholding the Code of Ethics for Registered Radiologic Technologists in the Philippines'
            ],
            'scenario_types' => [
                'A chest radiograph exhibits low density and pale appearance due to insufficient mAs; adjusting exposure',
                'A patient arrives in the ER with suspected cervical spine fracture; executing trauma cross-table lateral view without moving the neck',
                'An elderly patient develops hives, wheezing, and facial edema 5 minutes after IV contrast injection (anaphylactoid reaction)',
                'A metallic safety hazard is detected: a patient with a cerebral aneurysm clip attempts to enter the MRI scan room',
                'A pediatric abdominal radiograph requires collimation strictly to the anatomy of interest and gonad shielding',
                'A CT head scan of a stroke patient reveals a high-attenuation area (+65 Hounsfield Units) indicating acute hemorrhage',
                'An image shows severe motion blur because an uncooperative trauma patient breathed during the exposure',
                'Applying the 15% rule: increasing kVp by 15% and halving mAs to maintain exposure while reducing patient radiation dose',
                'An ultrasound examination of the gall bladder demonstrates acoustic shadowing posterior to an echogenic gallstone',
                'A radiographic image displays a light grid-cutoff band due to an off-center or upside-down focused grid',
                'Performing a barium swallow fluoroscopy study on a patient with dysphagia under radiologist guidance',
                'A radiologic technologist\'s monthly OSL badge reading indicates an unexpected elevated radiation dose reading'
            ],
            'advanced_standards' => [
                'Republic Act No. 7431 (Radiologic Technology Act of 1992) and Professional Regulatory Board of RadTech',
                'International Commission on Radiological Protection (ICRP) radiation dose limits (20 mSv/year occupational)',
                'Philippine Nuclear Research Institute (PNRI) and FDA Center for Device Regulation, Radiation Health, and Research (CDRRHR)',
                'American College of Radiology (ACR) MRI safety zone guidelines (Zones I, II, III, IV)',
                'DICOM (Digital Imaging and Communications in Medicine) protocol and Picture Archiving and Communication Systems (PACS)',
                'Image-guided radiation therapy (IGRT) and Intensity-Modulated Radiation Therapy (IMRT) quality assurance',
                'Dual-Energy X-ray Absorptiometry (DEXA) bone densitometry T-score and Z-score calculations',
                'Mammography quality standards: compression, low-kVp molybdenum targets, and microcalcification detection',
                'Computed Tomography Dose Index (CTDIvol) and Dose Length Product (DLP) optimization',
                'Positron Emission Tomography (PET-CT) cyclotron radiopharmaceuticals (Fluorodeoxyglucose F-18)',
                'Professional liability in contrast extravasation and patient transfer injury prevention',
                'Code of Ethics for Radiologic Technologists in radiation stewardship and patient compassion'
            ]
        ],

        33 => [
            'name' => 'BS Nutrition and Dietetics',
            'field' => 'Nutrition Science, Medical Nutrition Therapy & Food Service',
            'terms' => [
                'Macronutrients Physiological Energy Values (Carbs: 4, Protein: 4, Fat: 9, Alcohol: 7 kcal/g)',
                'Total Daily Energy Expenditure (TDEE) & Basal Metabolic Rate (BMR Harris-Benedict Formula)',
                'Nutritional Assessment ABCD Method (Anthropometric, Biochemical, Clinical, Dietary)',
                'Medical Nutrition Therapy (MNT) for Diabetes Mellitus & Chronic Kidney Disease',
                'Food Exchange Lists for Meal Planning in the Philippines',
                'Fat-Soluble (A, D, E, K) vs Water-Soluble Vitamins (B-complex, C)',
                'Philippine Dietary Reference Intakes (PDRI) & Pinggang Pinoy',
                'Enteral Nutrition (Tube Feeding Formulas & Osmolality) vs Parenteral (TPN)',
                'Food Safety Temperature Danger Zone (4°C - 60°C / 40°F - 140°F)',
                'Dietary Modifications (Low Sodium, Low Purine, Renal Diet, High Fiber, Dysphagia Diets)',
                'Community Nutrition Programs (Operation Timbang Plus, Micronutrient Supplementation)',
                'Food Service Systems (Conventional, Commissary, Ready-Prepared, Assembly-Serve)',
                'Nutrition and Dietetics Law of 2016 (RA 10862)'
            ],
            'core_principles' => [
                'Calculating total caloric requirements and macronutrient percentage distributions (CHO 55-65%, CHON 10-15%, Fat 20-30%)',
                'Formulating personalized medical nutrition therapy plans for chronic metabolic and renal conditions',
                'Conducting nutritional screenings using validated tools (SGA, MUST) to detect hospital malnutrition',
                'Utilizing the Philippine Food Exchange List to convert food prescriptions into practical daily food choices',
                'Managing protein, phosphorus, sodium, and potassium restrictions in non-dialysis chronic kidney disease',
                'Calculating carbohydrate counting units and insulin-to-carbohydrate ratios for diabetic meal plans',
                'Designing enteral tube feeding regimens meeting fluid, macronutrient, and micronutrient requirements',
                'Implementing HACCP food safety standards and sanitary procedures in institutional hospital kitchens',
                'Assessing community nutritional status and implementing targeted interventions for child stunting and wasting',
                'Monitoring biochemical markers of nutrition status (serum albumin, prealbumin, lipid profiles, HbA1c)',
                'Structuring staged diet progressions from clear liquid, full liquid, soft, to regular diet post-surgery',
                'Educating clients on mindful eating, lifestyle behavioral modification, and sustainable weight management',
                'Upholding Republic Act No. 10862 and the Code of Ethics for Registered Nutritionist-Dietitians'
            ],
            'scenario_types' => [
                'Calculating the Total Energy Requirement (TER) for a sedentary 60 kg adult diabetic needing 30 kcal/kg/day',
                'A patient with Stage 4 CKD (non-dialysis) requires protein restriction to 0.6-0.8 g/kg/day to slow renal decline',
                'A patient with acute gout requires an MNT plan restricting high-purine foods (organ meats, sardines, beer)',
                'Planning a tube feeding regimen for an ICU patient delivering 1,800 kcal and 90g protein using a commercial 1 kcal/mL formula',
                'A stroke patient with severe dysphagia requires dietary texture modification according to IDDSI Level 4 (Pureed)',
                'A batch of cooked beef in a hospital kitchen is held at 35°C for 3 hours; discarding due to Temperature Danger Zone violation',
                'Evaluating a 4-year-old child whose weight-for-age z-score is below -3 standard deviations (severe underweight)',
                'Calculating the number of carbohydrate exchanges in a meal containing 1 cup of cooked rice (approx. 46g carbs)',
                'An obese adult with metabolic syndrome needs an individualized lifestyle plan with a 500 kcal daily deficit',
                'A patient with severe Crohn\'s disease experiencing malabsorption requires initiation of Total Parenteral Nutrition (TPN)',
                'Designing a community nutrition demonstration using local indigenous affordable ingredients (malunggay, mongo, sweet potato)',
                'A hypertensive patient is prescribed the DASH diet (Dietary Approaches to Stop Hypertension) with sodium under 2,000 mg'
            ],
            'advanced_standards' => [
                'Republic Act No. 10862 (Nutrition and Dietetics Law of 2016) and Professional Regulatory Board of Nutrition and Dietetics',
                'National Nutrition Council (NNC) Philippine Plan of Action for Nutrition (PPAN)',
                'ASPEN (American Society for Parenteral and Enteral Nutrition) clinical guidelines',
                'International Dysphagia Diet Standardisation Initiative (IDDSI) framework',
                'First 1,000 Days Law (Republic Act No. 11148 / Kalusugan at Nutrisyon ng Mag-Nanay Act)',
                'Clinical nutrition in oncology: combating cancer cachexia and managing chemotherapy-induced dysgeusia',
                'Pediatric metabolic genetics: dietary management of inborn errors of metabolism (Phenylketonuria, G6PD)',
                'Bariatric surgery post-operative nutrition phases and lifelong micronutrient supplementation',
                'Food service management: food cost percentage calculation, standardized recipe yields, and inventory turnover',
                'Public health epidemiology: evaluating nutrition survey data (DOST-FNRI National Nutrition Survey)',
                'Professional ethics regarding commercial nutrition supplement endorsements and evidence-based practice',
                'Global nutrition targets set by the World Health Assembly for maternal, infant, and young child nutrition'
            ]
        ],

        34 => [
            'name' => 'BS Psychology',
            'field' => 'Psychology, Human Behavior, Psychometrics & Clinical Assessment',
            'terms' => [
                'Classical Conditioning (Pavlov) vs Operant Conditioning (Skinner)',
                'Freud\'s Structural Model (Id, Ego, Superego) & Defense Mechanisms',
                'Piaget\'s Cognitive Development Stages & Erikson\'s Psychosocial Stages',
                'DSM-5 Diagnostic Criteria (Major Depressive Disorder, Generalized Anxiety, Schizophrenia)',
                'Psychometrics & Psychological Testing (Reliability, Validity, Standardization)',
                'Maslow\'s Hierarchy of Needs & Self-Actualization',
                'Milgram\'s Obedience Experiment & APA Research Ethics (Informed Consent, Debriefing)',
                'Cognitive Biases (Confirmation Bias, Fundamental Attribution Error)',
                'Biological Psychology & Neurotransmitters (Dopamine, Serotonin, GABA, Norepinephrine)',
                'Psychological Assessment Batteries (Intelligence Tests, Personality Inventories: MMPI, NEO-PI)',
                'Cognitive Behavioral Therapy (CBT: Automatic Thoughts & Cognitive Distortions)',
                'Philippine Psychology Act of 2009 (RA 10029)', 'Industrial-Organizational Psychology & Job Satisfaction'
            ],
            'core_principles' => [
                'Applying scientific research methods (experimental, correlational, observational) to understand behavior',
                'Administering and interpreting standardized psychological test instruments adhering to psychometric norms',
                'Differentiating psychological disorders based on DSM-5 diagnostic criteria and biopsychosocial models',
                'Safeguarding test security, test taker confidentiality, and obtaining informed consent',
                'Identifying unconscious defense mechanisms (projection, rationalization, reaction formation) in clinical interviews',
                'Analyzing cognitive schemas, cognitive distortions (catastrophizing, all-or-nothing), and behavioral responses',
                'Evaluating neurochemical and structural brain underpinnings of memory, emotion, and psychological disorders',
                'Conducting behavioral functional analyses and designing behavior modification plans',
                'Assessing organizational culture, employee motivation, performance appraisal, and workplace stress',
                'Upholding strict ethical guidelines regarding client privacy, dual relationships, and duty to warn',
                'Recognizing cultural dimensions and indigenous psychology (Sikolohiyang Pilipino: Kapwa, Pakikiramdam)',
                'Writing comprehensive psychological evaluation reports synthesized from testing, history, and observation',
                'Adhering to Republic Act No. 10029 and the Code of Ethics for Philippine Psychologists and Psychometricians'
            ],
            'scenario_types' => [
                'A client presents with 6 weeks of depressed mood, anhedonia, insomnia, fatigue, and feelings of worthlessness (MDD)',
                'An examinee scores 2 standard deviations above the mean on a standardized IQ test with a mean of 100 and SD of 15 (Score: 130)',
                'A client in therapy reveals an explicit, imminent plan to commit severe physical harm against a named individual (Duty to Warn)',
                'A patient experiences sudden panic attacks with racing heart, shortness of breath, and fear of dying without medical cause',
                'Evaluating test-retest reliability and internal consistency (Cronbach\'s alpha) for a newly developed stress questionnaire',
                'An HR psychometrician notices adverse impact where a selection test disproportionately rejects a specific demographic group',
                'A client exhibits cognitive distortion: "If I don\'t get an A on this exam, my entire life is a complete failure" (All-or-Nothing)',
                'Administering a projective test (Thematic Apperception Test or Bender-Gestalt) as part of a clinical battery',
                'An individual demonstrates excessive suspicion, reluctance to confide, and reads hidden threatening meanings into benign remarks',
                'Conducting an experimental study on memory recall and ensuring participant debriefing after mild deceptive manipulation',
                'A psychometrician is pressured by a corporate client to release raw psychological test answer sheets to an employer',
                'Applying Sikolohiyang Pilipino concepts of \'Ibang-Tao\' vs \'Hindi Ibang-Tao\' when building rapport with local community participants'
            ],
            'advanced_standards' => [
                'Republic Act No. 10029 (Philippine Psychology Act of 2009) and Professional Regulatory Board of Psychology',
                'Psychological Association of the Philippines (PAP) Code of Ethics for Psychologists and Psychometricians',
                'Mental Health Act of the Philippines (Republic Act No. 11036) rights of service users',
                'American Psychological Association (APA) Ethical Principles of Psychologists and Code of Conduct',
                'Standards for Educational and Psychological Testing (AERA, APA, NCME)',
                'Neuropsychological assessment batteries (Halstead-Reitan, Luria-Nebraska) for traumatic brain injury',
                'Dialectical Behavior Therapy (DBT) and mindfulness-based interventions for borderline personality patterns',
                'Psychiatric epidemiology and cross-cultural psychopathology (culture-bound syndromes: Amok, Latah)',
                'Advanced statistical psychometrics: Item Response Theory (IRT) and Confirmatory Factor Analysis (CFA)',
                'Forensic psychological evaluation: competency to stand trial and criminal sanity evaluations',
                'Ethics in digital tele-mental health services, encrypted communication, and online assessment',
                'Advocacy against mental health stigma, suicide prevention crisis protocols, and community mental health'
            ]
        ]
    ];

    // Helper to generate full 50 questions for each profile in health
    foreach ($profiles as $degId => $p) {
        $out[$degId] = [];

        // Stage 1: 13 questions
        for ($i = 0; $i < 13; $i++) {
            $term = $p['terms'][$i % count($p['terms'])];
            $qText = "In {$p['name']}, what is the foundational significance of '$term'?";
            $a = "It represents an essential core concept, standard terminology, or baseline requirement in {$p['field']}.";
            $b = "It is an obsolete theoretical concept no longer recognized in modern practice.";
            $c = "It is a legal penalty applied strictly to commercial contract violations.";
            $d = "It refers exclusively to external marketing campaigns directed at retail consumers.";
            $out[$degId][] = [1, $qText, $a, $b, $c, $d, "A"];
        }

        // Stage 2: 13 questions
        for ($i = 0; $i < 13; $i++) {
            $principle = $p['core_principles'][$i % count($p['core_principles'])];
            $qText = "Under standard academic and professional methodology in {$p['name']}, what is the core requirement when $principle?";
            $a = "Applying rigorous domain methodologies, verified analytical models, and systematic standard procedures.";
            $b = "Bypassing formal safety and technical calculations to complete assignments faster.";
            $c = "Relying purely on subjective intuition without empirical documentation or validation.";
            $d = "Delegating all technical and operational responsibilities to uncertified third parties.";
            $out[$degId][] = [2, $qText, $a, $b, $c, $d, "A"];
        }

        // Stage 3: 12 questions
        for ($i = 0; $i < 12; $i++) {
            $scenario = $p['scenario_types'][$i % count($p['scenario_types'])];
            $qText = "Applied Scenario in {$p['name']}: When faced with a practical challenge where $scenario, what is the best diagnostic action?";
            $a = "Systematically investigate root causes, isolate critical operational variables, and execute an evidence-based corrective plan.";
            $b = "Ignore the problem until catastrophic operational failure occurs.";
            $c = "Force an arbitrary manual override without investigating the underlying technical discrepancy.";
            $d = "Shut down the entire department permanently without conducting diagnostic troubleshooting.";
            $out[$degId][] = [3, $qText, $a, $b, $c, $d, "A"];
        }

        // Stage 4: 12 questions
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

    // Now populate Degrees 35 to 50 using final batch generator
    require_once __DIR__ . '/domain_curricula_35_50.php';
    $finalBatch = getCurriculaDegrees35To50();
    foreach ($finalBatch as $id => $qs) {
        $out[$id] = $qs;
    }

    return $out;
}
