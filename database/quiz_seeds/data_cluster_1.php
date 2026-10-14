<?php
/**
 * Cluster 1: Business and Management (Degrees 1 to 8)
 * 1: BS Business Administration
 * 2: BS Accountancy
 * 3: BS Accounting Technology
 * 4: BS Management Accounting
 * 5: BS Entrepreneurship
 * 6: BS Office Administration
 * 7: BS Real Estate Management
 * 8: BS Customs Administration
 */

function getCluster1Data() {
    $c = [];

    // Degree 1: BS Business Administration
    $c[1] = [
        [1, "What is the primary goal of corporate financial management?", "Maximizing shareholder wealth", "Minimizing employee count", "Eliminating company taxes", "Maximizing gross revenue only", "A"],
        [1, "In the marketing mix (4 Ps), which element relates to distribution channels?", "Product", "Price", "Place", "Promotion", "C"],
        [1, "What does SWOT analysis stand for?", "Sales, Wealth, Operations, Timing", "Strengths, Weaknesses, Opportunities, Threats", "Standard, Workflow, Organization, Tracking", "Strategy, Workforce, Output, Targets", "B"],
        [1, "What is working capital defined as?", "Current Assets minus Current Liabilities", "Total Assets minus Total Liabilities", "Gross Revenue minus Operating Costs", "Cash in bank minus Long-term Debt", "A"],
        [1, "Which leadership style involves high subordinate participation in decision making?", "Autocratic", "Democratic (Participative)", "Laissez-faire", "Bureaucratic", "B"],
        [1, "In human resource management, what is job analysis?", "Evaluating quarterly employee performance", "Determining duties, requirements, and nature of a job", "Calculating monthly payroll deductions", "Advertising vacancies on social media", "B"],
        [1, "What does 'break-even point' represent?", "Where net profit reaches 50%", "Where total revenue equals total costs", "Where variable costs exceed fixed costs", "Where production stops entirely", "B"],
        [1, "What is market segmentation?", "Dividing a broad consumer market into distinct sub-groups", "Decreasing prices to attract competitors' clients", "Closing physical branches to focus on ecommerce", "Separating sales staff by commission brackets", "A"],
        [1, "What does ROI stand for?", "Return on Investment", "Rate of Interest", "Return on Income", "Revenue on Inventory", "A"],
        [1, "In operations management, what does JIT stand for?", "Joint Industry Task", "Just-In-Time", "Job Inventory Tracking", "Judicial Investigation Team", "B"],
        [1, "What document outlines a firm's long-term direction, values, and purpose?", "Balance Sheet", "Mission and Vision Statement", "Articles of Incorporation", "General Ledger", "B"],
        [1, "Which organizational structure groups staff by specialized function?", "Functional Structure", "Divisional Structure", "Matrix Structure", "Flat Structure", "A"],
        [1, "What is the primary role of a balance sheet?", "Presenting revenue and expenses over a period", "Reporting assets, liabilities, and equity at a specific point in time", "Tracking daily cash flows", "Listing shareholder dividend distributions", "B"],

        [2, "According to Michael Porter, which of the following is NOT one of the Five Forces?", "Bargaining power of buyers", "Threat of substitute products", "Internal rate of return", "Rivalry among existing competitors", "C"],
        [2, "What principle states that greater potential return accompanies greater risk?", "Risk-Return Tradeoff", "Law of Diminishing Returns", "Agency Principle", "Pareto Principle", "A"],
        [2, "In marketing strategy, what is 'brand equity'?", "The book value of physical store assets", "The commercial value derived from consumer perception of the brand", "The annual cost of brand advertising campaigns", "The legal fee required to register a trademark", "B"],
        [2, "What is the Capital Asset Pricing Model (CAPM) used to calculate?", "Cost of debt financing", "Expected return of an asset based on systematic risk", "Optimal inventory reorder level", "Net present value of equipment", "B"],
        [2, "What does the BCG Matrix use to classify Strategic Business Units?", "Customer satisfaction and employee retention", "Market growth rate and relative market share", "Debt-to-equity ratio and dividend yield", "Product quality and production speed", "B"],
        [2, "In supply chain management, what is the 'bullwhip effect'?", "Increasing price volatility in consumer retail", "Distortion of demand information traveling up the supply chain", "A sudden shutdown of port shipping lanes", "Worker union strikes across logistic hubs", "B"],
        [2, "Under Herzberg's two-factor theory, which factor directly motivates employees?", "Salary and working conditions (Hygiene)", "Recognition and achievement (Motivators)", "Company policy and administration", "Supervision and peer relationships", "B"],
        [2, "What does Weighted Average Cost of Capital (WACC) represent?", "The interest rate charged by commercial banks", "The average rate of return a company must earn on its existing asset base to satisfy capital providers", "The gross profit margin after tax deductions", "The inflation-adjusted risk-free rate", "B"],
        [2, "What does the Pareto Principle (80/20 rule) typically indicate in sales analysis?", "80% of costs come from 20% of suppliers", "80% of revenue often originates from 20% of clients", "80% of staff generate 80% of profits", "20% of products require 80% storage space", "B"],
        [2, "In corporate governance, what is the 'Agency Problem'?", "Conflict of interest between management and shareholders", "Difficulty in finding registered advertising agencies", "Disputes between government regulators and consumers", "Inability to secure commercial credit lines", "A"],
        [2, "What is Total Quality Management (TQM) centered around?", "Mass production speed at minimal labor wages", "Continuous improvement and customer satisfaction across all organizational processes", "Outsourcing manufacturing to foreign markets", "Strict departmental isolation and hierarchy", "B"],
        [2, "Which inventory model identifies the order size that minimizes total inventory ordering and holding costs?", "Economic Order Quantity (EOQ)", "First In First Out (FIFO)", "Activity Based Costing (ABC)", "Material Requirement Planning (MRP)", "A"],
        [2, "In financial ratio analysis, what does the Quick Ratio exclude from Current Assets?", "Marketable securities", "Accounts receivable", "Inventory and prepaid expenses", "Cash and cash equivalents", "C"],

        [3, "A company faces declining sales in a saturated market. Which Ansoff Matrix strategy recommends launching new products into this existing market?", "Market Penetration", "Product Development", "Market Development", "Diversification", "B"],
        [3, "A manufacturing plant has fixed costs of $200,000, unit variable cost of $30, and selling price of $50. How many units must be sold to break even?", "4,000 units", "10,000 units", "6,667 units", "15,000 units", "B"],
        [3, "When evaluating two mutually exclusive capital projects with positive Net Present Values (NPV), which project should management approve?", "The one with the shorter payback period", "The project with the higher Net Present Value", "The project requiring the lowest initial outlay", "Both projects concurrently", "B"],
        [3, "A business experiences rapid customer turnover despite competitive prices. Which diagnostic step should the marketing team prioritize?", "Conducting customer exit interviews and satisfaction journey mapping", "Doubling the digital ad budget immediately", "Cutting employee sales commissions", "Redesigning the company logo", "A"],
        [3, "If a firm has an Accounts Receivable turnover ratio of 12, what is its average collection period in days (assuming a 360-day year)?", "12 days", "30 days", "45 days", "60 days", "B"],
        [3, "A company's current ratio is 2.5:1, but its quick ratio is 0.7:1. What does this disparity signal?", "The company holds an excessively high proportion of its current assets in inventory", "The company has zero accounts payable", "Cash reserves are higher than total liabilities", "Accounts receivable are uncollectible", "A"],
        [3, "During high inflation, which inventory accounting method results in lower reported net income and lower tax liability?", "FIFO", "LIFO", "Weighted Average", "Specific Identification", "B"],
        [3, "A retail chain notices stockouts in popular items while unpopular items gather dust. What inventory classification technique should be implemented first?", "ABC Inventory Analysis based on annual consumption value", "Just-In-Case hoarding", "Complete liquidation of all lines", "Random bin stocking", "A"],
        [3, "When conducting performance appraisals, a manager rates an employee high in all areas simply because the employee arrives early. What evaluation bias is occurring?", "Leniency error", "Halo effect", "Recency bias", "Central tendency", "B"],
        [3, "A consumer goods company discovers a major product defect. What immediate operational PR step is required?", "Denying the fault until formal regulatory fines are issued", "Initiating a transparent voluntary recall and open consumer hotline", "Offering discounts on the defective batch", "Terminating lower-level assembly workers publicly", "B"],
        [3, "If a startup company has a monthly burn rate of $25,000 and current cash reserves of $200,000, what is its runway?", "5 months", "8 months", "12 months", "16 months", "B"],
        [3, "A service company wants to optimize customer wait times at cashier stations. Which analytical technique from operations research is best suited?", "Queuing Theory", "Game Theory", "Linear Regression", "Critical Path Method", "A"],

        [4, "In advanced corporate valuation, what does the Discounted Cash Flow (DCF) model discount to find enterprise value?", "Gross accounting revenue", "Projected Free Cash Flows (FCFF) discounted at the WACC", "Net earnings before interest", "Book value of shareholder equity", "B"],
        [4, "What is the primary role of a 'balanced scorecard' in strategic enterprise management?", "Balancing debit and credit ledgers at fiscal year end", "Translating strategy into performance measures across Financial, Customer, Internal Process, and Learning & Growth perspectives", "Auditing regulatory compliance for environmental emissions", "Setting statutory employee overtime compensation", "B"],
        [4, "In international business, what is 'transfer pricing'?", "The price charged between related entities of a multinational enterprise for goods, services, or intangibles", "The exchange rate set by central banks for cross-border currency purchases", "The shipping fee invoiced by global freight forwarders", "The duty levied by customs on imported agricultural goods", "A"],
        [4, "Under Lean Six Sigma, what defect rate is acceptable at the Six Sigma level?", "3.4 defects per million opportunities (DPMO)", "100 defects per million opportunities", "1,000 defects per million opportunities", "0.01% defects per batch", "A"],
        [4, "In financial derivatives, what is the primary purpose of a currency swap agreement?", "Speculating on cryptocurrency volatility", "Hedging against exchange rate risk on cross-border debt obligations", "Evading foreign investment taxation", "Accelerating customs clearance at international ports", "B"],
        [4, "What strategic move occurs when a car manufacturer purchases a tire production facility?", "Backward Vertical Integration", "Forward Vertical Integration", "Horizontal Diversification", "Conglomerate Merger", "A"],
        [4, "In econometric demand modeling, if price elasticity of demand is -1.8, what happens to total revenue if the firm increases its product price?", "Total revenue remains unchanged", "Total revenue decreases", "Total revenue increases by 80%", "Total revenue doubles", "B"],
        [4, "What does the DuPont Analysis decompose Return on Equity (ROE) into?", "Gross Margin, Operating Margin, and Net Margin", "Net Profit Margin, Asset Turnover, and Financial Leverage (Equity Multiplier)", "Current Ratio, Quick Ratio, and Cash Ratio", "P/E Ratio, Dividend Yield, and Book Value per Share", "B"],
        [4, "Under the DMAIC methodology in Six Sigma, what does the 'I' represent?", "Integrate", "Improve", "Inspect", "Initiate", "B"],
        [4, "In labor relations, what is the process of negotiation between employers and a group of employees aimed at agreements regarding working conditions?", "Arbitration", "Collective Bargaining", "Mediation", "Conciliation", "B"],
        [4, "What is 'goodwill' on a corporate consolidated balance sheet?", "A charity fund established by the board", "The excess purchase price paid over the fair market value of an acquired company's net identifiable assets", "The estimated brand value of internally developed products", "The accumulated retained earnings from customer loyalty programs", "B"],
        [4, "In modern change management, what are the three stages of Kurt Lewin's Change Model?", "Initiate, Implement, Maintain", "Unfreeze, Change (Move), Refreeze", "Plan, Do, Check", "Identify, Analyze, Control", "B"]
    ];

    // Degree 2: BS Accountancy
    $c[2] = [
        [1, "What is the fundamental accounting equation?", "Assets = Liabilities + Equity", "Assets = Liabilities - Equity", "Equity = Assets + Liabilities", "Liabilities = Assets + Equity", "A"],
        [1, "What normal balance do Asset accounts have?", "Credit", "Debit", "Neutral", "Variable", "B"],
        [1, "Which financial statement reports a company's financial performance over a specific period of time?", "Balance Sheet", "Income Statement", "Statement of Financial Position", "Audit Certificate", "B"],
        [1, "What does GAAP stand for?", "General Accounting and Auditing Principles", "Generally Accepted Accounting Principles", "Global Association of Accountancy Professionals", "Government Approved Accounting Procedures", "B"],
        [1, "What type of account is Accumulated Depreciation?", "Current Asset", "Contra-Asset", "Current Liability", "Operating Expense", "B"],
        [1, "When cash is received in advance of services rendered, how is it initially recorded?", "Unearned Revenue (Liability)", "Service Revenue (Equity)", "Accounts Receivable (Asset)", "Prepaid Expense (Asset)", "A"],
        [1, "What is the primary book of original entry in double-entry bookkeeping?", "General Ledger", "General Journal", "Trial Balance", "Bank Reconciliation", "B"],
        [1, "Under the accrual basis of accounting, when are revenues recognized?", "When cash is deposited in the bank", "When earned, regardless of when cash is received", "At the end of the calendar year", "When the customer signs the contract", "B"],
        [1, "Which account has a normal Credit balance?", "Cash", "Salaries Expense", "Accounts Payable", "Equipment", "C"],
        [1, "What is a trial balance?", "A formal financial statement submitted to tax authorities", "A list of all general ledger accounts and their balances to verify debit-credit equality", "An auditor's final opinion report", "A summary of petty cash vouchers", "B"],
        [1, "What is the allocation of the cost of an intangible asset over its useful life called?", "Depreciation", "Amortization", "Depletion", "Impairment", "B"],
        [1, "Which organization sets International Financial Reporting Standards (IFRS)?", "FASB", "IASB", "AICPA", "SEC", "B"],
        [1, "What document reconciles the bank balance per ledger with the balance per bank statement?", "Bank Reconciliation Statement", "Cash Flow Forecast", "Voucher Register", "Petty Cash Summary", "A"],

        [2, "What does the matching principle require?", "Expenses must be recognized in the same period as the revenues they helped generate", "Assets must match liabilities at all times", "Tax deductions must match bank deposits", "Debits must equal credits in every ledger page", "A"],
        [2, "Under IFRS 15, how many steps are in the revenue recognition framework?", "3 steps", "5 steps", "7 steps", "10 steps", "B"],
        [2, "What is the difference between FOB Shipping Point and FOB Destination?", "In Shipping Point, buyer owns goods in transit; in Destination, seller owns until delivery", "In Destination, buyer pays freight; in Shipping Point, carrier pays freight", "There is no legal difference in title transfer", "Shipping Point applies only to air cargo", "A"],
        [2, "How is net realizable value (NRV) of accounts receivable computed?", "Gross Accounts Receivable minus Allowance for Doubtful Accounts", "Accounts Receivable plus Bad Debt Expense", "Accounts Receivable divided by Cash collections", "Total Credit Sales minus Cash Sales", "A"],
        [2, "What type of audit opinion indicates that financial statements are presented fairly in all material respects?", "Qualified Opinion", "Unqualified (Clean) Opinion", "Adverse Opinion", "Disclaimer of Opinion", "B"],
        [2, "Under IAS 2 / PAS 2, inventories are measured at the lower of:", "Cost and Fair Value", "Cost and Net Realizable Value (NRV)", "Replacement Cost and Historical Cost", "Retail Price and Wholesale Price", "B"],
        [2, "What is materiality in financial accounting?", "The physical weight of office assets", "The magnitude of an omission or misstatement that could influence users' economic decisions", "The legal validity of corporate contracts", "The tangible nature of plant and equipment", "B"],
        [2, "In partnership accounting, how are remaining profits divided if no agreement exists?", "Equally among all partners", "In proportion to their capital contributions", "By court order", "Given entirely to the managing partner", "B"],
        [2, "What happens to the accounting equation when a business purchases equipment on credit?", "Assets increase and Liabilities increase", "Assets increase and Equity increases", "Assets decrease and Liabilities decrease", "Liabilities increase and Equity decreases", "A"],
        [2, "Under IAS 16, what are the two acceptable accounting models for Property, Plant, and Equipment?", "Cost Model and Revaluation Model", "Fair Value Model and Liquidation Model", "Historical Model and Tax Model", "Amortized Model and Impairment Model", "A"],
        [2, "What is the purpose of preparing closing entries at the end of an accounting period?", "Transferring temporary account balances to permanent equity accounts", "Adjusting inventory to replacement value", "Correcting mathematical errors in the trial balance", "Closing bank accounts for year-end audit", "A"],
        [2, "What is 'retained earnings'?", "Cash reserved exclusively for board member bonuses", "Cumulative net income earned by the business less dividends distributed to shareholders", "Total assets minus total liabilities", "Government tax refunds held in escrow", "B"],
        [2, "What is an adjusting entry for an accrued expense?", "Debit Expense, Credit Payable", "Debit Payable, Credit Cash", "Debit Expense, Credit Cash", "Debit Asset, Credit Expense", "A"],

        [3, "An enterprise purchased a machine for $100,000 with a salvage value of $10,000 and useful life of 5 years. What is the annual depreciation under the straight-line method?", "$20,000", "$18,000", "$22,000", "$15,000", "B"],
        [3, "During a bank reconciliation, an outstanding check of $5,000 was identified. How is this treated on the reconciliation?", "Deducted from the book balance", "Deducted from the bank balance", "Added to the bank balance", "Added to the book balance", "B"],
        [3, "A company had gross sales of $500,000, sales discounts of $10,000, cost of goods sold of $300,000, and operating expenses of $80,000. What is the gross profit?", "$190,000", "$200,000", "$110,000", "$210,000", "A"],
        [3, "On Dec 1, a firm paid $12,000 for a 1-year insurance policy starting immediately. What adjusting entry is made on Dec 31?", "Debit Insurance Expense $1,000, Credit Prepaid Insurance $1,000", "Debit Prepaid Insurance $12,000, Credit Cash $12,000", "Debit Insurance Expense $12,000, Credit Cash $12,000", "No entry required until policy expires", "A"],
        [3, "A customer's $3,000 account is written off under the allowance method. What is the immediate effect on the net realizable value of accounts receivable?", "Increases by $3,000", "Decreases by $3,000", "No change", "Reduces cash balance by $3,000", "C"],
        [3, "An auditor discovers unrecorded liabilities of significant value near the balance sheet date. What audit procedure was most likely used to detect this?", "Search for unrecorded liabilities through subsequent cash disbursements review", "Confirming bank account interest rates", "Counting physical petty cash on hand", "Reviewing minutes of board meetings from 5 years ago", "A"],
        [3, "A business sells goods with a 1-year assurance warranty. Based on past experience, warranty claims equal 2% of sales. If sales were $1,000,000, what is the warranty expense entry?", "Debit Warranty Expense $20,000, Credit Estimated Warranty Liability $20,000", "Debit Cash $20,000, Credit Warranty Revenue $20,000", "Debit Warranty Liability $20,000, Credit Cash $20,000", "No entry until customers make a claim", "A"],
        [3, "Company X issues $1,000,000 of 8% bonds when the market interest rate is 10%. Will the bonds be issued at par, premium, or discount?", "At Par", "At a Premium", "At a Discount", "Cannot be determined without maturity date", "C"],
        [3, "If inventory was overstated by $50,000 at the end of Year 1, what is the effect on Year 1 Net Income?", "Net income was understated by $50,000", "Net income was overstated by $50,000", "Net income was unaffected", "Gross profit decreased by $50,000", "B"],
        [3, "Under the indirect method of statement of cash flows, how is an increase in Accounts Receivable treated in operating cash flows?", "Added to net income", "Deducted from net income", "Reported as financing outflow", "Ignored completely", "B"],
        [3, "A company reacquires 1,000 shares of its own common stock at $15 per share. How is this recorded under the cost method?", "Debit Treasury Stock $15,000, Credit Cash $15,000", "Debit Investment in Stocks $15,000, Credit Cash $15,000", "Debit Common Stock $15,000, Credit Gain on Stock $15,000", "Debit Retained Earnings $15,000, Credit Cash $15,000", "A"],
        [3, "A company has a debt-to-equity ratio of 1.5. If total equity is $400,000, what are total assets?", "$600,000", "$1,000,000", "$800,000", "$400,000", "B"],

        [4, "Under IFRS 16 / PFRS 16 Leases, how must a lessee record almost all operating leases?", "As off-balance-sheet commitments in disclosures only", "As a Right-of-Use (ROU) Asset and a Lease Liability on the balance sheet", "As straight-line rent expense without balance sheet entry", "As contingent liabilities subject to court review", "B"],
        [4, "What is the primary objective of IAS 36 / PAS 36 Impairment of Assets?", "Ensuring assets are not carried at more than their recoverable amount", "Calculating annual income tax liabilities", "Determining fair value of newly issued common shares", "Auditing employee expense reimbursements", "A"],
        [4, "In business combinations under IFRS 3, what method of accounting is mandatory?", "Pooling of Interests method", "Acquisition method", "Proportional Consolidation method", "Cost recovery method", "B"],
        [4, "What is the difference between a Temporary Difference and a Permanent Difference under IAS 12 Income Taxes?", "Temporary differences reverse in future periods creating deferred taxes; permanent differences do not reverse", "Temporary differences affect cash; permanent differences affect inventory", "Permanent differences create deferred tax assets only", "There is no distinction under Philippine tax law", "A"],
        [4, "Under PSA 700 (Revised), what section in the independent auditor's report highlights the matters of most significance in the audit of current period financial statements?", "Basis for Opinion", "Key Audit Matters (KAM)", "Emphasis of Matter paragraph", "Other Information paragraph", "B"],
        [4, "How is non-controlling interest (NCI) presented on the consolidated statement of financial position under IFRS?", "As a long-term liability", "Within equity, separately from the equity of the owners of the parent", "Deducted directly from consolidated assets", "As a footnote disclosure only", "B"],
        [4, "What constitutes 'functional currency' under IAS 21?", "The currency of the country where the parent company is incorporated", "The currency of the primary economic environment in which the entity operates", "The US Dollar exclusively", "The currency used by local tax authorities", "B"],
        [4, "Under IFRS 9, how are financial assets classified?", "Based on the entity's business model for managing them and contractual cash flow characteristics", "Based purely on management intent at each balance sheet date", "Based on whether the counterparty is a public corporation", "Into Current and Non-current portfolios only", "A"],
        [4, "In governmental and fund accounting, what basis of accounting is typically used for Governmental Funds?", "Full accrual basis", "Modified accrual basis", "Cash basis", "Tax basis", "B"],
        [4, "Under IAS 37, when should a provision be recognized?", "When there is a present obligation as a result of past event, probable outflow of resources, and reliable estimate", "Whenever a lawsuit is threatened verbally", "Only after a formal court verdict has been delivered and appealed", "Whenever management wishes to reduce tax liability", "A"],
        [4, "In forensic accounting, what are the three elements of the Fraud Triangle formulated by Donald Cressey?", "Pressure (Incentive), Opportunity, and Rationalization", "Greed, Opportunity, and Deception", "Motive, Means, and Concealment", "Pressure, Theft, and Accomplice", "A"],
        [4, "What is the impact of an uncorrected prior period material error on the current year's financial statements?", "Retrospectively corrected by restating comparative prior period amounts", "Reported as an extraordinary gain/loss in current year income statement", "Expensed immediately in operating expenses", "Ignored if the statute of limitations has passed", "A"]
    ];

    // Load Degrees 3 and 4 from batch_1.php
    require_once __DIR__ . '/batch_1.php';
    $b1 = getBatch1Questions();
    $c[3] = $b1[3];
    $c[4] = $b1[4];

    // Generate Degrees 5 to 8
    require_once __DIR__ . '/data_cluster_1_ext.php';
    $ext = getCluster1ExtData();
    foreach ($ext as $id => $qs) {
        $c[$id] = $qs;
    }

    return $c;
}
