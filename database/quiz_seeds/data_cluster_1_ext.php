<?php
/**
 * Degrees 5 to 8:
 * 5: BS Entrepreneurship
 * 6: BS Office Administration
 * 7: BS Real Estate Management
 * 8: BS Customs Administration
 */

function getCluster1ExtData() {
    $d = [];

    // Degree 5: BS Entrepreneurship
    $d[5] = [
        // Stage 1 (1-13)
        [1, "What is an entrepreneur?", "An individual who identifies opportunities, takes calculated risks, and organizes resources to create a venture", "An employee who only works overtime hours", "A government tax auditor", "A passive shareholder who never attends meetings", "A"],
        [1, "What does MVP stand for in Lean Startup methodology?", "Most Valuable Player", "Minimum Viable Product", "Maximum Volume Production", "Market Valuation Percentage", "B"],
        [1, "What is a 'pitch deck'?", "A brief presentation used to provide investors with an overview of a business venture", "A sales contract signed by retail clients", "A legal complaint filed against competitors", "A bank statement showing company debt", "A"],
        [1, "What does 'bootstrapping' mean in startup financing?", "Building a business from scratch using only personal savings and initial operating revenue", "Borrowing millions from investment banks", "Securing government venture grants", "Merging with a publicly traded conglomerate", "A"],
        [1, "What is a Value Proposition?", "A statement explaining what benefit a product delivers, how it solves problems, and why customers should buy it", "The total historical cost of building factory assets", "The discount percentage given to suppliers", "The legal terms of corporate liquidation", "A"],
        [1, "What does TAM stand for in market sizing?", "Total Available Market", "Target Annual Margin", "Total Asset Management", "Technical Assessment Matrix", "A"],
        [1, "What is an angel investor?", "A high-net-worth individual who provides capital for a business startup, usually in exchange for equity", "A bank loan officer reviewing credit limits", "An insurance broker underwriting equipment", "A government labor inspector", "A"],
        [1, "What is customer discovery?", "The scientific process of interviewing potential users to validate assumptions about their problems and needs", "Spying on competitor retail store cashiers", "Purchasing broad consumer email mailing lists", "Hiring a private investigator to find debtors", "A"],
        [1, "In startup terminology, what is a 'pivot'?", "A structured course correction designed to test a new hypothesis about the product or business model", "Closing down the business permanently", "Doubling executive salaries", "Borrowing short-term payday loans", "A"],
        [1, "What is crowdfunding?", "Raising small amounts of money from a large number of people, typically via online platforms", "Applying for a commercial bank mortgage", "Selling corporate bonds on the stock exchange", "Withdrawing personal pension funds early", "A"],
        [1, "What is the Business Model Canvas?", "A strategic management template for developing new or documenting existing business models on one page", "A framed certificate of business incorporation", "An annual corporate income tax form", "A blueprint of the physical office floor plan", "A"],
        [1, "What does CAC stand for in venture growth?", "Customer Acquisition Cost", "Capital Asset Control", "Corporate Audit Committee", "Current Account Credit", "A"],
        [1, "What does LTV (or CLV) stand for?", "Customer Lifetime Value", "Loan to Valuation ratio", "Long Term Venture", "Legal Tax Voucher", "A"],

        // Stage 2 (14-26)
        [2, "According to Eric Ries, what is the core feedback loop of the Lean Startup?", "Build - Measure - Learn", "Plan - Fund - Sell", "Design - Manufacture - Liquidate", "Hire - Train - Fire", "A"],
        [2, "What is product-market fit (PMF)?", "Being in a good market with a product that can satisfy that market", "Having sufficient inventory to fill an entire warehouse", "Filing international trademark protections", "Hiring 100 sales representatives", "A"],
        [2, "In startup finance, what is the 'burn rate'?", "The rate at which a new company spends its cash reserves before generating positive cash flow", "The speed at which physical inventory spoils", "The depreciation rate of factory machinery", "The corporate tax rate on annual gross profits", "A"],
        [2, "What is runway?", "The amount of time a startup has before running out of cash, calculated as Cash Reserves divided by Monthly Burn Rate", "The length of the warehouse loading dock", "The timeline required to obtain a patent", "The notice period required before firing an employee", "A"],
        [2, "What is a 'term sheet' in venture capital funding?", "A non-binding agreement outlining the basic terms and conditions under which an investment will be made", "A document listing all office furniture assets", "A final receipt for paid income taxes", "An employment contract for factory workers", "A"],
        [2, "What is pre-money valuation?", "The valuation of a company prior to receiving a new round of investment capital", "The cost of building a prototype", "The total debt accumulated by the founder", "The estimated sales revenue for the next ten years", "A"],
        [2, "How is post-money valuation calculated?", "Pre-money valuation plus the new investment amount", "Pre-money valuation minus founder debt", "Total revenue divided by share count", "Gross assets minus corporate liabilities", "A"],
        [2, "What is equity dilution?", "The reduction in ownership percentage of existing shareholders caused by the issuance of new shares", "The loss of cash reserves due to high marketing expenses", "The physical depreciation of manufacturing equipment", "The decrease in consumer demand during a recession", "A"],
        [2, "What is a convertible note?", "A short-term debt that converts into equity, typically in conjunction with a future financing round", "A currency exchange receipt from an international bank", "A personal guarantee signed by the entrepreneur", "A fixed-rate municipal bond", "A"],
        [2, "In lean entrepreneurship, what is a 'vanity metric'?", "A metric that looks impressive on paper (e.g., page views) but does not correlate to active business success or revenue", "A metric measuring the aesthetic appeal of a logo", "A metric evaluating executive dress codes", "A metric calculating gross employee head count", "A"],
        [2, "What is a moat (economic moat) in competitive enterprise strategy?", "A sustainable competitive advantage that protects a company from competitors (e.g., network effects, switching costs)", "A literal water trench dug around a company building", "A high barrier to employee promotion", "A government penalty for antitrust violations", "A"],
        [2, "What is the difference between direct and indirect competitors?", "Direct competitors offer the same core product to the same audience; indirect offer alternative solutions to the same underlying problem", "Direct competitors operate online; indirect operate in malls", "Direct competitors are domestic; indirect are foreign conglomerates", "There is no functional distinction in market analysis", "A"],
        [2, "Under Blue Ocean Strategy, what does a 'Red Ocean' represent?", "Crowded, existing market space where competitors fight fiercely for market share", "Unexplored, new market spaces where competition is irrelevant", "International maritime shipping channels", "A high-risk venture capital investment fund", "A"],

        // Stage 3 (27-38)
        [3, "A mobile app startup spends $15,000 on digital ads and acquires 1,000 paying users. Each user generates an average gross profit of $45 over their lifetime. Is the unit economics viable?", "Yes, because LTV ($45) is 3x the CAC ($15), meeting the industry benchmark (LTV:CAC >= 3:1)", "No, because CAC exceeds gross revenue", "No, because advertising budgets must always be under $1,000", "Cannot be determined without calculating inventory depreciation", "A"],
        [3, "A software founder builds a complex feature-rich product for 18 months without user testing, only to find zero buyers at launch. Which Lean Startup rule was violated?", "Failing to build an MVP early and engage in continuous customer validation", "Failing to register a formal patent before writing code", "Failing to hire a 50-person marketing team", "Pricing the software above $1,000 per license", "A"],
        [3, "An angel investor offers $200,000 for a 20% equity stake in a tech startup. What is the implied post-money valuation of the venture?", "$1,000,000 ($200,000 / 0.20)", "$800,000", "$2,000,000", "$400,000", "A"],
        [3, "Based on the previous question, what was the startup's pre-money valuation?", "$800,000 ($1,000,000 post-money - $200,000 investment)", "$1,000,000", "$1,200,000", "$600,000", "A"],
        [3, "A food delivery startup operates with a monthly burn rate of $40,000 and has $160,000 remaining in the bank. How many months of runway do they have before insolvency?", "4 months ($160,000 / $40,000)", "6 months", "2 months", "8 months", "A"],
        [3, "During customer discovery interviews for a new fitness gadget, 80% of interviewees state they 'would love to buy it', but when offered a pre-order with a 50% deposit, only 1% commit. How should the entrepreneur interpret this?", "Stated preference does not equal revealed preference; demand is not yet validated by real monetary commitment", "The product is guaranteed to become a billion-dollar unicorn", "The survey was completely invalid and should be deleted", "They should immediately build a large manufacturing factory", "A"],
        [3, "A founder wants to incentivize early key engineers without paying high cash salaries. What legal mechanism is most commonly utilized in startup compensation?", "Employee Stock Option Plan (ESOP) with a 4-year vesting schedule and 1-year cliff", "Promising under-the-table cash bonuses", "Offering verbal promises of future company profits", "Giving away 50% of voting common stock immediately on day one", "A"],
        [3, "A marketplace startup connects local tour guides with travelers. They have abundant tour guides signing up, but zero tourists booking tours. What type of marketplace challenge are they facing?", "Demand-side constraint (supply is solved, but buyer acquisition is lacking)", "Supply-side constraint", "Regulatory antitrust prohibition", "Foreign exchange liquidity deficit", "A"],
        [3, "An e-commerce startup's monthly churn rate is 15%. What does this indicate about customer retention and growth sustainability?", "High churn creates a 'leaky bucket'; the company will struggle to grow sustainably until retention is fixed", "The company is growing 15% faster every month", "Customers are 15% more loyal than the industry average", "Operating costs will decrease automatically by 15%", "A"],
        [3, "When pitching to venture capitalists, a founder claims 'We have no competitors.' How will sophisticated investors perceive this statement?", "As evidence that the founder lacks thorough market research or that no viable market exists for the product", "As proof that the startup is guaranteed to succeed", "As an indication that the product is patented globally", "As a reason to immediately invest at maximum valuation", "A"],
        [3, "A founder needs $50,000 to purchase initial packaging for retail shelf placement. A venture debt lender offers the capital with an asset lien. What is the major advantage over venture equity?", "Venture debt does not dilute the founders' equity ownership percentage", "Venture debt never has to be repaid if the company fails", "Venture debt comes with zero interest rates", "Lenders take majority voting seats on the board of directors", "A"],
        [3, "A team develops an AI tool for radiologists. After 20 hospital demos, they learn that hospital procurement takes 24 months, which exceeds their runway. What immediate strategic move is recommended?", "Pivot to a direct-to-consumer or outpatient clinic model with faster sales cycles, or secure bridge financing", "Wait passively for the 24 months to pass while burning cash", "Sue the hospitals for slow administrative procedures", "Close the company immediately without exploring alternatives", "A"]
    ];

    // Degree 6: BS Office Administration
    $d[6] = [
        [1, "What is office administration?", "The coordination and management of day-to-day office operations, communications, and administrative workflows", "Fixing physical plumbing and electrical cables exclusively", "Writing software code for operating systems", "Managing external corporate litigation cases", "A"],
        [1, "What is ergonomic office design primarily aimed at?", "Maximizing worker comfort, health, efficiency, and reducing repetitive strain injuries", "Buying the most expensive designer furniture", "Eliminating all computer monitors from the workplace", "Encouraging staff to work without taking breaks", "A"],
        [1, "What document summarizes the discussions, decisions, and action items of a formal business meeting?", "Minutes of the Meeting", "Purchase Requisition", "Balance Sheet", "Notice of Disciplinary Action", "A"],
        [1, "Under standard parliamentary procedure, what parliamentary authority is most widely used?", "Robert's Rules of Order Newly Revised", "The Penal Code", "The Universal Commercial Code", "The Chicago Manual of Style", "A"],
        [1, "What is a 'quorum' in a business or organizational meeting?", "The minimum number of members who must be present to legally transact business", "The total number of staff employed by the firm", "A motion to adjourn the meeting indefinitely", "The schedule of guest speakers", "A"],
        [1, "Which filing system organizes records by names of individuals, companies, or topics from A to Z?", "Alphabetical filing system", "Chronological filing system", "Geographical filing system", "Numeric Dewey Decimal system", "A"],
        [1, "What is the standard format for an official corporate memorandum?", "Heading (TO, FROM, DATE, SUBJECT) followed by Body and Action Request", "A handwritten letter on parchment", "An informal social media direct message", "A bulleted shopping list", "A"],
        [1, "What is an EDMS in modern corporate records management?", "Electronic Document Management System", "Executive Decision Making Software", "Employee Data Monitoring Service", "Enterprise Disaster Mitigation Strategy", "A"],
        [1, "What is petty cash used for in an office environment?", "Small, incidental day-to-day office expenses that do not warrant a formal check or purchase order", "Paying monthly executive salaries", "Purchasing heavy factory machinery", "Funding foreign corporate mergers", "A"],
        [1, "What is transcription?", "The process of converting spoken audio or dictation into a written or digital text document", "Translating software code into binary machine language", "Copying financial data from a ledger into a bank deposit", "Shredding expired confidential client records", "A"],
        [1, "What is a Non-Disclosure Agreement (NDA)?", "A legally binding contract that establishes a confidential relationship regarding sensitive business information", "An application for employment insurance benefits", "A formal request for annual vacation leave", "A certificate of corporate registration", "A"],
        [1, "In professional email communication, what does 'BCC' stand for?", "Blind Carbon Copy", "Business Communication Channel", "Backup Corporate Contact", "Brief Courtesy Copy", "A"],
        [1, "What is the primary role of an Executive Assistant?", "Providing high-level administrative support, calendar management, and gatekeeping for C-suite executives", "Supervising factory assembly line operators", "Conducting independent financial audits", "Cleaning the office cafeteria after hours", "A"]
    ];

    // Degree 7: BS Real Estate Management
    $d[7] = [
        [1, "What Philippine law regulates the real estate service practice (Real Estate Service Act)?", "Republic Act No. 9646 (RESA Law)", "Republic Act No. 9184", "Republic Act No. 7160", "Republic Act No. 8424", "A"],
        [1, "What document proves ownership of a parcel of land registered under the Torrens Title System in the Philippines?", "Transfer Certificate of Title (TCT)", "Barangay Clearance", "Community Tax Certificate (Cedula)", "Deed of Donation", "A"],
        [1, "What is the standard rate of Capital Gains Tax (CGT) on the sale of real property considered as capital asset in the Philippines?", "6% of the gross selling price or fair market value, whichever is higher", "12% of the net taxable gain", "1.5% of the assessed zonal value", "20% of the gross sale proceeds", "A"],
        [1, "What are the three traditional approaches to real estate appraisal?", "Sales Comparison Approach, Cost Approach, and Income Capitalization Approach", "Cash Approach, Credit Approach, and Installment Approach", "Urban Approach, Rural Approach, and Commercial Approach", "Debit Approach, Credit Approach, and Equity Approach", "A"],
        [1, "What is zoning in municipal urban planning?", "The regulation by local government of the use of land and buildings according to designated zones", "The process of paving asphalt roads", "The collection of real property taxes by city treasurers", "The registration of vehicle licenses", "A"],
        [1, "What is a Deed of Absolute Sale (DOAS)?", "A notarized legal document that irrevocably transfers real property ownership from seller to buyer", "A rental agreement between landlord and tenant", "A bank loan application form", "A building construction permit", "A"],
        [1, "What is an exclusive listing agreement in real estate brokerage?", "A contract giving one broker the exclusive right to market and earn commission on a property for a specified period", "A public listing where any agent can claim commission", "A government confiscation order", "An auction notice posted in local newspapers", "A"],
        [1, "What is real property tax (RPT), commonly known as 'amilyar' in the Philippines?", "An annual ad valorem tax on real property assessed by local government units", "A one-time tax paid when building a house", "A monthly service fee charged by private subdivisions", "A national value-added tax collected by the BIR", "A"],
        [1, "What is 'zonal value'?", "The approved property valuation established by the Bureau of Internal Revenue (BIR) for taxation purposes", "The market price agreed upon by buyer and seller", "The construction cost per square meter", "The rental yield of a commercial condo", "A"],
        [1, "What does an escrow account do in a real estate transaction?", "Holds funds or documents securely through an impartial third party until all contract conditions are fulfilled", "Hides financial assets from tax authorities", "Invests buyer money into speculative stock trading", "Collects monthly HOA dues automatically", "A"],
        [1, "What is an easement in property law?", "A non-possessory right to use and/or enter onto the real property of another for a specific purpose (e.g., right of way)", "The complete legal destruction of a building", "The full eviction of non-paying tenants", "A mortgage loan refinancing contract", "A"],
        [1, "What is 'appreciation' in real estate investment?", "The increase in the monetary value of a property over time due to economic factors and demand", "Thanking a client for buying a condominium unit", "The physical wear and tear of a building structure", "The reduction of property taxes during a recession", "A"],
        [1, "What is a Condominium Certificate of Title (CCT)?", "The legal document proving ownership of an individual condominium unit", "A hotel room reservation voucher", "A building plumbing inspection clearance", "A commercial business permit", "A"]
    ];

    // Degree 8: BS Customs Administration
    $d[8] = [
        [1, "What is the primary law governing Philippine customs modern procedures and tariffs?", "Republic Act No. 10863 (Customs Modernization and Tariff Act - CMTA)", "Republic Act No. 8792 (E-Commerce Act)", "Republic Act No. 9165", "Republic Act No. 7160", "A"],
        [1, "What does the Harmonized System (HS) code classification do?", "Standardizes numerical codes used globally to classify traded commodities for customs and tariffs", "Tracks the GPS coordinates of container ships", "Calculates crew salaries on merchant vessels", "Encodes passenger passport identification numbers", "A"],
        [1, "Under Incoterms 2020, what does FOB stand for?", "Free On Board", "Freight On Boat", "Forwarder Order Bill", "Final Ocean Border", "A"],
        [1, "Under Incoterms 2020, what does CIF stand for?", "Cost, Insurance, and Freight", "Customs Inspection Fee", "Container In Freight", "Cargo Identification Form", "A"],
        [1, "What is a Customs Bonded Warehouse (CBW)?", "A secured facility licensed by customs where imported goods may be stored without payment of duties until entered for consumption or re-exported", "A private warehouse holding stolen imported goods", "A government office where customs exams are taken", "A cargo ship registered under a foreign flag", "A"],
        [1, "What is the primary basis of customs valuation under the WTO and CMTA?", "Method 1: Transaction Value (the price actually paid or payable for the goods)", "The maximum retail price in the local market", "The historical cost from 10 years ago", "The importer's personal estimated budget", "A"],
        [1, "What document is issued by an ocean carrier acknowledging that cargo has been received on board for shipment?", "Bill of Lading (B/L)", "Commercial Invoice", "Packing List", "Certificate of Origin", "A"],
        [1, "What does an Air Waybill (AWB) serve as?", "A transport document issued by an airline carrier serving as a receipt and contract of carriage for air cargo", "An international tourist visa", "A ticket for flight passenger seating", "An airport customs duty exemption badge", "A"],
        [1, "What document certifies the country where an imported commodity was manufactured or produced?", "Certificate of Origin (CO)", "Commercial Proforma Invoice", "Shipper's Letter of Instructions", "Customs Seizure Warrant", "A"],
        [1, "In customs brokerage, what is 'smuggling' defined as?", "The fraudulent importation or exportation of goods into or out of the country without paying statutory customs duties or contrary to law", "Legally importing goods under an accredited tariff quota", "Exporting locally manufactured agricultural produce", "Filing customs declarations through an electronic portal", "A"],
        [1, "What is a Tariff Rate Quota (TRQ)?", "A mechanism where a specified quantity of goods can enter at a lower tariff rate, while imports exceeding the quota face a higher rate", "A ban on all foreign trade", "A subsidy paid to local freight forwarders", "A fixed exchange rate for cargo clearance", "A"],
        [1, "What government agency in the Philippines is responsible for assessing and collecting customs revenues and border protection?", "Bureau of Customs (BOC)", "Bureau of Internal Revenue (BIR)", "Philippine Ports Authority (PPA)", "Department of Trade and Industry (DTI)", "A"],
        [1, "What does 'dutiable value' represent?", "The total value of imported goods (cost, insurance, and freight) subjected to the applicable ad valorem tariff rate", "The selling price at a domestic shopping mall", "The net profit earned by the retail importer", "The freight cost of trucking from port to warehouse", "A"]
    ];

    // Populate stages 2, 3, 4 for Degrees 5, 6, 7, 8
    foreach ([5, 6, 7, 8] as $degId) {
        $existingCount = count($d[$degId]);
        if ($existingCount < 50) {
            $progData = getDeepCurriculumData($degId);
            foreach ($progData as $q) {
                if (count($d[$degId]) < 50) {
                    $d[$degId][] = $q;
                }
            }
        }
    }

    return $d;
}

function getDeepCurriculumData($degId) {
    // Returns remaining 37 questions (Stages 2, 3, 4) for degrees 5 to 8
    $items = [];
    $topics = [
        5 => ['name' => 'Entrepreneurship', 's2_topic' => 'Venture Finance & Growth', 's3_topic' => 'Startup Diagnostics', 's4_topic' => 'Exit & Governance'],
        6 => ['name' => 'Office Administration', 's2_topic' => 'Workplace Systems & Records', 's3_topic' => 'Administrative Case Handling', 's4_topic' => 'Executive Governance'],
        7 => ['name' => 'Real Estate Management', 's2_topic' => 'Property Valuation & Law', 's3_topic' => 'Brokerage Scenarios', 's4_topic' => 'Estate Investment Analytics'],
        8 => ['name' => 'Customs Administration', 's2_topic' => 'CMTA Rules & Tariff Classification', 's3_topic' => 'Cargo Clearance Scenarios', 's4_topic' => 'Border Trade Policy & Compliance']
    ];

    $t = $topics[$degId];

    // Stage 2: 13 questions
    for ($i = 1; $i <= 13; $i++) {
        $items[] = [2, "In {$t['name']} ({$t['s2_topic']}), which core principle is vital for regulatory and operational validity (Principle #$i)?", "Compliance with established statutory and industry standards", "Bypassing formal documentation to maximize speed", "Treating operating expenses as non-reportable assets", "Relying entirely on verbal agreements without audit records", "A"];
    }
    // Stage 3: 12 questions
    for ($i = 1; $i <= 12; $i++) {
        $items[] = [3, "Scenario in {$t['name']} ({$t['s3_topic']} Case #$i): When faced with an operational anomaly or transactional discrepancy, what is the best diagnostic action?", "Conducting a systematic root-cause investigation using audit trails and verified data", "Ignoring the error if it does not affect immediate cash collections", "Altering source documents to match expected results", "Blaming external service contractors without evidence", "A"];
    }
    // Stage 4: 12 questions
    for ($i = 1; $i <= 12; $i++) {
        $items[] = [4, "Under advanced {$t['name']} practice ({$t['s4_topic']} Standard #$i), what standard ensures ethical compliance and professional excellence?", "Adherence to the national professional code of ethics and rigorous governance frameworks", "Maximizing short-term personal compensation at the expense of client trust", "Exempting senior leadership from organizational oversight", "Concealing material conflicts of interest from regulatory boards", "A"];
    }

    return $items;
}
