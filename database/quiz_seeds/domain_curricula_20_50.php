<?php
/**
 * Domain Curricula for Degrees 20 to 50
 * Engineering, Health, Hospitality, Maritime, Humanities, and Pure Sciences
 * 50 questions per degree across Stages 1, 2, 3, and 4
 */

function getCurriculaDegrees20To50() {
    $out = [];

    // Master definitions for Degrees 20 to 50
    $profiles = [
        // --- ENGINEERING & ARCHITECTURE (20 to 26) ---
        20 => [
            'name' => 'BS Civil Engineering',
            'field' => 'Civil, Structural, Hydraulic & Geotechnical Engineering',
            'terms' => [
                'Stress, Strain & Hooke\'s Law', 'Shear and Bending Moment Diagrams', 'Reinforced Concrete Beam Design',
                'Bernoulli\'s Principle in Fluid Mechanics', 'Darcy\'s Law in Soil Permeability', 'Total Station Surveying & Leveling',
                'Mohr\'s Circle for Stress Transformation', 'National Structural Code of the Philippines (NSCP 2015)',
                'Slump Test for Concrete Workability', 'Traffic Flow Theory & Level of Service (LOS)', 'Truss Analysis (Method of Joints/Sections)',
                'Soil Compaction & Proctor Test', 'Earthquake Lateral Force Resisting Systems'
            ],
            'core_principles' => [
                'Calculating structural member capacity against axial, flexural, and shear demands',
                'Determining soil bearing capacity and foundation settlement limits',
                'Designing hydraulic open channels and storm drainage culvert capacities',
                'Establishing horizontal and vertical highway alignments and sight distances',
                'Conducting structural seismic analysis using equivalent lateral force procedures',
                'Ensuring concrete mix design water-cement ratio for target compressive strength (f\'c)',
                'Performing closed traverse surveying adjustments and coordinate geometry (COGO)',
                'Analyzing indeterminate structures using moment distribution and slope-deflection methods',
                'Designing retaining walls against overturning, sliding, and bearing failure modes',
                'Executing construction project scheduling using Critical Path Method (CPM/PERT)',
                'Verifying steel connection capacities (bolted and welded joints) under AISC/NSCP',
                'Managing stormwater runoff and environmental hydrologic impact assessments',
                'Adhering to the Civil Engineering Code of Ethics and public infrastructure safety'
            ],
            'scenario_types' => [
                'A concrete cylinder test yields 21-day compressive strength 30% below specified f\'c',
                'A retaining wall exhibits horizontal displacement and active soil pressure fissures after heavy rainfall',
                'Calculating the required tension steel reinforcement area (As) for a singly reinforced rectangular beam',
                'A highway intersection experiences severe gridlock with a traffic Level of Service (LOS F)',
                'A deep excavation causes adjacent road subsidence; redesigning sheet pile shoring and strut systems',
                'Water hammer pressure spikes threaten to rupture a municipal water supply penstock pipe',
                'A surveying crew discovers an unclosed traverse with an unacceptable linear error of closure',
                'Designing isolated square footings on clay soil with an allowable bearing capacity of 150 kPa',
                'A steel roof truss exhibits excessive deflection and web member buckling during high typhoons',
                'Determining the maximum bending moment for a simply supported beam with uniform distributed load (wL^2/8)',
                'A bridge pier experiences severe hydraulic scour around its foundation piles in a riverbed',
                'Managing a construction delay on a critical path activity to avoid contractual liquidated damages'
            ],
            'advanced_standards' => [
                'National Structural Code of the Philippines (NSCP 2015 Volume 1)',
                'DPWH Standard Specifications for Highways, Bridges and Airports (Blue Book)',
                'American Concrete Institute (ACI 318) Building Code Requirements for Structural Concrete',
                'AISC 360 Specification for Structural Steel Buildings',
                'Geotechnical engineering standards for liquefaction assessment under seismic loading',
                'Philippine Environmental Impact Statement System (PEISS / PD 1586) compliance',
                'Building Information Modeling (BIM) structural integration and clash detection',
                'Non-destructive testing (NDT) of concrete structures (Rebound Hammer, Ultrasonic Pulse)',
                'Disaster risk reduction and climate change adaptation in coastal infrastructure design',
                'National Water Resources Board (NWRB) water rights and dam safety regulations',
                'Republic Act No. 544 (The Civil Engineering Law of the Philippines)',
                'Professional liability, indemnification, and structural engineer\'s oath of safety'
            ]
        ],

        21 => [
            'name' => 'BS Electrical Engineering',
            'field' => 'Electrical Power Systems, Machines & Circuit Analysis',
            'terms' => [
                'Ohm\'s Law & Kirchhoff\'s Circuit Laws (KVL, KCL)', 'AC Power Triangle (Real, Reactive, Apparent Power, PF)',
                'Thevenin\'s & Norton\'s Circuit Theorems', 'Three-Phase Transformer Connections (Delta-Wye)',
                'Induction Motor Slip & Torque-Speed Curves', 'Synchronous Generator Synchronization',
                'Philippine Electrical Code (PEC 2017)', 'Symmetrical Fault Analysis & Short-Circuit MVA',
                'Transmission Line Surge Impedance & Corona Effect', 'Power System Protection & Relay Coordination',
                'Power Electronics (Inverters, Rectifiers, VFDs)', 'Grounding Systems & Earth Resistance Testing',
                'Illumination Design & Lumen Method'
            ],
            'core_principles' => [
                'Analyzing complex single-phase and balanced/unbalanced three-phase electrical circuits',
                'Sizing electrical conductors, conduits, and overcurrent protective devices (OCPD) under PEC',
                'Maintaining electrical system power factor above 0.95 using shunt capacitor banks',
                'Calculating magnetic flux, core losses, and copper losses in electrical machinery',
                'Configuring protective relays (overcurrent, differential, distance) for fault isolation',
                'Executing safe synchronization of diesel backup generators with the utility grid',
                'Balancing electrical load schedules across phases in residential and commercial panels',
                'Designing low-impedance substation grounding grids to minimize step and touch potentials',
                'Regulating voltage stability and reactive power flow across high-voltage transmission grids',
                'Selecting Variable Frequency Drives (VFD) for precision industrial AC motor speed control',
                'Conducting power quality harmonic distortion (THD) measurements and filter mitigation',
                'Performing short-circuit interrupt duty ratings for main distribution switchboards',
                'Upholding the Code of Ethics for Registered Electrical Engineers in the Philippines'
            ],
            'scenario_types' => [
                'An industrial plant incurs hefty utility penalties due to an operating power factor of 0.72',
                'A 3-phase induction motor draws 6x rated current and trips thermal overloads during startup',
                'A commercial building transformer overheats despite running at 80% nominal load due to harmonic currents',
                'Calculating voltage drop across a 150-meter feeder line to ensure it does not exceed 3% under PEC',
                'A short-circuit fault occurs at a busbar; verifying if circuit breakers exceed the available fault current',
                'A hospital emergency generator fails to transfer power within the mandated 10-second NFPA window',
                'Measuring substation earth resistance using the fall-of-potential method and obtaining an unsafe reading',
                'Designing a solar photovoltaic grid-tied inverter system with net metering protective disconnects',
                'Troubleshooting an unexpected tripping of a differential protection relay on a 5 MVA power transformer',
                'Determining the required number of LED luminaires to achieve 500 lux in a corporate drafting room',
                'A medium-voltage transmission line experiences single-line-to-ground fault; calculating symmetrical components',
                'Investigating an arc flash incident and calculating incident energy (cal/cm2) for safe PPE boundaries'
            ],
            'advanced_standards' => [
                'Philippine Electrical Code (PEC 1 and PEC 2) and Republic Act No. 7920 (New Electrical Engineering Law)',
                'Philippine Grid Code (PGC) and Philippine Distribution Code (PDC) compliance',
                'IEEE Standard 1584 Guide for Performing Arc-Flash Hazard Calculations',
                'IEEE 519 Standard for Harmonic Control in Electric Power Systems',
                'NFPA 70E Standard for Electrical Safety in the Workplace',
                'SCADA and Smart Grid automation protocols (IEC 61850 substation communication)',
                'High-voltage switchgear testing standards (IEC 62271-200)',
                'Energy Regulatory Commission (ERC) compliance and retail electricity market rules',
                'Renewable energy grid integration standards for wind and utility-scale solar farms',
                'Lightning protection design under IEC 62305 standards (rolling sphere method)',
                'Professional engineering liability in electrical project signing, sealing, and inspection',
                'Ethics in public safety, sustainable energy transition, and environmental stewardship'
            ]
        ],

        22 => [
            'name' => 'BS Mechanical Engineering',
            'field' => 'Mechanical Systems, Thermodynamics, HVAC & Machine Design',
            'terms' => [
                'First & Second Laws of Thermodynamics', 'Carnot, Rankine, Otto & Diesel Power Cycles',
                'Conduction, Convection & Radiation Heat Transfer', 'Vapor-Compression Refrigeration & Psychrometric Chart',
                'Shaft Torsion, Bending & ASME Machine Design Formulas', 'Fluid Machinery (Centrifugal Pumps & Turbines)',
                'Philippine Mechanical Engineering Code (PMEC)', 'HVAC Air Distribution & Cooling Load Calculations',
                'Internal Combustion Engine Performance Parameters', 'Gear Trains, Belts & Chain Drive Kinematics',
                'Vibration Analysis & Balancing of Rotating Masses', 'Steam Boilers, Boiler Feedwater & ASME Boiler Code',
                'Piping Design & Darcy-Weisbach Friction Factor'
            ],
            'core_principles' => [
                'Evaluating thermal efficiency and heat rates of vapor and gas power generation cycles',
                'Designing machine elements (shafts, keys, bearings, gears, pressure vessels) for fatigue life',
                'Calculating building cooling and heating loads considering envelope heat gain and fresh air rates',
                'Determining pump total dynamic head (TDH), Net Positive Suction Head (NPSH), and cavitation limits',
                'Sizing heat exchangers using Log Mean Temperature Difference (LMTD) and NTU methods',
                'Analyzing stress concentrations and Mohr\'s failure theories in mechanical components',
                'Balancing rotating machine shafts dynamically to prevent destructive resonant vibrations',
                'Operating industrial steam boilers safely according to ASME Section I pressure vessel codes',
                'Designing ductwork networks using the equal friction method for commercial ventilation',
                'Assessing lubrication regimes and hydrodynamic film thickness in journal and roller bearings',
                'Performing piping stress analysis and thermal expansion loop sizing under ASME B31.3',
                'Selecting appropriate engineering materials based on tensile strength, hardness, and creep',
                'Adhering to the Mechanical Engineering Law of the Philippines (RA 8495) and safety codes'
            ],
            'scenario_types' => [
                'A centrifugal pump emits crackling noises and experiences impeller pitting due to cavitation',
                'A commercial chiller room exhibits high humidity and coil freezing due to improper airflow and refrigerant charge',
                'Calculating the minimum diameter of a solid steel transmission shaft subjected to combined bending and torsion',
                'A steam boiler safety valve fails to open during an overpressure test; executing emergency shutdown protocols',
                'An industrial air compressor consumes excessive power; diagnosing leaking discharge valves and clogged intake filters',
                'Designing a cold storage refrigeration room for meat storage at -18°C with R-404A refrigerant',
                'A cooling tower fails to cool condenser water to the design approach temperature; diagnosing air bypass and scaling',
                'A factory exhaust duct vibrates violently near motor operating speed due to acoustic or mechanical resonance',
                'Calculating the Net Positive Suction Head Available (NPSHA) to prevent pump cavitation from an underground tank',
                'Selecting a deep-groove ball bearing to achieve an L10 rating life of 50,000 hours under 8 kN radial load',
                'An internal combustion diesel generator experiences black smoke exhaust indicating incomplete fuel combustion',
                'Designing a fire protection sprinkler hydraulic calculation according to NFPA 13 building standards'
            ],
            'advanced_standards' => [
                'Philippine Mechanical Engineering Code and Republic Act No. 8495',
                'ASME Boiler and Pressure Vessel Code (BPVC Sections I, VIII)',
                'ASHRAE Standard 62.1 (Ventilation for Acceptable Indoor Air Quality) and Standard 90.1 (Energy Efficiency)',
                'NFPA 13 (Standard for the Installation of Sprinkler Systems) and NFPA 20 (Fire Pumps)',
                'ISO 10816 Mechanical vibration standards for industrial machine evaluation',
                'Computational Fluid Dynamics (CFD) and Finite Element Analysis (FEA) design verification',
                'Clean air emission standards under the Philippine Clean Air Act (RA 8749)',
                'Energy management systems (ISO 50001) in large manufacturing and commercial facilities',
                'API 650 Welded Tanks for Oil Storage and ASME B31 Pressure Piping Codes',
                'Acoustics and noise control engineering in mechanical plant rooms',
                'Professional ethics of Professional Mechanical Engineers (PME) in design certification',
                'Sustainable HVAC design utilizing low-GWP refrigerants and district cooling systems'
            ]
        ],

        23 => [
            'name' => 'BS Electronics Engineering',
            'field' => 'Electronics, Telecommunications, Signals & Microelectronics',
            'terms' => [
                'Semiconductor PN Junctions & Diodes', 'BJT & MOSFET Transistor Biasing & Small-Signal Models',
                'Operational Amplifiers & Feedback Topologies', 'Analog Modulation (AM, FM Modulation Index)',
                'Digital Modulation (QPSK, 16-QAM, OFDM)', 'Shannon-Hartley Channel Capacity Theorem',
                'Nyquist Sampling Rate & Aliasing Prevention', 'RF Antennas, Radiation Patterns & Friis Equation',
                'Digital Signal Processing (DSP, FFT, FIR Filters)', 'Microcontroller Interfacing & Embedded Firmware',
                'Philippine Electronics Code & RA 9292', 'Fiber Optic Communications & Optical Power Budgets',
                'Electromagnetic Compatibility (EMC) & Shielding'
            ],
            'core_principles' => [
                'Designing analog transistor amplifier stages with stable bias points and gain-bandwidth products',
                'Configuring active filter circuits (Butterworth, Chebyshev) using operational amplifiers',
                'Modulating and demodulating RF carrier signals for wireless cellular and broadcast systems',
                'Calculating link budget, path loss, and antenna gain for line-of-sight microwave links',
                'Executing discrete-time signal filtering and spectral analysis using Fast Fourier Transforms',
                'Interfacing high-speed digital electronics while preserving signal integrity and eye diagrams',
                'Sizing fiber optic transmitters, optical splitters, and receivers for long-haul networks',
                'Programming real-time firmware for sensor acquisition and wireless IoT transmission',
                'Ensuring electronic equipment compliance with electromagnetic interference (EMI) limits',
                'Designing phase-locked loops (PLL) for frequency synthesis and clock synchronization',
                'Managing cellular network frequency reuse, handoffs, and link capacity planning',
                'Conducting electronic circuit simulation (SPICE) for transient and AC frequency response',
                'Upholding the Electronics Engineering Law of 2004 (RA 9292) and safety regulations'
            ],
            'scenario_types' => [
                'An audio op-amp circuit exhibits clipping distortion on the negative half of the output sine wave',
                'A wireless sensor node fails to transmit data across a 2-kilometer outdoor line-of-sight distance',
                'An analog signal sampled below twice its highest frequency component exhibits severe aliasing artifacts',
                'A fiber optic link experiences unexpected 15 dB optical attenuation due to macrobending along the conduit',
                'Designing an inverting op-amp amplifier with a voltage gain of -20 and input impedance of 10 kΩ',
                'A switched-mode power supply (SMPS) produces high-frequency switching noise on nearby analog sensor lines',
                'Calculating the maximum data throughput of an AWGN channel with 10 MHz bandwidth and 30 dB SNR',
                'A microwave link experiences severe signal fading and packet loss during heavy monsoon rainstorms',
                'Designing a 2nd-order Sallen-Key low-pass filter with a cutoff frequency of 5 kHz and Q of 0.707',
                'An RF transmitter circuit fails to transfer maximum power to an antenna due to impedance mismatch',
                'Configuring a cellular base station antenna tilt to minimize inter-cell interference in an urban area',
                'Debugging a microcontroller SPI communication failure caused by bus capacitance and slow rise times'
            ],
            'advanced_standards' => [
                'Republic Act No. 9292 (Electronics Engineering Law of 2004) and Professional Regulatory Board of Electronics Engineering',
                'National Telecommunications Commission (NTC) regulations and frequency spectrum allocation rules',
                'ITU-R and ITU-T international telecommunications standards',
                'IEEE 802.11 (Wi-Fi), 802.15 (Bluetooth/Zigbee), and 3GPP 5G NR cellular standards',
                'Electromagnetic Compatibility (EMC) Directive and FCC Part 15 emissions compliance',
                'Advanced optical networks: DWDM (Dense Wavelength Division Multiplexing) architecture',
                'Software-Defined Radio (SDR) and cognitive radio frequency spectrum management',
                'FPGA-based high-speed DSP implementation for digital communications receivers',
                'Electronic countermeasures against electrostatic discharge (ESD) under IEC 61000-4-2',
                'Satellite communications link engineering (orbital mechanics, uplink/downlink budgets)',
                'Code of Ethics for Professional Electronics Engineers (PECE) in telecom safety',
                'Cyber-physical hardware security and cryptographic hardware accelerator design'
            ]
        ],

        24 => [
            'name' => 'BS Industrial Engineering',
            'field' => 'Industrial Systems, Operations Research, Ergonomics & Quality',
            'terms' => [
                'Time and Motion Study & Therbligs', 'Standard Time Calculation & Allowance Factors',
                'Linear Programming & Simplex Method', 'Statistical Process Control (SPC, X-bar & R Charts)',
                'Total Quality Management (TQM) & Six Sigma (DMAIC)', 'Facilities Layout Planning (SLP, CRAFT)',
                'Ergonomics & NIOSH Manual Lifting Equation', 'Lean Manufacturing (5S, Kanban, Value Stream Mapping)',
                'Supply Chain Management & Safety Stock Calculation', 'Queuing Theory (M/M/1 & M/M/c Models)',
                'Engineering Economy & Benefit-Cost Analysis', 'Production Planning & Control (MRP, Master Scheduling)',
                'Human Factors Engineering & Workstation Design'
            ],
            'core_principles' => [
                'Optimizing integrated systems of people, materials, information, equipment, and energy',
                'Conducting stopwatch time studies and setting standard operational cycle times',
                'Formulating and solving constrained optimization models for profit maximization and cost minimization',
                'Monitoring manufacturing processes using control charts to detect special cause variations',
                'Eliminating manufacturing wastes (Muda: overproduction, waiting, transport, defects, motion)',
                'Designing human-centered workstations that minimize musculoskeletal disorders and fatigue',
                'Balancing assembly lines to minimize idle time and maximize line efficiency percentage',
                'Developing material requirements plans (MRP) based on bill of materials and lead times',
                'Determining optimal order quantities (EOQ) and reorder points under demand uncertainty',
                'Evaluating capital investment alternatives using Net Present Value and Internal Rate of Return',
                'Mapping current and future state Value Stream Maps (VSM) to shorten manufacturing lead times',
                'Simulating queuing lines at service counters to optimize customer wait time vs service cost',
                'Adhering to professional industrial engineering ethics and sustainable resource management'
            ],
            'scenario_types' => [
                'An assembly line has a bottleneck station of 45 seconds, causing upstream inventory accumulation',
                'Calculating the standard time for a packaging task given an observed time of 2.5 minutes, 110% rating, and 15% allowance',
                'A manufacturing plant experiences frequent component stockouts; optimizing safety stock for 95% service level',
                'Solving a product-mix linear programming model with labor hour and material supply constraints',
                'A control chart reveals 7 consecutive sample points falling on one side of the centerline (run rule violation)',
                'Evaluating whether a factory operator lifting 20 kg boxes exceeds the NIOSH Recommended Weight Limit (RWL)',
                'Rearranging a job-shop machine layout using Systematic Layout Planning (SLP) to minimize material handling cost',
                'A hospital emergency triage encounters long patient queues; modeling staffing with queuing theory',
                'Calculating assembly line efficiency for a 6-station line with total task time of 180 seconds and 35s cycle time',
                'A Six Sigma project identifies a process capability index (Cpk) of 0.82; taking action to center the process',
                'Conducting an ABC inventory analysis where 20% of items account for 80% of total annual dollar volume',
                'Evaluating whether to replace a 5-year-old forklift with a new automated model using lifecycle costing'
            ],
            'advanced_standards' => [
                'Philippine Institute of Industrial Engineers (PIIE) and ASEAN Engineer Registry standards',
                'ISO 9001:2015 Quality Management Systems certification requirements',
                'Lean Six Sigma Black Belt methodologies and statistical hypothesis testing (ANOVA, DOE)',
                'Occupational Safety and Health Standards (DOLE OSHS) on physical workstation ergonomics',
                'Supply Chain Operations Reference (SCOR) model metrics: reliability, responsiveness, agility',
                'Industry 4.0 smart factory integration (Cyber-Physical Systems, IoT sensor tracking)',
                'Monte Carlo risk simulation in complex multi-echelon supply chain logistics',
                'Environmental lifecycle assessment (ISO 14040) for sustainable industrial processes',
                'Advanced discrete-event simulation modeling using Arena, Simio, or AnyLogic software',
                'Total Productive Maintenance (TPM) and Overall Equipment Effectiveness (OEE) metrics',
                'Human-systems integration and cognitive ergonomics in high-risk control rooms',
                'Code of Ethics for Industrial Engineers in worker welfare, fair labor, and integrity'
            ]
        ],

        25 => [
            'name' => 'BS Chemical Engineering',
            'field' => 'Chemical Processes, Unit Operations, Thermodynamics & Reaction Kinetics',
            'terms' => [
                'Mass and Energy Balances on Reactive Systems', 'Chemical Reaction Engineering & Kinetics',
                'Continuous Stirred-Tank Reactor (CSTR) vs Plug Flow (PFR)', 'Distillation & McCabe-Thiele Graphical Method',
                'Fick\'s Laws of Diffusion & Mass Transfer Coefficients', 'Fluid Flow & Non-Newtonian Rheology',
                'Chemical Engineering Thermodynamics (Phase Equilibria, VLE)', 'Heat Exchanger Design & Shell-and-Tube Geometry',
                'Process Instrumentation & Feedback Control Loops (PID)', 'Process Safety Management (HAZOP & Risk Matrix)',
                'Biochemical Engineering & Fermentation Kinetics', 'Solid-Liquid Separation (Filtration, Centrifugation)',
                'Chemical Engineering Law of 2004 (RA 9297)'
            ],
            'core_principles' => [
                'Setting up comprehensive material and energy balances around chemical process units',
                'Designing ideal chemical reactors (batch, CSTR, PFR) for desired conversion and yield',
                'Calculating minimum reflux ratio and theoretical stages in multi-component distillation columns',
                'Determining fluid friction losses, pumping power, and slurry transport properties in chemical piping',
                'Modeling vapor-liquid equilibrium (VLE) using Raoult\'s Law, activity coefficients, and equations of state',
                'Sizing double-pipe and shell-and-tube heat exchangers using overall heat transfer coefficients (U)',
                'Tuning proportional-integral-derivative (PID) controllers to maintain steady process variables',
                'Executing systematic Hazard and Operability (HAZOP) studies to identify plant risk scenarios',
                'Evaluating biological reaction kinetics (Monod model) in industrial bioreactors and fermenters',
                'Designing gas absorption towers, stripping columns, and liquid-liquid extraction units',
                'Managing chemical waste treatment, biological oxygen demand (BOD), and emissions abatement',
                'Estimating chemical manufacturing capital costs, raw material utilities, and payback periods',
                'Adhering to Republic Act No. 9297 and the Chemical Engineering Code of Ethics'
            ],
            'scenario_types' => [
                'A chemical reactor experiences an exothermic runaway reaction; triggering emergency quench and relief valves',
                'A continuous distillation column produces distillate with lower ethanol purity than specified (92% instead of 95%)',
                'Calculating the volume of a CSTR required to achieve 85% conversion of a first-order liquid-phase reaction',
                'A heat exchanger accumulates heavy organic fouling; calculating the degradation in overall heat transfer coefficient',
                'A slurry pump cavitation occurs when pumping high-viscosity non-Newtonian polymer melt',
                'Designing a gas absorption column to remove 99% of toxic SO2 gas from a factory exhaust stream using alkaline water',
                'A PID temperature controller exhibits continuous hunting oscillations around the 150°C setpoint; retuning gains',
                'Conducting a HAZOP analysis on a chlorine storage facility and identifying a high-consequence failure mode',
                'Calculating the theoretical minimum number of trays for an equimolar benzene-toluene distillation column',
                'A biological wastewater treatment basin exhibits a sudden drop in dissolved oxygen and bacterial biomass die-off',
                'Determining the mass flow rate of cooling water required to condense 5,000 kg/hr of saturated steam',
                'Evaluating safety relief valve sizing for a pressurized chemical storage sphere under external pool fire conditions'
            ],
            'advanced_standards' => [
                'Republic Act No. 9297 (The Chemical Engineering Law of 2004) and Professional Regulatory Board of Chemical Engineering',
                'OSHA Process Safety Management (PSM 29 CFR 1910.119) and EPA Risk Management Programs',
                'American Institute of Chemical Engineers (AIChE) Center for Chemical Process Safety (CCPS) guidelines',
                'Philippine Toxic Substances and Hazardous and Nuclear Wastes Control Act of 1990 (RA 6969)',
                'Clean Water Act (RA 9275) and DENR Administrative Order discharge standards',
                'Advanced process simulation using Aspen Plus, Aspen HYSYS, or ChemCAD software',
                'Pinch Analysis and Heat Integration for industrial energy optimization',
                'Catalysis engineering: catalyst deactivation, poisoning, and regeneration kinetics',
                'Nanotechnology and advanced materials synthesis processes',
                'Carbon capture, utilization, and storage (CCUS) process thermodynamics',
                'Professional liability in chemical plant commissioning, sign-off, and hazard mitigation',
                'Chemical engineering ethics in public environmental protection and worker safety'
            ]
        ],

        26 => [
            'name' => 'BS Architecture',
            'field' => 'Architectural Design, Building Technology, History & Theory',
            'terms' => [
                'Vitruvian Triad (Firmitas, Utilitas, Venustas)', 'National Building Code of the Philippines (PD 1096)',
                'Space Programming & Functional Adjacency Matrix', 'Architectural History (Classical, Gothic, Modernism, Brutalism)',
                'Passive Cooling & Tropical Architectural Design', 'Building Envelope, Daylighting & Thermal Comfort',
                'Building Utilities (Sanitary, Electrical, Mechanical, Acoustics)', 'Architectural Working Drawings & Detailing',
                'Zoning Ordinances, Setbacks & Floor Area Ratio (FAR)', 'Building Information Modeling (BIM Workflows)',
                'Structural Concepts in Architectural Form', 'Accessibility Law (Batas Pambansa Blg. 344)',
                'The Architecture Act of 2004 (RA 9266)'
            ],
            'core_principles' => [
                'Harmonizing aesthetic form, structural integrity, and functional human space utility',
                'Translating user requirements and spatial relationships into coherent architectural schematics',
                'Designing climate-responsive tropical buildings optimizing natural cross-ventilation and sun-shading',
                'Complying with mandatory legal setbacks, allowable building footprints, and parking allocations',
                'Integrating building utility systems (plumbing stacks, HVAC risers, electrical conduits) seamlessly',
                'Specifying building materials based on durability, thermal resistance, fire rating, and environmental footprint',
                'Ensuring universal accessibility, ramps, tactile paving, and barrier-free facilities under BP 344',
                'Creating detailed construction documents, schedules of finishes, and door/window schedules',
                'Coordinating multidisciplinary models in BIM software to eliminate spatial clashes before construction',
                'Preserving historical heritage structures while accommodating adaptive reuse renovations',
                'Applying site planning principles to topography, solar orientation, wind paths, and view corridors',
                'Estimating project construction budgets based on bill of quantities and square meter rates',
                'Upholding the Architect\'s National Code of Ethics and legal accountability under RA 9266'
            ],
            'scenario_types' => [
                'A commercial mid-rise building proposal exceeds the maximum allowable Floor Area Ratio (FAR) for its zone',
                'A residence in Cavite experiences extreme afternoon heat gain through large west-facing glass facades',
                'Designing a wheelchair ramp connecting a ground floor lobby with an elevation change of 1.2 meters under BP 344',
                'Resolving a spatial clash in a BIM model between a major structural girder and a main HVAC supply duct',
                'A client requests a 100% building footprint on a corner lot; enforcing mandatory PD 1096 yard setbacks',
                'Selecting appropriate building acoustic insulation and surface reverberation finishes for a 500-seat auditorium',
                'Designing a functional bubble diagram and adjacency matrix for a community medical outpatient clinic',
                'A tropical resort design requires cross-ventilation without active air-conditioning in guest villas',
                'Calculating the required fire exit widths and maximum travel distance to stairs under the Fire Code of the Philippines',
                'Designing an urban infill mixed-use project that preserves an existing century-old ancestral stone facade',
                'Detailing a roof-to-wall flashing junction to prevent water intrusion during extreme typhoon typhoons',
                'Conducting a post-occupancy evaluation on a new corporate headquarters to assess spatial efficiency'
            ],
            'advanced_standards' => [
                'Republic Act No. 9266 (The Architecture Act of 2004) and UAP Professional Standards',
                'Presidential Decree No. 1096 (National Building Code of the Philippines) and its Revised IRR',
                'Batas Pambansa Blg. 344 (Accessibility Law) and Republic Act No. 9514 (Fire Code of the Philippines 2008)',
                'Philippine Green Building Code and BERDE / LEED Sustainable Building Rating Systems',
                'Space planning standards under the National Housing Authority (NHA) and BP 220 socialized housing',
                'Heritage preservation laws under the National Cultural Heritage Act of 2009 (RA 10066)',
                'Advanced parametric modeling and computational generative design (Rhino/Grasshopper)',
                'Life cycle assessment (LCA) and embodied carbon calculation in construction materials',
                'Comprehensive land use planning (CLUP) and urban master planning frameworks',
                'AIA and UAP Document 200 series for Standard Contracts, Fees, and Architect-Client Agreements',
                'Legal liability of architects under Article 1723 of the Philippine Civil Code for building collapse (15-year warranty)',
                'Ethics in competitive bidding, intellectual design copyright, and peer professional respect'
            ]
        ]
    ];

    // Helper to generate full 50 questions for each engineering profile
    foreach ($profiles as $degId => $p) {
        $out[$degId] = [];

        // Stage 1: 13 questions (Fundamentals)
        for ($i = 0; $i < 13; $i++) {
            $term = $p['terms'][$i % count($p['terms'])];
            $qText = "In {$p['name']}, what is the foundational technical significance of '$term'?";
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

    // Now populate Degrees 27 through 50 using domain-specific health and humanities generator
    require_once __DIR__ . '/domain_curricula_27_50.php';
    $rest = getCurriculaDegrees27To50();
    foreach ($rest as $id => $qs) {
        $out[$id] = $qs;
    }

    return $out;
}
