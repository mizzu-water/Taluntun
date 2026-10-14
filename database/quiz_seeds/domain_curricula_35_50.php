<?php
/**
 * Final Batch: Degrees 35 to 50
 * Hospitality, Maritime, Criminology, Humanities, Social Sciences, Pure Sciences
 * 50 questions per degree across Stages 1, 2, 3, and 4
 */

function getCurriculaDegrees35To50() {
    $out = [];

    $profiles = [
        35 => [
            'name' => 'BS Hospitality Management',
            'field' => 'Hospitality Operations, Hotel Management, F&B & Guest Relations',
            'terms' => [
                'Front Office Property Management Systems (PMS)', 'Housekeeping Room Status Codes (VR, VD, OOO, OC)',
                'Food & Beverage Table Service Styles (American, French, Russian, English)',
                'Banquet Event Order (BEO) Specifications', 'HACCP Seven Food Safety Principles',
                'Guest Complaint De-escalation (LAST Model: Listen, Apologize, Solve, Thank)',
                'Menu Engineering Matrix (Stars, Plowhorses, Puzzles, Dogs)',
                'Revenue Management Metrics: RevPAR (Revenue Per Available Room) & ADR',
                'Hospitality Yield Management & Overbooking Strategies', 'Beverage Cost Percentage & Standard Drink Pouring',
                'Service Blueprinting in Hospitality Experiences', 'Sanitation Standard Operating Procedures (SSOP)',
                'Hospitality Labor Cost Percentage & Scheduling'
            ],
            'core_principles' => [
                'Delivering exceptional guest experience through anticipation of customer needs',
                'Optimizing hotel room revenue using dynamic pricing and occupancy forecasting',
                'Enforcing strict sanitary standards and cold-chain temperature logs in food service',
                'Managing seamless room turnover and white-glove inspection standards in housekeeping',
                'Executing coordinated banquet and event catering operations from setup to breakdown',
                'Calculating menu item food cost percentages and optimizing profitable recipe pricing',
                'Training frontline staff in cultural sensitivity, professional etiquette, and grooming',
                'Resolving difficult guest complaints with immediate empowerment and service recovery',
                'Controlling beverage shrinkage, spillage, and liquor inventory through spot audits',
                'Maintaining hotel property physical security, keycard access, and emergency response',
                'Minimizing operational waste and implementing sustainable green hotel initiatives',
                'Managing hotel employee turnover through positive workplace culture and incentives',
                'Adhering to hospitality legal liabilities (innkeeper laws, guest property protection)'
            ],
            'scenario_types' => [
                'A VIP guest arrives at check-in but the executive suite is currently marked Occupied Dirty (OD)',
                'A hotel has 200 rooms with 80% occupancy and total room revenue of $24,000; calculating RevPAR ($120)',
                'A diner finds a physical foreign object in their soup during a busy dinner rush in the hotel restaurant',
                'Calculating food cost percentage for a steak dish selling for $35 with raw ingredient costs of $10.50 (30%)',
                'A guest reports their luxury watch stolen from their room while the "Do Not Disturb" sign was displayed',
                'A banquet room setup requires 25 round banquet tables seating 10 guests each with proper aisle clearances',
                'A front desk clerk experiences an angry corporate client whose confirmed booking was lost due to overbooking',
                'A refrigerator unit in the pastry kitchen warms to 12°C during overnight operations; initiating food safety action',
                'An analysis of the menu reveals that an item has high profitability but low popularity (a "Puzzle" item)',
                'Managing a sudden 40% surge in room service orders during a heavy storm when staff attendance is down',
                'A housekeeper discovers hazardous chemical spillage in the laundry facility; executing MSDS safety protocols',
                'Designing a green hospitality program to reduce single-use plastics and linen washing water consumption'
            ],
            'advanced_standards' => [
                'Department of Tourism (DOT) National Accommodation Standards and Star-Rating System for Hotels',
                'Codex Alimentarius and ISO 22000 Food Safety Management Systems certification',
                'Innkeeper liability laws under the Philippine Civil Code (Articles 1998-2004)',
                'Occupational safety in commercial kitchens and laundry plants under DOLE OSHS',
                'Revenue management algorithms and automated rate shopping intelligence software',
                'Crisis management protocols for hotels during natural disasters, fires, or public health emergencies',
                'Sustainable tourism criteria by the Global Sustainable Tourism Council (GSTC)',
                'International hotel franchise management agreements and brand standard auditing',
                'Labor law compliance regarding service charge collection and 100% distribution under RA 11360',
                'Data privacy compliance for international guest passports and credit card billing (PCI-DSS)',
                'Professional ethics in guest privacy, anti-human trafficking monitoring, and nondiscrimination',
                'Hospitality asset management and capital expenditure (CapEx) reserve planning'
            ]
        ],

        36 => [
            'name' => 'BS Tourism Management',
            'field' => 'Tourism Planning, Destination Management, Travel Agency & Ecotourism',
            'terms' => [
                'Butler\'s Tourist Area Life Cycle (TALC Model: Exploration to Rejuvenation/Decline)',
                'Global Distribution Systems (Amadeus, Sabre, Travelport)',
                'Tour Package Itinerary Costing & Net Rate Markup Calculations',
                'Principles of Sustainable Ecotourism & Carrying Capacity (Physical, Real, Effective)',
                'UNWTO Definitions of Inbound, Outbound, and Domestic Tourism',
                'Passport and Visa Classifications, Border Control & Immigration Rules',
                'Push and Pull Travel Motivation Factors (Iso-Ahola & Dann)',
                'Destination Management Organizations (DMOs) & Destination Branding',
                'MICE Industry (Meetings, Incentives, Conferences, Exhibitions)',
                'Tourism Multiplier Effect & Economic Leakage in Local Economies',
                'Cultural Heritage Tourism & Authenticity Preservation',
                'Philippine Tourism Act of 2009 (RA 9593)', 'Travel Risk Management & Tourist Safety Protocols'
            ],
            'core_principles' => [
                'Formulating sustainable tourism development plans balancing economic growth with conservation',
                'Evaluating environmental carrying capacity to prevent ecological degradation from overtourism',
                'Assembling multi-day domestic and international travel itineraries with certified suppliers',
                'Promoting community-based ecotourism (CBET) that empowers local indigenous residents',
                'Executing international airline reservation ticketing adhering to IATA standard guidelines',
                'Conducting destination marketing campaigns utilizing digital storytelling and cultural branding',
                'Preserving tangible and intangible cultural heritage sites from commercial tourist commodification',
                'Analyzing economic impacts, visitor spending patterns, and local employment generation',
                'Organizing large-scale international conferences, exhibitions, and convention logistics',
                'Coordinating tourist disaster evacuation, travel insurance claims, and emergency assistance',
                'Ensuring tourism facility accessibility and inclusivity for senior and disabled travelers',
                'Fostering environmental education and Leave No Trace principles among tourist visitors',
                'Upholding the UNWTO Global Code of Ethics for Tourism'
            ],
            'scenario_types' => [
                'A famous tropical island beach destination experiences severe coral bleaching and waste buildup from overtourism',
                'Calculating the retail selling price of a 4-day Palawan tour package with net supplier costs of $300 and a 25% markup ($400)',
                'A tour group is stranded at an international airport due to sudden airline strike action and canceled flights',
                'An ecotourism cave site has a physical carrying capacity limit of 150 visitors daily, but 500 tourists arrive on a holiday',
                'Designing a community-based cultural tour that compensates indigenous weavers fairly without exploiting their traditions',
                'A travel agency client loses their passport and tourist visa while traveling in a foreign capital city',
                'Evaluating the tourism multiplier effect in a coastal municipality after the opening of a new cruise ship port',
                'A Category 4 typhoon approaches a beach resort island; executing an emergency tourist evacuation plan to the mainland',
                'A corporate client requests a carbon-neutral MICE convention for 1,000 delegates with eco-certified catering',
                'Resolving a cross-cultural communication conflict between an international tour guide and local village elders',
                'Developing a crisis recovery marketing campaign for a tourist destination following a major volcanic eruption',
                'A travel agency books an international ticket using a GDS but makes an error in the passenger\'s passport name spelling'
            ],
            'advanced_standards' => [
                'Republic Act No. 9593 (The Tourism Act of 2009) and Department of Tourism (DOT) governance',
                'UNWTO Global Code of Ethics for Tourism and Sustainable Development Goals (SDGs)',
                'National Ecotourism Strategy and Action Plan (NESAP) guidelines in protected areas',
                'IATA (International Air Transport Association) ticketing rules and passenger rights',
                'UNESCO World Heritage Convention guidelines for cultural and natural heritage site management',
                'Climate change vulnerability assessments for low-lying island and mountain tourism destinations',
                'Crisis communications and reputation management in the global tourism industry',
                'Strategic destination branding and place identity marketing frameworks',
                'Child protection in travel and tourism: combating child sexual exploitation (The Code)',
                'Legal liability of tour operators in adventure tourism accidents and third-party negligence',
                'Ethics in promoting indigenous communities and avoiding voyeuristic "poverty tourism"',
                'ASEAN Mutual Recognition Arrangement on Tourism Professionals (MRA-TP) competencies'
            ]
        ],

        37 => [
            'name' => 'BS Hotel and Restaurant Management',
            'field' => 'Hotel Operations, Culinary Arts, Dining Service & Kitchen Management',
            'terms' => [
                'Classical Kitchen Brigade System (Escoffier Hierarchy: Chef de Cuisine, Sous Chef, Saucier)',
                'Dry Heat vs Moist Heat Cooking Methods (Braising, Sautéing, Poaching, Roasting)',
                'Food Cost Percentage & Standardized Recipe Costing', 'Portion Control Tools & Recipe Yield Testing',
                'Beverage Cost Management & Bar Pour Cost Percentage', 'Hotel Property Management Systems (Opera PMS)',
                'Table Setting Rules & Cutlery Placement (Formal Covers)', 'Dining Room Table Turnover Rate',
                'Commercial Kitchen Layout (Flow of Food: Receiving, Storage, Prep, Cooking, Service)',
                'Hazard Analysis Critical Control Point (HACCP Monitoring)', 'Front of House vs Back of House Synchronization',
                'Cross-Contamination Prevention & Color-Coded Cutting Boards', 'Service Quality Evaluation (SERVQUAL Model)'
            ],
            'core_principles' => [
                'Directing back-of-house culinary brigades with disciplined kitchen timing and plating standards',
                'Calculating accurate food cost percentages and maintaining kitchen profitability within 28-32% margins',
                'Executing precision culinary knife cuts (julienne, brunoise, batonnet, chiffonade) and classic sauces',
                'Enforcing strict sanitary separation of raw meats and ready-to-eat foods to prevent cross-contamination',
                'Managing dining room service sequences: greeting, order taking, course delivery, wine service, billing',
                'Performing yield tests on raw meat, poultry, and fish to determine edible portion (EP) vs as-purchased (AP) cost',
                'Managing bar inventory, draft beer systems, liquor pars, and responsible service of alcohol',
                'Optimizing table turnover rates during peak dinner service while preserving an unhurried guest ambiance',
                'Coordinating commercial kitchen equipment maintenance (grease traps, exhaust hoods, walk-in freezers)',
                'Auditing hotel front desk check-in speeds, bell service, housekeeping turn-down, and guest satisfaction',
                'Designing allergen-safe kitchen prep protocols for common food allergens (peanuts, shellfish, gluten)',
                'Training food servers in suggestive upselling, beverage pairing, and silver service techniques',
                'Adhering to food sanitation laws, liquor licensing regulations, and hospitality employment codes'
            ],
            'scenario_types' => [
                'A kitchen line cook uses the same raw poultry cutting board to slice fresh salad tomatoes without washing',
                'A restaurant prepares a banquet for 200 guests; calculating total raw beef needed given a 75% yield and 200g portion (53.3 kg)',
                'A busy Friday dinner service experiences a 45-minute order ticket backlog between the hot line and waitstaff',
                'A sommelier presents an expensive bottle of red wine at tableside; demonstrating correct cork presentation and pouring',
                'A restaurant\'s monthly food cost percentage spikes to 42% against a 30% target; investigating kitchen waste and theft',
                'A customer informs the food server of a severe peanut allergy after their dish has already been placed on the table',
                'A guest complains that their medium-rare steak arrived at tableside well-done and completely dry; executing service recovery',
                'Calibrating a dial stem food thermometer using the ice-point method (0°C / 32°F) before testing cooked poultry',
                'Managing an unruly, intoxicated bar patron safely and refusing further alcohol service under dram shop principles',
                'A walk-in freezer door is left ajar overnight, allowing internal temperatures to rise to 8°C; inspecting food safety',
                'Balancing front office cash drawers at the end of a night audit shift and investigating an unaccounted cash discrepancy',
                'Designing an ergonomic commercial kitchen line layout that eliminates cross-traffic between dishwashing and cooking'
            ],
            'advanced_standards' => [
                'Sanitation Code of the Philippines (Presidential Decree No. 856) commercial food establishment rules',
                'ServSafe Food Protection Manager certification and FDA Food Code compliance',
                'Menu engineering analytics and matrix optimization by Kasavana and Smith',
                'Sommelier international wine certification standards (Court of Master Sommeliers / WSET)',
                'Culinary copyright, trade secret protection for signature restaurant recipes, and franchise compliance',
                'Commercial kitchen exhaust ventilation and grease extraction fire codes under NFPA 96',
                'Labor management and fair tip/gratuity distribution under the Philippine Service Charge Law',
                'Supply chain procurement ethics, supplier kickback prevention, and cold-chain transparency',
                'Sustainable gastronomy: farm-to-table sourcing, zero food waste kitchens, and composting',
                'Liquor liability laws, underage drinking prevention, and corporate responsible service policies',
                'Crisis management in foodborne illness outbreaks (Salmonella, Norovirus, E. coli): trace-back protocols',
                'Professional ethics in kitchen leadership, fair brigade treatment, and workplace anti-harassment'
            ]
        ],

        38 => [
            'name' => 'BS Marine Transportation',
            'field' => 'Nautical Science, Maritime Navigation, Seamanship & Ship Operations',
            'terms' => [
                'International Regulations for Preventing Collisions at Sea (COLREGs 1972)',
                'Terrestrial & Celestial Navigation (Sextant, Sight Reduction, Sun Sights)',
                'Electronic Chart Display and Information System (ECDIS & Paper Charts)',
                'Radar & Automatic Radar Plotting Aids (ARPA: CPA and TCPA Calculations)',
                'Ship Stability & Hydrostatics (Metacentric Height GM, Center of Gravity G, Buoyancy B)',
                'International Convention for the Safety of Life at Sea (SOLAS 1974)',
                'International Convention on Standards of Training, Certification and Watchkeeping (STCW)',
                'IALA Maritime Buoyage System (Region A vs Region B Lateral Marks)',
                'Bridge Resource Management (BRM) & Master-Pilot Relationship',
                'Cargo Stowage & Securing (CSS Code, Bulk Cargoes IMSBC, Dangerous Goods IMDG)',
                'Passage Planning Four Stages (Appraisal, Planning, Execution, Monitoring)',
                'Marine Meteorology (Tropical Revolving Storms TRS Avoidance, Barometric Pressure)',
                'International Ship and Port Facility Security Code (ISPS Code)'
            ],
            'core_principles' => [
                'Maintaining a continuous, diligent visual and electronic navigational lookout at all times',
                'Applying COLREGs steering and sailing rules in head-on, crossing, and overtaking encounter situations',
                'Plotting ship positions accurately using GPS, radar ranges/bearings, visual landmarks, and celestial observations',
                'Calculating Closest Point of Approach (CPA) and Time to CPA (TCPA) to avoid maritime collisions',
                'Ensuring adequate intact and damage stability, verifying positive metacentric height (GM) before sailing',
                'Executing comprehensive berth-to-berth passage plans considering draft, tides, and navigational hazards',
                'Stowing and securing breakbulk, containerized, and bulk cargo preventing dangerous cargo shifting at sea',
                'Conducting emergency drills (fire, abandon ship, man overboard) adhering strictly to SOLAS mandates',
                'Navigating safely in restricted visibility using appropriate sound signals and safe radar speeds',
                'Understanding atmospheric pressure drops, Coriolis effect, and maneuvering away from cyclonic dangerous semicircles',
                'Communicating internationally with ships and port authorities using standard marine communication phrases (SMCP)',
                'Managing bridge teams through open communication, assertive briefing, and situational awareness',
                'Upholding the MARINA (Maritime Industry Authority) seafarer code of conduct and international conventions'
            ],
            'scenario_types' => [
                'Two power-driven vessels approach head-on in open sea; COLREGs Rule 14 mandates both alter course to starboard',
                'A ship\'s ARPA display flags an approaching container ship with a CPA of 0.1 nautical miles in 8 minutes (Collision risk)',
                'A vessel\'s GM becomes negative during cargo loading; identifying the dangerous condition of loll and correcting it',
                'Navigating in heavy fog when a radar target is detected on the port bow with no visual contact; determining safe action',
                'A crew member falls overboard in open water; executing a Williamson Turn maneuver to return to the original track line',
                'Calculating true course and magnetic course from a nautical chart considering variation and compass deviation',
                'A bulk carrier loading iron ore concentrates encounters cargo liquefaction risks; checking moisture limits under IMSBC',
                'Navigating a narrow channel marked by IALA Region A buoyage: keeping red port hand lateral buoys on the port side on entry',
                'A tropical storm approaches: the barometric pressure drops 5 hPa in 3 hours with shifting winds; identifying the storm sector',
                'Anchoring a 50,000 DWT vessel in 20 meters of water; calculating the required scope of chain (usually 5 to 7 times depth)',
                'Executing a mandatory pre-departure bridge checklist verifying steering gear, gyro compass, and radar synchronization',
                'Handling a shipboard fire alarm in the paint locker during high-seas transit; sounding general emergency alarms'
            ],
            'advanced_standards' => [
                'International Maritime Organization (IMO) Conventions: SOLAS 74, MARPOL 73/78, STCW 78 as amended',
                'Maritime Industry Authority (MARINA) STCW circulars and officer licensure assessment standards',
                'Code of Safe Working Practices for Merchant Seafarers (COSWP)',
                'International Safety Management Code (ISM Code) for ship operation and pollution prevention',
                'Maritime Labour Convention, 2006 (MLC 2006) seafarers\' rights, living conditions, and hours of rest',
                'Vessel Traffic Services (VTS) reporting and Traffic Separation Schemes (TSS) adherence (COLREGs Rule 10)',
                'Emergency towing arrangements and salvage operations under Lloyd\'s Open Form (LOF)',
                'Ballast Water Management Convention (BWM Convention) to prevent invasive aquatic species transfer',
                'Advanced celestial navigation: sight reduction tables (Pub 229/249) and intercept method (Marcq St. Hilaire)',
                'Shiphandling hydrodynamics: shallow water effect, bank suction, bank cushion, and ship-to-ship interaction',
                'Piracy countermeasures and Best Management Practices (BMP5) for transiting high-risk maritime zones',
                'Professional ethics of the Shipmaster: supreme nautical authority, safety of life at sea, and salvage duty'
            ]
        ],

        39 => [
            'name' => 'BS Marine Engineering',
            'field' => 'Marine Propulsion, Shipboard Machinery, Marine Electrical & Auxiliaries',
            'terms' => [
                'Marine Two-Stroke Low-Speed Diesel Engines & Four-Stroke Medium-Speed Engines',
                'Marine Auxiliary Boilers & Steam Generation Systems',
                'Ship Fuel Oil Treatment (Heavy Fuel Oil Purifiers, Clarifiers, Centrifuges)',
                'Hydraulic Steering Gear Systems (Ram-type, Rotary Vane & Emergency Steering)',
                'Oily Water Separator (OWS & 15 ppm Bilge Alarm under MARPOL Annex I)',
                'Ship Electrical Power Distribution (440V, 3-Phase, Insulated Neutral / Ungrounded Systems)',
                'Marine Refrigeration Systems & Provision Cold Stores',
                'Fresh Water Generators (Vacuum Evaporators & Reverse Osmosis Plants)',
                'Propulsion Shafting, Stern Tube Bearing & Controllable Pitch Propellers (CPP)',
                'Engine Room Resource Management (ERRM) & Safe Watchkeeping Protocols',
                'Air Compressors & Main Engine Starting Air Systems (30 bar Reservoirs)',
                'Fire Detection & Fixed Firefighting Systems in Engine Spaces (CO2 Total Flooding)',
                'International Convention for the Prevention of Pollution from Ships (MARPOL 73/78)'
            ],
            'core_principles' => [
                'Operating, monitoring, and maintaining marine main propulsion diesel engines at optimal sea speed',
                'Executing safe fuel oil bunkering, purifier separation, and viscosity control for heavy marine fuel',
                'Maintaining ship electrical switchboards, diesel generator paralleling, and preferential tripping',
                'Operating auxiliary boilers safely and monitoring chemical feedwater treatment to prevent boiler tube scaling',
                'Treating engine room bilge water strictly through 15 ppm oily water separators prior to overboard discharge',
                'Managing marine freshwater generators to produce pure boiler feed and domestic potable water',
                'Executing routine watchkeeping inspections of temperatures, lube oil pressures, and exhaust gas readings',
                'Performing scheduled maintenance (piston overhauls, cylinder liner wear measurements, injector testing)',
                'Operating emergency steering gear systems from the steering flat in the event of bridge telemotor failure',
                'Maintaining compressed air receivers at 30 bar to ensure mandatory minimum consecutive engine starts',
                'Enforcing strict confined space entry permits and gas testing before entering double-bottom tanks',
                'Responding instantly to engine room alarms, machinery breakdowns, and blackout emergencies',
                'Adhering to MARINA STCW Marine Engineering standards and environmental compliance'
            ],
            'scenario_types' => [
                'A main diesel engine cylinder exhaust gas temperature surges 100°C above others with black smoke (fuel injector fault)',
                'An oily water separator 15 ppm monitor triggers an alarm and activates the three-way recirculating valve automatically',
                'A shipboard electrical blackout occurs while maneuvering in a port channel; executing emergency generator restart',
                'A high-pressure fuel injection pipe ruptures on an auxiliary diesel generator; fuel mist triggers engine mist detector',
                'Testing the emergency steering gear: transferring control from bridge to steering gear room within 60 seconds',
                'A marine purifuer experiences heavy water seal break and begins discharging heavy fuel oil out the sludge outlet',
                'A scavenge space fire alarm sounds on Cylinder #4 of a large two-stroke engine; reducing RPM and releasing CO2 smothering',
                'A marine refrigeration compressor runs continuously with low suction pressure and frost forming along the suction line',
                'Measuring cylinder liner diameter using an inside micrometer at multiple depths to calculate ovality and diametric wear',
                'An auxiliary boiler experiences low water level cutout failure; immediately cutting fuel burners to prevent boiler explosion',
                'A main engine lube oil sample shows high water content and severe drop in TBN (Total Base Number); investigating oil cooler leaks',
                'Performing an emergency drill: simulating a major machinery space fire requiring automated CO2 flooding evacuation'
            ],
            'advanced_standards' => [
                'MARPOL 73/78 Annexes: Annex I (Oil), Annex IV (Sewage), Annex V (Garbage), Annex VI (Air Pollution & SOx/NOx limits)',
                'MARINA STCW circulars for Officer in Charge of an Engineering Watch (OICEW) and Chief Engineer Licensure',
                'Classification Society Rules (DNV, Lloyd\'s Register, ABS) for ship machinery construction and survey',
                'Energy Efficiency Existing Ship Index (EEXI) and Carbon Intensity Indicator (CII) decarbonization rules',
                'Dual-fuel marine engines (LNG, Methanol, Ammonia) and cryogenic fuel storage systems (IGF Code)',
                'Condition-based monitoring: vibration spectrum analysis, lube oil tribology, and thermal imaging of electrical buses',
                'Automation, PLC control loops, and Unattended Machinery Space (UMS) certification requirements',
                'Fixed fire extinguishing system regulations: High-Pressure Water Mist vs High-Expansion Foam in engine rooms',
                'Dry-docking procedures: tailshaft survey, rudder clearance measurements, and hull cathodic protection',
                'Occupational safety: Control of Hazardous Energy (Lockout/Tagout - LOTO) in high-voltage ship systems',
                'Legal liability in marine environmental pollution: Oil Record Book Part I accurate recording and strict penalties',
                'Professional ethics of the Chief Engineer: seaworthiness of machinery and uncompromising safety integrity'
            ]
        ],

        40 => [
            'name' => 'BS Criminology',
            'field' => 'Criminology, Criminal Law, Forensic Science & Law Enforcement',
            'terms' => [
                'Revised Penal Code of the Philippines (Act No. 3815: Felonies, Criminal Liability)',
                'Classical vs Positivist vs Sociological Schools of Criminology',
                'Crime Scene Investigation (CSI) & Physical Chain of Custody',
                'Dactyloscopy (Fingerprint Classification: Arches, Loops, Whorls, Henry System)',
                'Forensic Ballistics (Firearms Identification, Rifling Lands & Grooves, Striation Marks)',
                'Questioned Document Examination (Handwriting Analysis, Forgery Types)',
                'Custodial Investigation Rights & Miranda Doctrine (Republic Act No. 7438)',
                'Polygraph Examination (Lie Detection: Pneumograph, Galvanograph, Cardio-Sphygmograph)',
                'Police Patrol Operations & Community-Oriented Policing (COPS)',
                'Correctional Administration (Institutional vs Community-Based Corrections, Parole & Probation)',
                'Juvenile Justice and Welfare Act of 2006 (Republic Act No. 9344)',
                'Philippine Criminology Profession Act of 2018 (RA 11131)', 'Criminal Investigation Seven Golden Rules'
            ],
            'core_principles' => [
                'Analyzing the causes, nature, extent, and control of criminal behavior in society',
                'Securing, cordoning, and processing crime scenes preserving fragile physical evidence',
                'Establishing a documented, unbroken chain of custody for all physical and forensic evidence',
                'Applying the elements of criminal felonies (mens rea, actus reus, concurrence) under the RPC',
                'Classifying and comparing friction ridge fingerprint patterns using standardized points of comparison',
                'Conducting constitutional custodial investigations ensuring suspect rights to counsel and against torture',
                'Matching fired bullets and cartridge cases to suspect firearms under a comparison microscope',
                'Executing tactical police patrol strategies to prevent crimes and build community trust',
                'Supervising inmate rehabilitation, classification, and reintegration programs in correctional facilities',
                'Evaluating offender risk, recidivism rates, and probation eligibility under the Probation Law (PD 968)',
                'Applying non-adversarial, restorative justice procedures for children in conflict with the law (CICL)',
                'Conducting cognitive interrogation techniques within legal bounds to elicit verifiable truthful statements',
                'Upholding the Code of Ethics for Registered Criminologists and Law Enforcement Officers'
            ],
            'scenario_types' => [
                'An investigator arrives at a homicide crime scene; first establishing perimeter security and logging all personnel entries',
                'A latent fingerprint is lifted from a glass window; classifying the pattern as an Ulnar Loop with 14 ridge counts',
                'An arresting officer fails to inform an arrestee of their right to remain silent and right to counsel; rendering the confession inadmissible',
                'A fired 9mm bullet recovered from a victim is examined under a comparison microscope against a test-fired bullet from a seized gun',
                'Determining criminal liability: John intended to injure Mark but accidentally killed Peter (aberratio ictus under RPC Art. 4)',
                'A 14-year-old minor is apprehended for shoplifting; diverting the child to local social welfare interventions under RA 9344',
                'A polygraph examiner observes elevated galvanic skin response and sudden suppression in respiration during a relevant question',
                'An investigator uncovers an altered check where the original ink differs from the forged amount under ultraviolet light examination',
                'A police team executes a search warrant; seizing firearms not described in the warrant; assessing the Plain View Doctrine',
                'Classifying an offender who commits a robbery while armed with a bladed weapon: identifying aggravating circumstances',
                'An inmate applies for parole after serving minimum sentence; reviewing behavior records and restorative justice compliance',
                'A forensic toxicologist identifies lethal levels of carbon monoxide in a fire victim\'s blood, proving the victim was alive during the fire'
            ],
            'advanced_standards' => [
                'Republic Act No. 11131 (The Philippine Criminology Profession Act of 2018) and Professional Regulatory Board of Criminology',
                'The 1987 Constitution of the Philippines Bill of Rights (Article III: Due Process, Warrantless Arrest Rules)',
                'Comprehensive Dangerous Drugs Act of 2002 (RA 9165 Section 21 custody of seized drugs rules)',
                'Anti-Torture Act of 2009 (Republic Act No. 9745) and PNP Operational Procedures Manual',
                'DNA evidence admissibility guidelines under the Philippine Supreme Court Rule on DNA Evidence',
                'Forensic digital evidence acquisition and chain of custody under the Cybercrime Prevention Act (RA 10175)',
                'Victimology and restorative justice frameworks in modern criminal justice systems',
                'Terrorism prevention and financing countermeasures under the Anti-Terrorism Act of 2020 (RA 11479)',
                'United Nations Standard Minimum Rules for the Treatment of Prisoners (The Nelson Mandela Rules)',
                'Ballistic identification technologies: Automated Fingerprint Identification Systems (AFIS) and IBIS',
                'Specialized crime profiling, geographic profiling, and serial criminal investigation methodologies',
                'Law enforcement ethics: human rights compliance, zero tolerance for extrajudicial killings, and anti-corruption'
            ]
        ],

        // --- ARTS, HUMANITIES, SOCIAL SCIENCES & PURE SCIENCES (41 to 50) ---
        41 => [
            'name' => 'AB Communication',
            'field' => 'Communication Theory, Media Studies, Public Relations & Journalism',
            'terms' => [
                'Shannon-Weaver & Berlo\'s SMCR Communication Models', 'Agenda-Setting Theory & Media Framing',
                'Interpersonal & Nonverbal Communication Cues (Proxemics, Kinesics, Paralanguage)',
                'Public Relations Press Releases & Media Kits', 'Crisis Communication Strategies (Image Restoration Theory)',
                'Semiotics (Saussure & Peirce: Signifier, Signified, Icon, Index, Symbol)',
                'Aristotelian Rhetoric Appeals (Ethos, Pathos, Logos)', 'Audience Segmentation & Demographics/Psychographics',
                'Media Literacy & Combating Disinformation', 'Broadcasting Rundowns & Production Scripts',
                'Philippine Cybercrime Prevention Act of 2012 (RA 10175)', 'Communication Ethics & Libel Laws (RPC Art. 353)'
            ],
            'core_principles' => [
                'Designing persuasive, ethical communication campaigns tailored to specific target audiences',
                'Deconstructing media messages, visual symbols, and corporate framing in mass culture',
                'Managing organizational public relations, media relations, and brand reputation',
                'Formulating immediate, transparent, and empathetic corporate crisis communication responses',
                'Applying nonverbal communication awareness to intercultural negotiations and presentations',
                'Conducting quantitative and qualitative communication research (content analysis, focus groups)',
                'Producing multi-platform broadcast, audio, and digital video media content with professional pacing',
                'Evaluating the democratic role of free press and independent media in civil society',
                'Navigating legal boundaries of free speech, intellectual property, copyright, and defamation',
                'Developing community communication campaigns aimed at social change and public health advocacy',
                'Analyzing social media algorithm engagement dynamics and ethical digital footprints',
                'Delivering articulate, structured public addresses and strategic corporate pitches',
                'Upholding the Public Relations Society of the Philippines (PRSP) Code of Ethics'
            ],
            'scenario_types' => [
                'A food brand faces viral social media claims of food poisoning; formulating a rapid crisis communication response plan',
                'A public health agency needs to design a vaccination awareness campaign for vaccine-hesitant rural communities',
                'Writing an effective corporate press release announcing a major green energy partnership using the inverted pyramid style',
                'Analyzing a political news broadcast to identify subtle visual framing techniques that bias viewer perception',
                'A spokesperson prepares for a hostile press conference using bridging techniques to return to core messaging',
                'Conducting focus group discussions to evaluate consumer emotional reactions to a proposed brand rebranding logo',
                'A digital content creator faces a cease-and-desist letter regarding fair use of copyrighted music in a non-profit video',
                'Crafting a strategic keynote speech using ethos, pathos, and logos to secure funding from philanthropic donors',
                'Evaluating cross-cultural nonverbal miscues between a Filipino executive and an international business delegation',
                'Designing an interactive multimedia podcast episode covering mental health awareness among university students',
                'An online news outlet publishes an unverified rumor; analyzing criminal and civil liabilities under Philippine libel laws',
                'Drafting a television news bulletin rundown balancing lead breaking stories, human interest, and commercial breaks'
            ],
            'advanced_standards' => [
                'International Communication Association (ICA) and Philippine Association of Communication Educators (PACE) standards',
                'Freedom of Information (FOI) Executive Order No. 2, s. 2016 implementation and public transparency',
                'Kapisanan ng mga Brodkaster ng Pilipinas (KBP) Broadcast Code of the Philippines regulations',
                'Juridical standards for cyber libel under RA 10175 and the Revised Penal Code of the Philippines',
                'Critical cultural studies: Frankfurt School, cultural hegemony (Gramsci), and political economy of media',
                'Digital ethics: data privacy, algorithmic bias, online harassment, and deepfake verification protocols',
                'Integrated Marketing Communications (IMC) strategy and multi-channel attribution analytics',
                'Development Communication (DevCom) frameworks pioneered by the University of the Philippines Los Baños',
                'Intellectual Property Code of the Philippines (Republic Act No. 8293) regarding fair use doctrine',
                'Advanced rhetoric: Toulmin model of argument and rhetorical criticism methodologies',
                'Professional ethics in corporate public relations: transparency, conflict of interest, and anti-spin ethics',
                'Global media governance: UNESCO declarations on cultural diversity and press freedom'
            ]
        ],

        42 => [
            'name' => 'AB Political Science',
            'field' => 'Political Theory, Comparative Politics, International Relations & Governance',
            'terms' => [
                'Separation of Powers & Checks and Balances (1987 Philippine Constitution)',
                'Sovereignty (Internal vs External Sovereignty & Westphalian State System)',
                'Classical Political Philosophy (Plato\'s Republic, Aristotle\'s Politics, Machiavelli\'s Prince)',
                'Social Contract Theories (Hobbes, Locke, Rousseau)', 'Realism vs Liberalism vs Constructivism in IR',
                'Parliamentary vs Presidential Systems of Government', 'Electoral Systems (Proportional Representation vs First-Past-The-Post)',
                'Judicial Review & Justiciable Controversy Requirements', 'Public Policy Cycle (Agenda, Formulation, Adoption, Implementation, Evaluation)',
                'Bureaucracy & Max Weber\'s Rational-Legal Authority', 'Geopolitics & South China Sea Maritime Arbitration (UNCLOS)',
                'Political Economy & Globalization Models', 'Civil Society Organizations & Democratic Participation'
            ],
            'core_principles' => [
                'Analyzing power dynamics, state institutions, and citizen behavior in democratic and authoritarian regimes',
                'Interpreting constitutional law principles, civil liberties, and the tri-branch governmental structure',
                'Evaluating international treaties, diplomatic diplomacy, and global balance-of-power strategies',
                'Assessing the impact of public policies on economic equity, human rights, and social justice',
                'Conducting empirical political research using qualitative comparative analysis and survey polling',
                'Deconstructing ideologies (liberalism, conservatism, socialism, fascism) and contemporary political discourse',
                'Analyzing party systems, campaign finance, patronage politics, and electoral voting behavior in the Philippines',
                'Evaluating sub-national governance, federalism models, and local autonomy under the Local Government Code',
                'Applying international law standards (UN Charter, International Court of Justice, UNCLOS) to territorial disputes',
                'Expreseeing policy recommendations through structured political white papers and legislative bill drafting',
                'Examining how historical colonial institutions shape modern post-colonial political development',
                'Understanding non-state actors: multinational corporations, NGOs, and insurgent groups in global politics',
                'Upholding academic integrity, objectivity, and democratic human rights advocacy'
            ],
            'scenario_types' => [
                'A president issues an executive order that encroaches upon the exclusive lawmaking power of Congress (Check & Balances)',
                'Evaluating the legal and geopolitical implications of the 2016 Permanent Court of Arbitration ruling under UNCLOS',
                'A parliamentary democracy experiences a vote of no confidence; analyzing the constitutional mechanism for government dissolution',
                'Assessing voter behavior in an election where personality and dynastic name recognition outweigh party platform agendas',
                'A civil society coalition petitions the Supreme Court questioning the constitutionality of a newly enacted national security law',
                'Analyzing a foreign policy crisis where a state balances national economic trade interests against regional territorial defense',
                'Evaluating whether a proportional representation electoral system would reduce political party fragmentation in a young democracy',
                'Drafting a legislative policy brief recommending reforms to regulate political dynasties under Article II Section 26',
                'A city mayor asserts local autonomy against a national departmental directive; examining Local Government Code jurisdictions',
                'Analyzing an international crisis through the theoretical lens of Offensive Realism versus Defensive Realism',
                'Assessing the socioeconomic impact of a conditional cash transfer social welfare policy using quantitative evaluation metrics',
                'A constitutional convention debates transitioning from a unitary-presidential to a federal-parliamentary system of government'
            ],
            'advanced_standards' => [
                'The 1987 Constitution of the Republic of the Philippines and constitutional jurisprudence',
                'United Nations Convention on the Law of the Sea (UNCLOS) and maritime boundary delimitation',
                'Universal Declaration of Human Rights (UDHR) and international humanitarian law (Geneva Conventions)',
                'Comparative constitutionalism: executive emergency powers and democratic backsliding indices (V-Dem, Freedom House)',
                'International political economy: Washington Consensus vs Beijing Consensus in global trade financing',
                'Rational Choice Theory and Game Theory (Prisoner\'s Dilemma, Nash Equilibrium) applied to political bargaining',
                'Post-structural political theory (Foucault, Agamben: Biopolitics, State of Exception)',
                'Philippine electoral jurisprudence (Omnibus Election Code and COMELEC regulatory powers)',
                'Sub-national peace governance: the Bangsamoro Organic Law (RA 11054) and transitional justice',
                'Public policy evaluation: Cost-Benefit Analysis and Randomized Controlled Trials (RCTs) in governance',
                'Diplomatic protocol, Vienna Convention on Diplomatic Relations, and state immunity doctrines',
                'Professional ethics of political researchers: non-partisanship in survey design and public integrity'
            ]
        ],

        43 => [
            'name' => 'AB English',
            'field' => 'English Language, Literary Criticism, Linguistics & World Literature',
            'terms' => [
                'Phonetics & Phonology (International Phonetic Alphabet IPA, Place/Manner of Articulation)',
                'Morphology (Morphemes: Free vs Bound, Inflectional vs Derivational Affixes)',
                'Syntax & Phrase Structure Rules (Chomsky\'s Transformational Generative Grammar)',
                'Semantics & Pragmatics (Speech Act Theory, Grice\'s Conversational Maxims)',
                'Major Literary Periods (Renaissance, Romanticism, Victorian, Modernism, Postmodernism)',
                'Literary Critical Theories (Formalism/New Criticism, Marxist, Feminist, Postcolonial, Psychoanalytic)',
                'Figurative Language (Metaphor, Metonymy, Synecdoche, Irony, Conceit)',
                'Narrative Techniques (Stream of Consciousness, Unreliable Narrator, Focalization)',
                'World Literature Masterpieces (Shakespeare, Milton, Austen, Achebe, Marquez)',
                'English for Specific Purposes (ESP) & English for Academic and Professional Purposes (EAPP)',
                'Sociolinguistics (Dialects, Sociolects, World Englishes / Philippine English)',
                'Second Language Acquisition Theories (Krashen\'s Monitor Model, Affective Filter)',
                'Creative Writing Elements (Poetic Meter: Iambic Pentameter, Scansion, Imagery)'
            ],
            'core_principles' => [
                'Analyzing literary texts closely through rigorous formalist, historical, and theoretical critical lenses',
                'Deconstructing language structures across phonological, morphological, syntactic, and semantic domains',
                'Evaluating ideological underpinnings, power structures, and gender representations in canonical literature',
                'Examining how postcolonial literatures write back to imperial centers and reclaim indigenous narratives',
                'Applying Grice\'s maxims (Quantity, Quality, Relation, Manner) to interpret pragmatic conversational implicatures',
                'Distinguishing linguistic competence from linguistic performance in generative grammar paradigms',
                'Composing sophisticated academic research essays, literary analyses, and creative writing manuscripts',
                'Recognizing Philippine English as a legitimate variety within Braj Kachru\'s Outer Circle of World Englishes',
                'Scansion of classical poetry to identify metrical patterns (trochaic, anapestic, dactylic, iambic)',
                'Designing English curricula tailored for professional communication, journalism, and technical industries',
                'Evaluating second language learning strategies and lowering cognitive affective filters in language acquisition',
                'Tracing the historical evolution of the English language from Old English (Beowulf) to Contemporary Global English',
                'Upholding academic honesty, rigorous citation standards (MLA, APA), and intellectual originality'
            ],
            'scenario_types' => [
                'Conducting a morphological analysis on the word "unconditionally" breaking it down into root and affixes',
                'A speaker says "It\'s quite cold in here," implying a request to close the open window (violating conversational maxims for politeness)',
                'Analyzing a postcolonial reading of Joseph Conrad\'s Heart of Darkness using Chinua Achebe\'s critical critique',
                'Identifying phonetic errors when a second-language learner substitutes /p/ for /f/ due to first-language phonemic absence',
                'Scanning a Shakespearean sonnet line to determine whether it strictly conforms to iambic pentameter',
                'A literary critic analyzes the psychological defense mechanisms in Hamlet\'s soliloquies using Freudian psychoanalysis',
                'Drafting a phrase structure tree diagram for a complex sentence containing an embedded relative clause',
                'Evaluating the reliability of a first-person narrator in a modernist short story with evident cognitive biases',
                'Designing an English for Specific Purposes (ESP) curriculum module for call center customer support professionals',
                'Conducting a Marxist literary critique on Charles Dickens\' Great Expectations examining Victorian social class mobility',
                'A linguist investigates acoustic vowel formant differences between standard American English and Philippine English',
                'Evaluating a student essay using MLA 9th edition citation guidelines to ensure proper attribution of secondary sources'
            ],
            'advanced_standards' => [
                'Modern Language Association (MLA) Handbook (9th Edition) scholarly documentation standards',
                'Linguistic Society of the Philippines (LSP) standards and World Englishes research paradigms',
                'Critical Discourse Analysis (Fairclough, Van Dijk) for uncovering political and institutional hegemony in text',
                'Advanced literary theory: Jacques Derrida\'s Deconstruction and Roland Barthes\' "Death of the Author"',
                'Corpus linguistics: computational analysis of large language datasets (COCA, Philippine English Corpus)',
                'Cognitive linguistics: conceptual metaphor theory (Lakoff & Johnson) and frame semantics',
                'Comparative literature methodologies: translation studies and cultural translatability theories',
                'Ecolinguistics and indigenous language documentation in endangered linguistic ecologies',
                'Advanced stylistics: analyzing linguistic deviations, foregrounding, and cognitive poetics',
                'Curriculum development under the Common European Framework of Reference for Languages (CEFR)',
                'Academic ethics in peer reviewing, ghostwriting prohibition, and avoidance of intellectual piracy',
                'Pedagogical grammar instruction: descriptive grammar vs prescriptive grammar in modern classrooms'
            ]
        ],

        44 => [
            'name' => 'BS Social Work',
            'field' => 'Social Work Practice, Case Management, Community Organizing & Welfare',
            'terms' => [
                'Core Social Work Values (Dignity, Social Justice, Integrity, Competence, Service)',
                'Social Case Management Steps (Intake, Assessment, Planning, Intervention, Evaluation, Termination)',
                'Community Organizing Participatory Action Research (COPAR Framework)',
                'Social Work Law of the Philippines (Republic Act No. 4341 & RA 10847)',
                'Human Behavior and the Social Environment (HBSE & Systems Theory: Micro, Mezzo, Macro)',
                'Child Welfare & Protection (RA 7610 Special Protection of Children Against Abuse)',
                'Crisis Intervention Protocols & Psychological First Aid (PFA)',
                'Social Welfare Policies & Programs (Pantawid Pamilyang Pilipino Program 4Ps / RA 11310)',
                'Psychosocial Assessment Tools (Genogram, Ecomap, Culturagram)',
                'Client Self-Determination & Informed Consent Principles',
                'Disaster Risk Reduction and Management (DRRM) & Relief Logistics in Social Work',
                'Violence Against Women and Their Children (VAWC / RA 9262)',
                'NASW & PASWEI Code of Ethics for Social Workers'
            ],
            'core_principles' => [
                'Advocating relentlessly for social justice, human rights, and the empowerment of vulnerable populations',
                'Respecting the fundamental worth, dignity, and inherent right to self-determination of every client',
                'Applying generalist social work practice across individuals, families, small groups, and whole communities',
                'Constructing three-generation genograms and ecomaps to assess family dynamics and external resource systems',
                'Facilitating participatory community organizing that builds self-reliance rather than perpetual dependency',
                'Conducting thorough home visits, psychosocial evaluations, and case study reports for court proceedings',
                'Maintaining absolute client confidentiality except when immediate danger of harm mandates protective disclosure',
                'Managing cases of child sexual abuse, neglect, and exploitation adhering strictly to multidisciplinary protocols',
                'Connecting disadvantaged individuals with government social welfare benefits, legal aid, and emergency shelters',
                'Mobilizing community leaders, conducting social preparation, and organizing local grassroots assemblies',
                'Evaluating program outcomes using participatory monitoring to determine intervention sustainability',
                'Collaborating with local government units, DSWD, and non-government organizations in social development',
                'Adhering to Republic Act No. 4341 as amended and the National Association of Social Workers Code of Ethics'
            ],
            'scenario_types' => [
                'A mother seeking emergency shelter reveals that her spouse physically battered her and threatened her life (RA 9262)',
                'A 10-year-old child working in a sugarcane plantation is identified; initiating rescue and protective custody under RA 7610',
                'A social worker prepares a comprehensive Social Case Study Report (SCSR) for an abandoned infant awaiting adoption',
                'A client in family casework insists on staying with an abusive partner; balancing client self-determination with safety',
                'Facilitating the integration and social preparation phase of COPAR in an indigenous community facing mining displacement',
                'Conducting Psychological First Aid (PFA) for displaced evacuation center residents following a devastating volcanic eruption',
                'A senior citizen with dementia is found wandering the streets; coordinating emergency admission to a welfare facility',
                'Constructing an ecomap to identify weak, stressful, and supportive resource connections for an impoverished rural family',
                'Handling an ethical dilemma where a social worker discovers that a client is subtly misusing cash grants from the 4Ps program',
                'Managing a support group for survivors of human trafficking; fostering emotional safety, mutual trust, and confidentiality',
                'Facilitating a case conference between medical doctors, police investigators, and prosecutors for an abused minor',
                'A community organizer steps back as community leaders independently manage and sustain a communal water cooperative'
            ],
            'advanced_standards' => [
                'Republic Act No. 4341 (The Social Work Law) as amended by Republic Act No. 10847 and PRC Board for Social Workers',
                'Department of Social Welfare and Development (DSWD) Administrative Orders on Case Management Standards',
                'International Federation of Social Workers (IFSW) and IASSW Global Social Work Statement of Ethical Principles',
                'United Nations Convention on the Rights of the Child (UNCRC) and Optional Protocols implementation',
                'Anti-Trafficking in Persons Act of 2003 (Republic Act No. 9208 as amended by RA 10364 and RA 11862)',
                'Trauma-informed care and somatic grounding interventions for severe complex PTSD survivors',
                'Social administration and NGO management: grant writing, financial accountability, and board governance',
                'Gerontological social work and the Expanded Senior Citizens Act of 2010 (RA 9994)',
                'Indigenous Peoples\' Rights Act of 1997 (Republic Act No. 8371) Free, Prior and Informed Consent (FPIC)',
                'Court testimony and expert witness preparation for licensed social workers in family court litigation',
                'Ethics in avoiding dual relationships, financial exploitation of clients, and professional boundary violations',
                'Advocacy for national systemic policy reforms addressing poverty alleviation, housing rights, and universal healthcare'
            ]
        ],

        45 => [
            'name' => 'AB Journalism',
            'field' => 'Journalism, News Writing, Investigative Reporting & Media Law',
            'terms' => [
                'Inverted Pyramid News Structure (Lead, Body, Supporting Details)',
                'The Five Ws and One H in Lead Writing (Who, What, When, Where, Why, How)',
                'Libel Elements under Philippine Criminal Law (RPC Art. 353: Defamation, Malice, Publication, Identifiability)',
                'Ethical Source Verification & Off-the-Record vs On-the-Record Guidelines',
                'Headline Writing Rules, Unit Counts & Active Voice Verb Choice',
                'Copyediting Symbols & AP/Reuters Stylebook Guidelines',
                'Investigative Reporting Methodologies & Document Trail Auditing',
                'Broadcast News Scripting (Split-Page Script, SOT, B-Roll, Voicer, Standup)',
                'Photojournalism Ethics (Digital Manipulation Prohibition, Truthful Captioning)',
                'Freedom of Information (FOI) Requests & Public Records Access',
                'Shield Law (Republic Act No. 53 as amended by RA 1477 & RA 11458 - Sotto Law)',
                'Citizen Journalism vs Professional Verification Standards', 'Philippine Journalists\' Code of Ethics'
            ],
            'core_principles' => [
                'Reporting the truth accurately, independently, and impartially without fear or corporate favor',
                'Crafting concise, compelling news leads that immediately convey the most newsworthy facts',
                'Verifying information with multiple independent sources before publishing breaking stories',
                'Protecting the identity of confidential sources under the legal shield of the Sotto Law',
                'Refraining from publishing unverified allegations that could unfairly destroy reputations',
                'Separating factual, objective news reporting clearly from subjective editorial opinion commentary',
                'Investigating public spending, governmental corruption, and corporate malfeasance through paper trails',
                'Editing news copy meticulously for grammar, accuracy, clarity, brevity, and AP style adherence',
                'Composing truthful, un-doctored photojournalism captions that provide complete context without distortion',
                'Upholding the public\'s constitutional right to know while respecting legitimate individual privacy bounds',
                'Correcting factual reporting errors promptly and transparently across digital and print editions',
                'Resisting bribes, commercial junkets, envelope journalism, and conflicts of interest',
                'Adhering to the National Press Club (NPC) and Philippine Press Institute (PPI) Journalists\' Code of Ethics'
            ],
            'scenario_types' => [
                'A reporter receives leaked municipal budget documents indicating millions in ghost payroll payouts',
                'Writing a 25-word summary lead for a major earthquake disaster detailing magnitude, location, and casualties',
                'A high-profile politician threatens to file criminal libel charges over an investigative article detailing public graft',
                'A law enforcement source speaks strictly "on background"; utilizing the facts while withholding the source\'s name',
                'Writing an active-voice, punchy 3-line headline for a sports championship upset within a 36-unit count constraint',
                'A breaking news story arrives on social media alleging an airline crash; executing verification protocols before publishing',
                'A photojournalist captures an emotional photo at a funeral; deciding whether publishing violates family grief privacy',
                'Copyediting a news article to eliminate redundant words, biased adjectives, and passive sentence structures',
                'A court subpoenas a journalist demanding the identity of a confidential whistleblower who exposed hospital malpractice',
                'Fact-checking claims made by presidential candidates during a live televised debate against official government data',
                'A reporter is offered an expensive smartphone gift from a tech company whose product they are assigned to review',
                'Constructing a multi-part multimedia investigative package incorporating interactive data visualizations and audio clips'
            ],
            'advanced_standards' => [
                'The 1987 Constitution of the Philippines Article III Section 4 (Freedom of Speech and of the Press)',
                'Republic Act No. 53 as amended by Republic Act No. 11458 (The Expanded Sotto Law on Journalist Source Protection)',
                'Philippine Supreme Court jurisprudence on actual malice standard for public officials (New York Times v. Sullivan doctrine)',
                'Cybercrime Prevention Act of 2012 (RA 10175) Section 4(c)(4) regarding online libel provisions and statutes of limitation',
                'Data Journalism tools: cleaning large CSV datasets, web scraping, and statistical regression in news investigations',
                'Mobile journalism (MoJo) workflows: 4K mobile cinematography, external mic audio recording, and live mobile editing',
                'Global Investigative Journalism Network (GIJN) verification toolkits and open-source intelligence (OSINT)',
                'Hostile environment and safety training for war correspondents and journalists covering conflict zones',
                'Ethical guidelines for reporting on suicide, minors in conflict with the law, and sexual assault survivors',
                'Newsroom leadership, editorial board consensus building, and independent ombudsman functions',
                'Media sustainability models: digital subscriptions, non-profit donor grants, and reader-supported newsrooms',
                'International Federation of Journalists (IFJ) Global Charter of Ethics for Journalists'
            ]
        ],

        46 => [
            'name' => 'BS Public Administration',
            'field' => 'Public Administration, Civil Service, Public Fiscal Policy & Governance',
            'terms' => [
                'Max Weber\'s Bureaucratic Theory (Hierarchy, Rules, Impersonality, Merit)',
                'New Public Management (NPM: Efficiency, Market Orientation, Customer Service)',
                'Philippine Local Government Code of 1991 (Republic Act No. 7160 Devolution)',
                'National Budget Cycle (Preparation, Legislation/Authorization, Execution, Accountability)',
                'Civil Service Commission (CSC) Merit System & Appointment Types (Permanent, Temporary, Coterminous)',
                'Code of Conduct and Ethical Standards for Public Officials and Employees (RA 6713)',
                'Public Procurement Reform Act (Republic Act No. 9184 & Bidding Procedures)',
                'Administrative Law & Quasi-Judicial Powers of Government Regulatory Agencies',
                'Anti-Red Tape Act of 2007 (RA 9485 as amended by RA 11032 Ease of Doing Business)',
                'Public Accountability: Commission on Audit (COA) Disallowances & Ombudsman Inquiries',
                'Organizational Development in the Public Sector & E-Governance Systems',
                'Public Fiscal Administration (Taxation, Revenue Generation, Public Debt, Deficits)',
                'Good Governance Principles (Transparency, Rule of Law, Inclusivity, Responsiveness)'
            ],
            'core_principles' => [
                'Upholding the constitutional principle that public office is a public trust (1987 Constitution Article XI)',
                'Executing government functions efficiently, economically, and ethically in service of the Filipino people',
                'Formulating evidence-based public policies addressing socioeconomic inequality, poverty, and development',
                'Managing public revenues, national budget allocations, and public debt with fiscal prudence',
                'Ensuring competitive, transparent public bidding and procurement under RA 9184 to prevent graft',
                'Complying with Civil Service rules on merit, fitness, performance appraisal, and security of tenure',
                'Implementing the devolution of health, agriculture, and social welfare services to local government units',
                'Eliminating bureaucratic red tape, streamlining citizen transactions, and meeting statutory service turnaround times',
                'Auditing government expenditures according to COA circulars to prevent irregular, unnecessary, or unconscionable spending',
                'Upholding the 8 norms of conduct under RA 6713: commitment to public interest, professionalism, justness, simplicity',
                'Engaging citizens and civil society organizations in participatory budgeting and community monitoring',
                'Transforming traditional government workflows into transparent, citizen-friendly e-governance platforms',
                'Promoting public sector accountability through the Office of the Ombudsman and the Sandiganbayan'
            ],
            'scenario_types' => [
                'A government agency procures $100,000 worth of computers without public bidding; assessing violations under RA 9184',
                'A citizen reports that a municipal licensing office takes 45 days to renew a simple business permit (RA 11032 violation)',
                'The Commission on Audit (COA) issues a Notice of Disallowance for unauthorized cash allowances paid to board members',
                'Drafting an Annual Investment Program (AIP) for a 1st-class municipality aligned with its Comprehensive Development Plan',
                'A newly appointed mayor terminates all career permanent civil service employees to hire political campaign loyalists',
                'Evaluating local revenue performance: calculating local tax collections versus national Internal Revenue Allotment (NTA)',
                'A government official is caught accepting an all-expenses-paid foreign holiday from a bidding contractor (RA 6713)',
                'Managing the budget execution phase: issuing Special Allotment Release Orders (SARO) and Notices of Cash Allocation (NCA)',
                'Designing a Citizen\'s Charter displaying standard processing steps, required fees, and maximum response times',
                'An administrative disciplinary charge is filed against a civil service officer for grave misconduct and dishonesty',
                'Transitioning a regional government agency\'s manual paper records to an integrated digital cloud citizen portal',
                'Resolving a boundary and tax revenue jurisdictional dispute between two neighboring local government units under RA 7160'
            ],
            'advanced_standards' => [
                'The 1987 Constitution of the Republic of the Philippines Article XI (Accountability of Public Officers)',
                'Republic Act No. 6713 (Code of Conduct and Ethical Standards for Public Officials and Employees)',
                'Republic Act No. 7160 (The Local Government Code of 1991) and the Mandanas-Garcia Supreme Court Ruling implementation',
                'Republic Act No. 9184 (Government Procurement Reform Act) and its 2016 Revised Implementing Rules and Regulations',
                'Republic Act No. 11032 (Ease of Doing Business and Efficient Government Service Delivery Act of 2018)',
                'Commission on Audit (COA) Circular No. 2012-003 on Prevention of Irregular, Unnecessary, Excessive, Extravagant and Unconscionable (IUEEU) Expenditures',
                'Civil Service Commission (CSC) Omnibus Rules on Appointments and Other Human Resource Actions (ORAOHRA)',
                'United Nations Sustainable Development Goal 16 (Peace, Justice and Strong Institutions)',
                'Anti-Graft and Corrupt Practices Act (Republic Act No. 3019) definitions of criminal corrupt acts',
                'Public fiscal management: Medium-Term Fiscal Framework (MTFF) and macroeconomic deficit forecasting',
                'Strategic Performance Management System (SPMS) aligning individual employee targets with organizational vision',
                'Professional ethics of public managers: political neutrality, financial disclosure (SALN), and selfless public service'
            ]
        ],

        47 => [
            'name' => 'Bachelor of Multimedia Arts',
            'field' => 'Multimedia Arts, Graphic Design, Motion Graphics & UI/UX',
            'terms' => [
                'Principles of Design (Balance, Contrast, Hierarchy, Alignment, Proximity, Repetition)',
                'Color Theory & Color Spaces (Additive RGB for Screens vs Subtractive CMYK for Print)',
                'Vector Graphics (SVG, Bézier Curves) vs Raster Bitmaps (JPEG, PNG, Pixels, DPI)',
                'Typography Anatomy (Serif, Sans-serif, Kerning, Tracking, Leading, Hierarchy)',
                'Twelve Principles of Animation (Squash & Stretch, Anticipation, Staging, Timing)',
                'Motion Graphics & Compositing (Keyframing, Easing Curves, Rotoscoping, Alpha Channels)',
                'Audio Engineering Basics (Sampling Rate 48kHz, Bit Depth 24-bit, Decibels, Normalization)',
                'UI/UX Design Frameworks (Wireframing, High-Fidelity Prototyping, Usability Testing)',
                'Digital Video Editing & Non-Linear Timelines (Codecs: H.264, ProRes, Frame Rates: 24p, 60p)',
                '3D Modeling & Texturing (Polygonal Meshes, UV Unwrapping, PBR Materials)',
                'Interactive Storyboarding & Concept Art Visual Development',
                'Intellectual Property Code of the Philippines (RA 8293 & Copyright in Creative Works)'
            ],
            'core_principles' => [
                'Synthesizing visual storytelling, graphic communication, and interactive digital technologies',
                'Establishing strong visual hierarchy that guides viewer gaze naturally through composition',
                'Designing responsive digital user interfaces optimized for intuitive human interaction and accessibility',
                'Applying the 12 principles of animation to breathe realistic weight, momentum, and personality into motion',
                'Calibrating color profiles and resolution (300 DPI for print, 72/144 DPI for screen) across display media',
                'Crafting modular branding identities: logos, style guides, typography systems, and iconography',
                'Editing dynamic video narratives utilizing match cuts, J/L audio cuts, and cinematic color grading',
                'Sculpting 3D assets, unwrapping UV coordinates cleanly, and applying physically-based rendering textures',
                'Recording, cleaning, and mixing audio soundtracks ensuring balanced dialogue, Foley, and ambient music',
                'Developing interactive multimedia experiences for web, mobile apps, and experiential digital installations',
                'Executing collaborative production pipelines using standard digital asset management tools',
                'Conducting user testing to diagnose design friction, low usability, and confusing interface patterns',
                'Upholding creative ethics: respecting copyright, avoiding plagiarism, and crediting collaborator contributions'
            ],
            'scenario_types' => [
                'A printed magazine cover displays muddy, inaccurate colors because the artwork was exported in RGB instead of CMYK',
                'A mobile banking app user interface confuses elderly users; redesigning button contrast and text hierarchy',
                'A 2D character run animation looks robotic and stiff; applying anticipation, follow-through, and squash and stretch',
                'A client\'s vector logo pixelates and becomes blurry when scaled to a massive 20-meter billboard banner (identifying file rasterization)',
                'Editing a 30-second commercial video where background music completely drowns out dialogue; ducking audio by -12 dB',
                'A 3D character model exhibits severe texture stretching over the shoulders due to improper UV seam unwrapping',
                'Designing an interactive web wireframe in Figma with clickable micro-interactions for a usability testing sprint',
                'A motion graphics title animation starts and stops jarringly; converting linear keyframes into smooth bezier ease-in/ease-out curves',
                'A digital artist receives a DMCA copyright takedown notice for using an uncredited commercial stock photograph in client work',
                'Selecting an appropriate sans-serif font pairing that ensures readability at small 12px sizes on smartphone displays',
                'Balancing a movie poster composition using the Rule of Thirds and complementary color grading (teal and orange)',
                'Exporting a 4K motion graphic project with an alpha transparency channel using the Apple ProRes 4444 codec'
            ],
            'advanced_standards' => [
                'Intellectual Property Code of the Philippines (Republic Act No. 8293) and Creative Commons Licensing frameworks',
                'Web Content Accessibility Guidelines (WCAG 2.1 Level AA) for color contrast and screen reader accessibility',
                'Physically Based Rendering (PBR) metalness-roughness workflow standards for real-time 3D rendering',
                'International Color Consortium (ICC) color management profiles across print, web, and cinema display monitors',
                'Advanced digital compositing: 3D camera tracking, multipass EXR compositing, and green screen despill techniques',
                'Human-Centered Design (HCD) methodology by IDEO and Norman Group UX design heuristics',
                'Digital video broadcast standards (EBU R128 loudness normalization and Rec. 709 / Rec. 2020 color gamuts)',
                'Creative industry business practices: client contracts, statement of work (SOW), and intellectual property buyout clauses',
                'Virtual production workflows: real-time in-camera visual effects (ICVFX) using LED volume walls and Unreal Engine',
                'Generative AI ethics: machine learning training data copyright, artist attribution, and creative authenticity',
                'Design thinking facilitation for corporate brand transformation and digital product innovation',
                'Professional code of ethics for graphic designers and multimedia artists (AIGA Standards of Professional Practice)'
            ]
        ],

        48 => [
            'name' => 'BS Biology',
            'field' => 'Biological Sciences, Cell Biology, Genetics, Ecology & Physiology',
            'terms' => [
                'Central Dogma of Molecular Biology (DNA Replication, Transcription, Translation)',
                'Mendelian Genetics & Punnett Square Ratios (Monohybrid 3:1, Dihybrid 9:3:3:1)',
                'Cell Division Mechanics (Mitosis Stages vs Meiosis Genetic Recombination)',
                'Cellular Respiration Pathways (Glycolysis, Krebs Cycle, Oxidative Phosphorylation, ATP Yield)',
                'Plant Photosynthesis (Light-Dependent Reactions & Calvin Cycle CO2 Fixation)',
                'Biological Taxonomy Hierarchy (Domain, Kingdom, Phylum, Class, Order, Family, Genus, Species)',
                'Ecological Trophic Levels & 10% Energy Transfer Law',
                'Evolutionary Mechanisms (Natural Selection, Genetic Drift, Gene Flow, Mutation)',
                'Enzyme Kinetics (Lock-and-Key vs Induced Fit, Michaelis-Menten Kinetics)',
                'Microbial Classification (Gram Stain, Prokaryotic vs Eukaryotic Cell Structure)',
                'Ecosystem Dynamics (Biogeochemical Cycles: Carbon, Nitrogen, Phosphorus)',
                'Human Organ System Homeostasis & Negative Feedback Loops',
                'Philippine Wildlife Resources Conservation and Protection Act (RA 9147)'
            ],
            'core_principles' => [
                'Investigating biological phenomena using rigorous hypothesis testing, controls, and biostatistical analysis',
                'Tracing the molecular flow of genetic information from nucleotide sequences to functional proteins',
                'Calculating genetic phenotypic and genotypic inheritance probabilities using Mendelian and non-Mendelian models',
                'Analyzing metabolic bioenergetics, ATP production, electron transport chains, and chemiosmosis',
                'Evaluating population genetics and allele frequency equilibria using the Hardy-Weinberg equation (p^2 + 2pq + q^2 = 1)',
                'Classifying living organisms according to phylogenetic relationships, synapomorphies, and cladograms',
                'Measuring ecological species diversity, richness, and evenness using Shannon-Wiener and Simpson indices',
                'Describing physiological regulatory mechanisms that maintain internal homeostasis in animals and plants',
                'Operating laboratory compound microscopes, spectrophotometers, and gel electrophoresis systems safely',
                'Understanding microbial pathogenesis, antibiotic sensitivity testing, and aseptic culture techniques',
                'Preserving endangered biodiversity and ecosystems under Philippine environmental conservation frameworks',
                'Analyzing evolutionary adaptations resulting from ecological niche pressures and reproductive isolation',
                'Upholding bioethics in scientific research, animal experimentation, and human genetic testing'
            ],
            'scenario_types' => [
                'Crossing two heterozygous tall pea plants (Tt x Tt); calculating the probability of obtaining a dwarf offspring (25%)',
                'A cell with 46 chromosomes undergoes meiosis; determining chromosome number in each resulting gamete daughter cell (23)',
                'A plant leaf exposed to light without carbon dioxide stops sugar production; identifying the inhibited Calvin Cycle stage',
                'In an isolated population of 1,000 frogs, 40 are homozygous recessive brown (q^2 = 0.04); calculating allele frequencies',
                'Analyzing a DNA gel electrophoresis where smaller DNA fragments migrate farther toward the positive anode than larger fragments',
                'A competitive enzyme inhibitor is added to an enzymatic reaction; analyzing the increase in Km while Vmax remains unchanged',
                'A marine biologist identifies a sudden algal bloom and fish kill; measuring dissolved oxygen and identifying cultural eutrophication',
                'Differentiating an unknown microorganism: observing circular non-membrane bound nucleoid DNA confirming a prokaryote bacterium',
                'Investigating an invasive plant species that outcompetes native flora; analyzing its high reproductive output and lack of natural herbivores',
                'A human subjected to cold weather shivers and exhibits peripheral vasoconstriction; illustrating a negative feedback loop',
                'Designing a controlled field experiment testing the effect of nitrogen fertilizer concentrations on tomato growth heights',
                'Analyzing a phylogenetic cladogram to identify the most recent common ancestor between reptiles and avian dinosaurs'
            ],
            'advanced_standards' => [
                'Republic Act No. 9147 (Wildlife Resources Conservation and Protection Act of the Philippines)',
                'National Biosafety Framework of the Philippines and Institutional Biosafety Committee (IBC) guidelines',
                'Convention on Biological Diversity (CBD) and Nagoya Protocol on Access and Benefit-Sharing',
                'Animal Welfare Act of the Philippines (Republic Act No. 8485 as amended by RA 10631) research standards',
                'Advanced molecular biology: CRISPR-Cas9 gene editing mechanisms and ethical limitations',
                'Recombinant DNA technology, plasmid cloning vectors, and Western Blot protein verification',
                'Population viability analysis (PVA) and IUCN Red List Categories for threatened species conservation',
                'Bioinformatics tools: NCBI BLAST nucleotide alignment, GenBank querying, and protein structural modeling (PyMOL)',
                'Epigenetics: DNA methylation, histone acetylation, and non-coding RNA gene regulation',
                'Climate change impacts on marine ecosystems: ocean acidification and coral reef symbiotic zooxanthellae expulsion',
                'Bioethics declarations: Nuremberg Code and Declaration of Helsinki in biological biomedical research',
                'Professional standards of the Biology Teachers Association of the Philippines (BIOTA) and international scientific journals'
            ]
        ],

        49 => [
            'name' => 'BS Agriculture',
            'field' => 'Agronomy, Soil Science, Animal Science, Horticulture & Crop Protection',
            'terms' => [
                'Soil Texture Triangle (Sand, Silt, Clay Percentages) & Optimal Soil pH (6.0 - 6.8)',
                'Plant Essential Macronutrients (Primary: N, P, K; Secondary: Ca, Mg, S)',
                'Integrated Pest Management (IPM: Cultural, Biological, Mechanical, Chemical Controls)',
                'Crop Rotation, Cover Cropping & Green Manuring for Soil Health',
                'Ruminant Digestive Anatomy (Rumen, Reticulum, Omasum, Abomasum)',
                'Seed Germination Factors (Moisture, Oxygen, Temperature, Viability Testing)',
                'Agricultural Irrigation Efficiency (Drip vs Sprinkler vs Furrow Systems)',
                'Plant Propagation Techniques (Grafting, Budding, Layering, Tissue Culture)',
                'Livestock Breeding & Artificial Insemination (AI Protocols)',
                'Post-Harvest Handling & Cold Chain Management to Prevent Spoilage',
                'Organic Agriculture Act of 2010 (Republic Act No. 10068 as amended by RA 11511)',
                'Agricultural Economics (Farm Budgeting, Gross Margin Analysis, Farm Gate Prices)',
                'Agriculture and Fisheries Modernization Act of 1997 (AFMA / RA 8435)'
            ],
            'core_principles' => [
                'Maximizing sustainable agricultural crop yield while preserving long-term soil fertility and ecosystem health',
                'Analyzing soil nutrient deficiency symptoms (e.g., nitrogen chlorosis in older leaves, phosphorus purpling)',
                'Formulating balanced fertilizer recommendations based on comprehensive soil chemical test results',
                'Implementing Integrated Pest Management to maintain pest populations below economic injury levels (EIL)',
                'Managing ruminant nutrition, volatile fatty acid fermentation, and balanced feed rations for dairy and beef',
                'Designing water-efficient drip irrigation schedules matched to crop evapotranspiration rates (ETc)',
                'Executing precision plant propagation (cleft grafting, T-budding) to clone superior fruit tree cultivars',
                'Monitoring swine and poultry housing ventilation, biosecurity, and feed conversion ratios (FCR)',
                'Reducing post-harvest crop losses through proper harvest timing, curing, sorting, and temperature control',
                'Conducting farm business accounting, calculating cost of production per kilogram, and marketing channels',
                'Promoting organic farming, composting, and vermiculture to reduce synthetic chemical inputs',
                'Adapting agricultural cropping calendars to climate change resilience, droughts, and monsoon patterns',
                'Adhering to Republic Act No. 8435 and the Code of Ethics for Registered Agriculturists in the Philippines'
            ],
            'scenario_types' => [
                'Corn plants exhibit yellowing (chlorosis) starting at the tips of older lower leaves; diagnosing severe nitrogen deficiency',
                'Calculating the amount of Urea (46-0-0) needed to apply 92 kg of pure nitrogen per hectare (200 kg Urea)',
                'An agricultural field has an armyworm infestation; calculating the economic threshold before deciding on chemical pesticide spraying',
                'A farmer has heavy clay soil with poor internal drainage; recommending organic matter incorporation and raised planting beds',
                'A broiler poultry flock displays a feed conversion ratio (FCR) of 2.2 against a 1.6 industry benchmark; investigating feed quality and disease',
                'Propagating high-value mango cultivars onto native rootstocks using cleft grafting to ensure clonal fidelity and early bearing',
                'A vegetable farmer loses 40% of fresh tomatoes to post-harvest decay; introducing field shade, rigid plastic crates, and pre-cooling',
                'Formulating a total mixed ration (TMR) for a dairy cow balancing crude protein (16%) and total digestible nutrients (TDN)',
                'A soil test shows a strongly acidic pH of 4.5; calculating agricultural lime (CaCO3) application to raise pH to 6.2',
                'Selecting a drip irrigation system over furrow flooding to cultivate high-value bell peppers in a water-scarce upland area',
                'Conducting a seed germination test where 85 out of 100 seeds germinate; calculating 85% seed viability percentage',
                'Designing a farm biosecurity protocol to protect a commercial piggery against African Swine Fever (ASF) entry'
            ],
            'advanced_standards' => [
                'Republic Act No. 8435 (Agriculture and Fisheries Modernization Act) and Professional Regulatory Board of Agriculture',
                'Philippine National Standards (PNS) for Organic Agriculture and Good Agricultural Practices (PhilGAP) certification',
                'Bureau of Plant Industry (BPI) and Bureau of Animal Industry (BAI) sanitary and phytosanitary (SPS) quarantine standards',
                'Fertilizer and Pesticide Authority (FPA) regulations on agrochemical licensing, maximum residue limits (MRL)',
                'Precision agriculture: drone multispectral imaging, satellite NDVI monitoring, and variable-rate nutrient application',
                'Agricultural biotechnology: genetically modified crops (Bt Corn, Golden Rice) and biosafety regulatory clearance',
                'Soil carbon sequestration and regenerative agriculture practices for climate change mitigation',
                'Food safety compliance under the Food Safety Act of 2013 (RA 10611) across the farm-to-fork continuum',
                'Agricultural value chain analysis and farm cooperative enterprise financial management',
                'Crop insurance mechanisms under the Philippine Crop Insurance Corporation (PCIC)',
                'Ethics in agrochemical usage, protection of agricultural farmworkers, and environmental non-contamination',
                'Global food security frameworks by the Food and Agriculture Organization (FAO) of the United Nations'
            ]
        ],

        50 => [
            'name' => 'BS Fisheries',
            'field' => 'Fisheries Science, Aquaculture, Aquatic Ecology & Post-Harvest Technology',
            'terms' => [
                'Aquaculture Water Quality Critical Parameters (Dissolved Oxygen DO > 5 ppm, pH 6.5-8.5, Ammonia < 0.05 ppm)',
                'Fish External & Internal Anatomy (Gills, Lateral Line, Swim Bladder, Operculum)',
                'Aquaculture Culture Systems (Earthen Ponds, Floating Cages, Recirculating Aquaculture Systems RAS)',
                'The Philippine Fisheries Code of 1998 (Republic Act No. 8550 as amended by RA 10654)',
                'Major Philippine Commercial Aquaculture Species (Milkfish/Bangus, Tilapia, Tiger Prawn, Seaweeds)',
                'Capture Fisheries Gear Technology (Trawls, Purse Seines, Gillnets, Longlines, Fish Traps)',
                'Post-Harvest Fish Processing (Smoking, Salting, Drying, Freezing, Value-Added Canning)',
                'Limnology (Freshwater Lake Ecology) & Oceanography (Marine Ocean Currents, Upwelling)',
                'Fish Nutrition & Feed Formulation (Crude Protein Requirements, Sinking vs Floating Pellets)',
                'Fish Pathology & Health Management (Bacterial Vibriosis, White Spot Syndrome Virus WSSV)',
                'Marine Protected Areas (MPAs) & Fisheries Carrying Capacity',
                'Maximum Sustainable Yield (MSY) & Overfishing Indicators',
                'Code of Ethics for Fisheries Professionals in the Philippines'
            ],
            'core_principles' => [
                'Managing sustainable aquatic food production through scientifically sound aquaculture husbandry',
                'Monitoring and maintaining optimal water quality parameters (DO, salinity, temperature, toxic ammonia)',
                'Formulating balanced artificial fish diets satisfying essential amino acid and fatty acid nutritional needs',
                'Preventing and diagnosing infectious aquatic diseases in commercial fish and shrimp hatcheries',
                'Applying fisheries management tools to prevent overexploitation of wild capture fisheries stocks',
                'Enforcing regulatory bans against illegal, unreported, and unregulated (IUU) fishing practices',
                'Executing hygienic post-harvest fish processing to preserve freshness and eliminate histamine contamination',
                'Designing land-based recirculating aquaculture systems (RAS) with biological nitrification filters',
                'Establishing and monitoring no-take Marine Protected Areas (MPAs) to allow reef fish stock spillover',
                'Calculating feed conversion ratios (FCR), specific growth rates (SGR), and fish stocking densities',
                'Conserving critical aquatic habitats: mangrove forests, seagrass beds, and coral reef ecosystems',
                'Operating fishing vessels and selective gears that minimize incidental non-target species bycatch',
                'Adhering to Republic Act No. 8550 as amended and the Code of Ethics for Registered Fisheries Technologists'
            ],
            'scenario_types' => [
                'A milkfish earthen pond exhibits fish gasping at the water surface at 5:00 AM; identifying critical dissolved oxygen depletion',
                'A shrimp farm experiences sudden mass mortality; shrimp display white calcified spots on the carapace (WSSV diagnosis)',
                'Calculating Feed Conversion Ratio (FCR) for a pond fed 1,200 kg of feed that produced 800 kg of harvested tilapia (1.5 FCR)',
                'A commercial fishing boat is caught operating an active trawl within 15 km of municipal waters (violating RA 8550)',
                'Total ammonia nitrogen (TAN) in a recirculating catfish tank reaches 4.0 ppm; diagnosing biofilter bacterial failure',
                'Fresh tuna left in ambient heat develops high levels of scombroid histamine toxicity; enforcing immediate onboard icing',
                'Estimating stock biomass in a marine fishery: the catch per unit effort (CPUE) drops 70% over 5 years indicating overfishing',
                'A tilapia hatchery operates an artificial incubation system; maintaining water temperature at 28°C for optimal egg hatching',
                'Measuring seawater salinity in an estuarine oyster farm using a handheld optical refractometer (25 ppt reading)',
                'Designing a selective gillnet mesh size that allows juvenile target fish to escape while capturing mature adults',
                'Treating an external parasitic Trichodina infestation in a freshwater nursery tank using an approved formalin bath',
                'Evaluating a community Marine Protected Area where fish biomass inside the reserve has doubled over a 3-year baseline'
            ],
            'advanced_standards' => [
                'Republic Act No. 8550 as amended by Republic Act No. 10654 (An Act to Prevent, Deter and Eliminate IUU Fishing)',
                'Bureau of Fisheries and Aquatic Resources (BFAR) Fisheries Administrative Orders (FAOs) and regulations',
                'FAO Code of Conduct for Responsible Fisheries and International Plan of Action for Seabirds and Sharks',
                'Marine Stewardship Council (MSC) standards for sustainable wild-capture fisheries certification',
                'GlobalGAP and Best Aquaculture Practices (BAP) standards for commercial shrimp and finfish operations',
                'Fish stock assessment mathematical models (Beverton-Holt, Surplus Production Schaefer Model)',
                'Aquatic biosecurity and OIE (World Organisation for Animal Health) aquatic animal health diagnostic standards',
                'Oceanographic remote sensing: sea surface temperature (SST) and chlorophyll satellite data in locating fishing grounds',
                'Ecosystem Approach to Fisheries Management (EAFM) integration in municipal fishery management councils (FARMC)',
                'Heavy metal and microplastic bioaccumulation testing in commercial seafood species (Atomic Absorption Spectrometry)',
                'Professional ethics of Fisheries Professionals: environmental stewardship and combating destructive blast/cyanide fishing',
                'Convention on International Trade in Endangered Species of Wild Fauna and Flora (CITES) aquatic species compliance'
            ]
        ]
    ];

    // Helper to generate full 50 questions for each profile
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

    return $out;
}
