<?php

namespace App\Controllers;

use App\Models\Account_model;
use App\Models\Client_model; // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;
use App\Models\Acctype_model;

class Account extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Account_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
    }





public function getLedgerByFY($cid)
{
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON(['error' => 'Invalid request']);
    }

    if (!$cid) {
        return $this->response->setJSON(['error' => 'Client ID is required']);
    }

    $fy = $this->request->getGet('fy');
    $u_type =$this->request->getGet('u_type'); ; // Consider fetching dynamically if applicable

    if (!$fy) {
        return $this->response->setJSON(['error' => 'Financial year is required']);
    }

    list($startYear, $endYear) = explode("-", $fy);
    $startDate = "$startYear-04-01";
    $endDate = "$endYear-03-31";



if($u_type == 0)
{


//  $sql2="WITH Ledger AS (
//     SELECT 
//         a.cid, 
//         COALESCE(a.opening_bal, 0) AS opening_balance, 
        
//         -- Total Credit from invest2
//         COALESCE(SUM(i.totalamount), 0) AS total_credit, 
        
//         -- Total Debit from paidhistory
//         COALESCE(SUM(p.amount), 0) AS total_debit, 
        
//         -- Financial Year Calculation
//         CASE 
//             WHEN EXTRACT(MONTH FROM COALESCE(i.created, p.dateofpayment)) >= 4 
//             THEN CONCAT(YEAR(COALESCE(i.created, p.dateofpayment)), '-', YEAR(COALESCE(i.created, p.dateofpayment)) + 1)
//             ELSE CONCAT(YEAR(COALESCE(i.created, p.dateofpayment)) - 1, '-', YEAR(COALESCE(i.created, p.dateofpayment)))
//         END AS fy,

//         COALESCE(i.created, p.dateofpayment) AS transaction_date

//     FROM account a
//     LEFT JOIN invtest2 i ON a.cid = i.cid
//     LEFT JOIN paidhistory p ON a.cid = p.cid
//     WHERE a.cid = ? -- Change based on client ID
//     GROUP BY a.cid, a.opening_bal, fy, transaction_date
// )

// SELECT 
//     l1.cid, 
//     COALESCE(l2.closing_balance, l1.opening_balance) AS opening_balance, 
//     (COALESCE(l2.closing_balance, l1.opening_balance) + l1.total_credit) AS total_credit, 
//     l1.total_debit,
//     (COALESCE(l2.closing_balance, l1.opening_balance) + l1.total_credit - l1.total_debit) AS closing_balance,
//     l1.fy
// FROM Ledger l1
// LEFT JOIN (
//     SELECT 
//         cid, 
//         fy, 
//         (opening_balance + total_credit - total_debit) AS closing_balance 
//     FROM Ledger
// ) l2 
// ON l1.cid = l2.cid 
// AND l1.fy = (
//     SELECT MIN(fy) FROM Ledger WHERE cid = l1.cid AND fy > l2.fy
// )
// WHERE l1.transaction_date BETWEEN ? AND ? -- 🔥 Date filter here
// ORDER BY l1.fy";   

 $cid=(int)$cid;   

$sql2="-- Set up the financial year-wise credit data
WITH credit_data AS (
    SELECT 
        cid,
        CASE 
            WHEN MONTH(created) >= 4 
                THEN CONCAT(YEAR(created), '-', YEAR(created) + 1)
            ELSE CONCAT(YEAR(created) - 1, '-', YEAR(created))
        END AS fy,
        SUM(totalamount) AS total_credit
    FROM invtest2
    WHERE cid = {$cid}
    GROUP BY cid, fy
),

-- Set up the financial year-wise debit data
debit_data AS (
    SELECT 
        cid,
        CASE 
            WHEN MONTH(dateofpayment) >= 4 
                THEN CONCAT(YEAR(dateofpayment), '-', YEAR(dateofpayment) + 1)
            ELSE CONCAT(YEAR(dateofpayment) - 1, '-', YEAR(dateofpayment))
        END AS fy,
        SUM(amount) AS total_debit
    FROM paidhistory
    WHERE cid = {$cid}
    GROUP BY cid, fy
),

-- Combine both credit and debit with financial year
fy_combined AS (
    SELECT 
        COALESCE(c.cid, d.cid) AS cid,
        COALESCE(c.fy, d.fy) AS fy,
        COALESCE(c.total_credit, 0) AS total_credit,
        COALESCE(d.total_debit, 0) AS total_debit
    FROM credit_data c
    LEFT JOIN debit_data d ON c.cid = d.cid AND c.fy = d.fy
    UNION
    SELECT 
        COALESCE(c.cid, d.cid) AS cid,
        COALESCE(c.fy, d.fy) AS fy,
        COALESCE(c.total_credit, 0) AS total_credit,
        COALESCE(d.total_debit, 0) AS total_debit
    FROM debit_data d
    LEFT JOIN credit_data c ON d.cid = c.cid AND d.fy = c.fy
),

-- Add opening balance from account
all_data AS (
    SELECT 
        a.cid,
        a.opening_bal,
        f.fy,
        f.total_credit,
        f.total_debit
    FROM account a
    JOIN fy_combined f ON a.cid = f.cid
    WHERE a.cid = {$cid}
)

-- Final query to calculate running balance year-wise
SELECT 
    cid,
    fy,
    CAST(@opening_balance := IF(@opening_balance IS NULL, opening_bal, @opening_balance) AS DECIMAL(15,2)) AS opening_balance,
    total_credit,
    total_debit,
    CAST(@opening_balance := @opening_balance + total_credit - total_debit AS DECIMAL(15,2)) AS closing_balance
FROM all_data, (SELECT @opening_balance := NULL) AS vars
ORDER BY fy";
// $query2 = $this->db->query($sql2, [
//     $cid,
//     $startYear . '-04-01', $endYear . '-03-31',  // For invtest2 date range
//     //$startYear . '-04-01', $endYear . '-03-31',  // For paidhistory date range
    
// ]);

$query2=$this->db->query($sql2);
$result2 = $query2->getResultArray();



}
elseif ($u_type == 1) {


$cid=(int)$cid;


   $sql2="WITH FinancialYears AS (
    SELECT DISTINCT 
        CASE 
            WHEN EXTRACT(MONTH FROM invdate) >= 4 
            THEN CONCAT(YEAR(invdate), '-', YEAR(invdate) + 1)
            ELSE CONCAT(YEAR(invdate) - 1, '-', YEAR(invdate))
        END AS fy
    FROM purchaseinv2
    WHERE cid = {$cid}
    
    UNION
    
    SELECT DISTINCT 
        CASE 
            WHEN EXTRACT(MONTH FROM dateofpayment) >= 4 
            THEN CONCAT(YEAR(dateofpayment), '-', YEAR(dateofpayment) + 1)
            ELSE CONCAT(YEAR(dateofpayment) - 1, '-', YEAR(dateofpayment))
        END AS fy
    FROM paidhistory
    WHERE cid = {$cid}
),

LedgerData AS (
    SELECT 
        f.fy, 
        a.cid, 
        a.opening_bal AS initial_opening_balance,

        -- Total Credit
        (SELECT COALESCE(SUM(pinv.totalamount), 0) 
         FROM purchaseinv2 pinv
         WHERE pinv.cid = a.cid 
         AND (CASE 
                WHEN EXTRACT(MONTH FROM pinv.invdate) >= 4 
                THEN CONCAT(YEAR(pinv.invdate), '-', YEAR(pinv.invdate) + 1)
                ELSE CONCAT(YEAR(pinv.invdate) - 1, '-', YEAR(pinv.invdate))
              END) = f.fy
        ) AS total_credit,

        -- Total Debit
        (SELECT COALESCE(SUM(ph.amount), 0) 
         FROM paidhistory ph
         WHERE ph.cid = a.cid 
         AND (CASE 
                WHEN EXTRACT(MONTH FROM ph.dateofpayment) >= 4 
                THEN CONCAT(YEAR(ph.dateofpayment), '-', YEAR(ph.dateofpayment) + 1)
                ELSE CONCAT(YEAR(ph.dateofpayment) - 1, '-', YEAR(ph.dateofpayment))
              END) = f.fy
        ) AS total_debit

    FROM FinancialYears f
    CROSS JOIN account a
    WHERE a.cid = {$cid} 
    ),

FinalLedger AS (
    SELECT 
        ld.cid, 
        ld.fy, 

        -- Opening Balance: Use previous year’s closing balance
        COALESCE(
            LAG(ld.initial_opening_balance + ld.total_credit - ld.total_debit) 
            OVER (PARTITION BY ld.cid ORDER BY ld.fy),
            ld.initial_opening_balance  -- Use initial balance only for first year
        ) AS opening_balance,

        ld.total_credit,
        ld.total_debit,

        -- Correct Closing Balance Calculation
        (COALESCE(
            LAG(ld.initial_opening_balance + ld.total_credit - ld.total_debit) 
            OVER (PARTITION BY ld.cid ORDER BY ld.fy),
            ld.initial_opening_balance
        ) + ld.total_credit - ld.total_debit) AS closing_balance
    FROM LedgerData ld
)

SELECT * FROM FinalLedger ORDER BY fy";

    //$query2 = $this->db->query($sql2, [$cid,$cid,$cid]);

    $query2 = $this->db->query($sql2);

$result2 = $query2->getResultArray();


}
elseif ($u_type==2) {




$sql2 = "WITH FinancialYears AS (
    SELECT DISTINCT 
        CASE 
            WHEN EXTRACT(MONTH FROM created) >= 4 
            THEN CONCAT(YEAR(created), '-', YEAR(created) + 1)
            ELSE CONCAT(YEAR(created) - 1, '-', YEAR(created))
        END AS fy
    FROM invtest2
    WHERE cid = :cid
    
    UNION
    
    SELECT DISTINCT 
        CASE 
            WHEN EXTRACT(MONTH FROM invdate) >= 4 
            THEN CONCAT(YEAR(invdate), '-', YEAR(invdate) + 1)
            ELSE CONCAT(YEAR(invdate) - 1, '-', YEAR(invdate))
        END AS fy
    FROM purchaseinv2
    WHERE cid = :cid
    
    UNION
    
    SELECT DISTINCT 
        CASE 
            WHEN EXTRACT(MONTH FROM dateofpayment) >= 4 
            THEN CONCAT(YEAR(dateofpayment), '-', YEAR(dateofpayment) + 1)
            ELSE CONCAT(YEAR(dateofpayment) - 1, '-', YEAR(dateofpayment))
        END AS fy
    FROM paidhistory
    WHERE cid = :cid
),

LedgerData AS (
    SELECT 
        f.fy, 
        a.cid, 
        a.opening_bal AS initial_opening_balance,

        -- Total Credit (paidhistory + invtest2)
        (SELECT COALESCE(SUM(ph.amount), 0) 
         FROM paidhistory ph
         WHERE ph.cid = a.cid 
         AND (CASE 
                WHEN EXTRACT(MONTH FROM ph.dateofpayment) >= 4 
                THEN CONCAT(YEAR(ph.dateofpayment), '-', YEAR(ph.dateofpayment) + 1)
                ELSE CONCAT(YEAR(ph.dateofpayment) - 1, '-', YEAR(ph.dateofpayment))
              END) = f.fy
        ) +
        (SELECT COALESCE(SUM(it.totalamount), 0) 
         FROM invtest2 it
         WHERE it.cid = a.cid 
         AND (CASE 
                WHEN EXTRACT(MONTH FROM it.created) >= 4 
                THEN CONCAT(YEAR(it.created), '-', YEAR(it.created) + 1)
                ELSE CONCAT(YEAR(it.created) - 1, '-', YEAR(it.created))
              END) = f.fy
        ) AS total_credit,

        -- Total Debit (purchaseinv2)
        (SELECT COALESCE(SUM(pinv.totalamount), 0) 
         FROM purchaseinv2 pinv
         WHERE pinv.cid = a.cid 
         AND (CASE 
                WHEN EXTRACT(MONTH FROM pinv.invdate) >= 4 
                THEN CONCAT(YEAR(pinv.invdate), '-', YEAR(pinv.invdate) + 1)
                ELSE CONCAT(YEAR(pinv.invdate) - 1, '-', YEAR(pinv.invdate))
              END) = f.fy
        ) AS total_debit

    FROM FinancialYears f
    CROSS JOIN account a
    WHERE a.cid = :cid
),

FinalLedger AS (
    SELECT 
        ld.cid, 
        ld.fy, 

        -- Opening Balance: Carry forward from previous year's closing balance
        COALESCE(
            LAG(ld.initial_opening_balance + ld.total_debit - ld.total_credit) 
            OVER (PARTITION BY ld.cid ORDER BY ld.fy),
            ld.initial_opening_balance
        ) AS opening_balance,

        ld.total_credit,
        ld.total_debit,

        -- Closing Balance Calculation: opening balance + total debit - total credit
        (COALESCE(
            LAG(ld.initial_opening_balance + ld.total_debit - ld.total_credit) 
            OVER (PARTITION BY ld.cid ORDER BY ld.fy),
            ld.initial_opening_balance
        ) + ld.total_debit - ld.total_credit) AS closing_balance
    FROM LedgerData ld
)

SELECT * FROM FinalLedger ORDER BY fy";

$sql2 = str_replace(':cid', intval($cid), $sql2);
$query2 = $this->db->query($sql2);
$result2 = $query2->getResultArray();


}


    //$query2 = $this->db->query($sql2, [$cid, $startYear,$endYear,$startYear,$endYear]);
        if ($u_type == 0) { // Sales and Receipts Ledger
        $sql = "
            SELECT 
                CASE 
                    WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
                    ELSE CONCAT(X.invoice_details, '+', COALESCE(X.orderid, 'N/A'))  
                END AS invoice_details,
                
                X.credit, 
                X.debit, 
                FORMAT(X.credit, 2) AS formatted_credit, 
                FORMAT(X.debit, 2) AS formatted_debit, 
                
                X.created, 
                X.voucher_type
            FROM (
                SELECT 
                    invtest2.orderid,
                    invtest2.invid AS invoice_details, 
                    NULL AS debit,                    
                    invtest2.totalamount AS credit,    
                    invtest2.created, 
                    'Sales' AS voucher_type
                FROM invtest2 
                WHERE invtest2.cid = ?
                AND invtest2.created BETWEEN ? AND ?
                    
                UNION
                
                SELECT 
                    NULL AS orderid,                 
                    NULL AS invoice_details,         
                    paidhistory.amount AS debit,     
                    NULL AS credit,                  
                    paidhistory.dateofpayment AS created, 
                    'Receipt' AS voucher_type
                FROM paidhistory 
                WHERE paidhistory.cid = ?
                AND paidhistory.dateofpayment BETWEEN ? AND ?
            ) AS X, (SELECT @serial_number := 0) AS init
            ORDER BY X.created ASC";

             $query = $this->db->query($sql, [$cid, $startDate, $endDate, $cid, $startDate, $endDate]);
        $result = $query->getResultArray();


         } elseif ($u_type == 1) {
        // Purchases and Receipts Ledger
        $sql = "
           SELECT  
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
        ELSE CONCAT(X.invoice_details, '+', COALESCE(X.orderid, 'N/A'))
    END AS invoice_details,
    
    -- Original debit column
    X.debit, 
    
    -- Original credit column
    X.credit, 
    
    -- New formatted debit in Indian currency format
    FORMAT(X.debit, 2) AS formatted_debit, 

    -- New formatted credit in Indian currency format
    FORMAT(X.credit, 2) AS formatted_credit, 

    X.created, 
    X.voucher_type
FROM (
    -- Subquery for Purchase Vouchers (Debit)
    SELECT 
        purchaseinv2.orderid,
        purchaseinv2.invid AS invoice_details, 
        purchaseinv2.totalamount AS debit, -- Purchases increase liability
        NULL AS credit, 
        purchaseinv2.invdate AS created, 
        'Purchase' AS voucher_type
    FROM 
        purchaseinv2 
    WHERE 
        purchaseinv2.cid = ? 
        AND purchaseinv2.invdate BETWEEN ? AND ?
        
    UNION ALL -- Use UNION ALL for better performance if duplicates are not a concern
    
    -- Subquery for Receipt Vouchers (Credit)
    SELECT 
        NULL AS orderid,
        NULL AS invoice_details, 
        NULL AS debit, 
        paidhistory.amount AS credit, -- Payments reduce liability
        paidhistory.dateofpayment AS created, 
        'Receipt' AS voucher_type
    FROM 
        paidhistory 
    WHERE 
        paidhistory.cid = ? 
        AND paidhistory.dateofpayment BETWEEN ? AND ?
) AS X, (SELECT @serial_number := 0) AS init
ORDER BY X.created ASC";

 $query = $this->db->query($sql, [$cid, $startDate, $endDate, $cid, $startDate, $endDate]);
        $result = $query->getResultArray();


    }   elseif ($u_type == 2) {
        // Complete Ledger (Purchases, Receipts, Sales)
        $sql = "SELECT 
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
        WHEN X.voucher_type IN ('Sales', 'Purchase') THEN CONCAT(X.invoice_details, '+', COALESCE(X.orderid, 'N/A'))
        ELSE X.invoice_details
    END AS invoice_details,
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN X.credit  -- Keep credit as a number for calculation
        WHEN X.voucher_type = 'Sales' THEN X.credit   -- Keep credit as a number for calculation
        WHEN X.voucher_type = 'Purchase' THEN 0    -- No credit for Purchase
        ELSE NULL
    END AS credit,
    CASE 
        WHEN X.voucher_type = 'Purchase' THEN X.debit  -- Keep debit as a number for calculation
        WHEN X.voucher_type = 'Receipt' THEN 0     -- No debit for Receipt
        WHEN X.voucher_type = 'Sales' THEN 0        -- No debit for Sales
        ELSE NULL
    END AS debit,
    X.created,
    X.voucher_type,
    -- Apply formatting for display only
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN FORMAT(X.credit, 2)  -- Format Receipt as credit
        WHEN X.voucher_type = 'Sales' THEN FORMAT(X.credit, 2)   -- Format Sales as credit
        WHEN X.voucher_type = 'Purchase' THEN 0 -- No credit for Purchase
        ELSE NULL
    END AS formatted_credit,
    CASE 
        WHEN X.voucher_type = 'Purchase' THEN FORMAT(X.debit, 2)  -- Format Purchase as debit
        WHEN X.voucher_type = 'Receipt' THEN  0  -- No debit for Receipt
        WHEN X.voucher_type = 'Sales' THEN 0        -- No debit for Sales
        ELSE NULL
    END AS formatted_debit
FROM (
    -- Get Purchase records (Purchase is a debit)
    SELECT 
        purchaseinv2.orderid,
        purchaseinv2.invid AS invoice_details,
        NULL AS credit,
        purchaseinv2.totalamount AS debit,  -- Purchase is a debit
        purchaseinv2.invdate AS created,
        'Purchase' AS voucher_type
    FROM 
        purchaseinv2
    WHERE 
        purchaseinv2.cid = ?
        AND purchaseinv2.invdate BETWEEN ? AND ?

    UNION 

    SELECT 
        NULL AS orderid,
        NULL AS invoice_details,
        paidhistory.amount AS credit,  -- Receipt is a credit
        NULL AS debit,
        paidhistory.dateofpayment AS created,
        'Receipt' AS voucher_type
    FROM 
        paidhistory
    WHERE
        paidhistory.cid = ?
        AND paidhistory.dateofpayment BETWEEN ? AND ?

    UNION 
    
    
    SELECT 
        invtest2.orderid,
        invtest2.invid AS invoice_details,  
        invtest2.totalamount AS credit,  -- Sales is a credit
        NULL AS debit,  -- Sales does not have a debit value
        invtest2.created,
        'Sales' AS voucher_type
    FROM 
        invtest2
    WHERE 
        invtest2.cid = ?
        AND invtest2.created BETWEEN ? AND ?
) AS X, (SELECT @serial_number := 0) AS init
ORDER BY X.created ASC";


$query = $this->db->query($sql, [$cid, $startDate, $endDate, $cid, $startDate, $endDate,$cid, $startDate, $endDate]);
        $result = $query->getResultArray();
        //echo $result;
}

       

    if (empty($result2) || empty($result)) {
    return $this->response->setJSON([
        'error' => 'No balances found',
        'query' => $this->db->getLastQuery(), // Check generated SQL query
        'cid' => $cid
    ]);
}

if (!$query || !$query2) {
    return $this->response->setJSON(['error' => $this->db->error()]);
}

       
     return $this->response->setJSON([
            'ledger' => $result,  // Ledger transactions
            'balances' => $result2, // Yearly balances
            'fy'=>$fy
        ]);
    

    //return $this->response->setJSON(['error' => 'Invalid user type']);
}







    public function home()
{
     $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}      
    return view('layout/manage-account');
}



public function getledger($cid)
{
    $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}
    // Load the Account model
    $accountModel = new Account_model();

    // Set the default financial year range
    if (date('m') > 3) {
        $defaultYear = date('Y') . "-" . (date('Y') + 1);
    } else {
        $defaultYear = (date('Y') - 1) . "-" . date('Y');
    }
    $startyear = substr($defaultYear, 0, 4);
    //echo $startyear;

    $endyear = substr($defaultYear, 5, 8);
    //echo $endyear;


    // Fetch ledger details based on cid and the financial year range
    $ledgerDetails = $accountModel->getLedgerDetails($cid, $startyear, $endyear);

    //print_r($ledgerDetails);

    $prev=0;

  if (!isset($ledgerDetails['ledger']) || empty($ledgerDetails['ledger'])) { 
    // Try fetching last year's ledger data
    $ledgerDetails = $accountModel->getLedgerDetails($cid, $startyear - 1, $endyear - 1);

    $prev=1;
    
    // If still empty, assign a default structure to avoid errors
    if (!isset($ledgerDetails['ledger']) || empty($ledgerDetails['ledger'])) {
        $ledgerDetails['ledger'] = [];  // Assign an empty array instead of null
    }
}



//     echo '<pre>';
// print_r($ledgerDetails);
// echo '</pre>';
// exit;

    // Fetch additional account and client details
    $accountInfo = $accountModel->getAccountInfo($cid); // Assuming this fetches u_type, opening balance, client name, and address

    //print_r($accountInfo);

    $u_type = $accountInfo->u_type;
//echo $u_type; // Output the value

    // Check if accountInfo was successfully retrieved
    // if (!$accountInfo || !$ledgerDetails) {
    //     throw new \CodeIgniter\Exceptions\PageNotFoundException("Account or client information not found");
    // }




    if (date('m') > 3) {
            $year = date('y') . "-" . (date('y') + 1);
        } else {
            $year = (date('y') - 1) . "-" . date('y');
        }

    $date = date('Y-m-d');
    $db = \Config\Database::connect();


        // SQL query to get the next invoice ID
        $datalogger = "
            SELECT CONCAT_WS('/', '$year', COALESCE(LPAD(
                CASE 
                    WHEN '$date' >= DATE_FORMAT('$date','%Y-04-01') 
                    THEN SUM(created >= DATE_FORMAT('$date','%Y-04-01')) 
                    ELSE SUM(created BETWEEN DATE_FORMAT('$date','%Y-04-01') - INTERVAL 1 YEAR AND DATE_FORMAT('$date','%Y-04-01'))
                END + 1, 4, 0)
            , LPAD(1, 4, 0))) AS pay_id 
            FROM paidhistory";

         //echo $datalogger;   


        // Execute the query
        $stmt = $db->query($datalogger);
        $row = $stmt->getRow();

        // Determine the invoice number
        if ($row) {
            $value2 = $row->pay_id;

            // Separate numeric part
            $value2 = substr($value2, 6, 4);

            // Concatenate incremented value
            $value2 = "\n T/" . $year . "/" . sprintf('%04s', $value2);
            $value = $value2;
        } else {
            // No records found, start from 0001
            $value = "T/" . $year . "/0001";
        }


 

$sql3 = "SELECT financial_year FROM (
            SELECT CASE 
                WHEN MONTH(created) >= 4 
                THEN CONCAT(YEAR(created), '-', YEAR(created) + 1) 
                ELSE CONCAT(YEAR(created) - 1, '-', YEAR(created)) 
            END AS financial_year 
            FROM invtest2 
            WHERE cid = ?

            UNION

            SELECT CASE 
                WHEN MONTH(STR_TO_DATE(invdate, '%Y-%m-%d')) >= 4 
                THEN CONCAT(YEAR(STR_TO_DATE(invdate, '%Y-%m-%d')), '-', YEAR(STR_TO_DATE(invdate, '%Y-%m-%d')) + 1) 
                ELSE CONCAT(YEAR(STR_TO_DATE(invdate, '%Y-%m-%d')) - 1, '-', YEAR(STR_TO_DATE(invdate, '%Y-%m-%d'))) 
            END AS financial_year 
            FROM purchaseinv2 
            WHERE cid = ?
        ) AS combined_years
        GROUP BY financial_year 
        ORDER BY financial_year DESC";

$query3 = $this->db->query($sql3, [$cid, $cid]);
$result3 = $query3->getResultArray();



//print_r($result3);

if (empty($result3) || !isset($result3[0]['financial_year'])) { 
    // Try fetching last year's ledger data
   
   //$result3= array('' => , );
    $result3 = [
         ['financial_year' => $startyear.'-'.$endyear], // Concatenation method
        //    ['financial_year' => ($startyear - 1) . '-' . ($endyear - 1)], 
    ];

}



//print_r($result3);

$sql2="SELECT 
    a.cid, 
    c.u_type, 
    a.opening_bal AS opening_balance,
    COALESCE(i.total_credit, 0) AS total_credit,
    COALESCE(p.total_debit, 0) AS total_debit,
    a.opening_bal + COALESCE(i.total_credit, 0) - COALESCE(p.total_debit, 0) AS closing_balance,
    CASE 
        WHEN EXTRACT(MONTH FROM COALESCE(i.latest_date, p.latest_date)) >= 4 THEN 
            CONCAT(EXTRACT(YEAR FROM COALESCE(i.latest_date, p.latest_date)), '-', EXTRACT(YEAR FROM COALESCE(i.latest_date, p.latest_date)) + 1)
        ELSE 
            CONCAT(EXTRACT(YEAR FROM COALESCE(i.latest_date, p.latest_date)) - 1, '-', EXTRACT(YEAR FROM COALESCE(i.latest_date, p.latest_date)))
    END AS fy
FROM 
    account a
JOIN 
    client c ON a.cid = c.cid 
LEFT JOIN 
    (SELECT cid, SUM(totalamount) AS total_credit, MAX(created) AS latest_date 
     FROM (
         SELECT cid, totalamount, created FROM invtest2 
         WHERE cid IN (?) -- Only filter relevant cid
         UNION ALL
         SELECT cid, totalamount, created FROM purchaseinv2 
         WHERE cid IN (?) -- Only filter relevant cid
     ) AS combined_invoices 
     GROUP BY cid
    ) i 
    ON a.cid = i.cid
LEFT JOIN 
    (SELECT cid, SUM(amount) AS total_debit, MAX(dateofpayment) AS latest_date 
     FROM paidhistory 
     WHERE cid IN (?) -- Only filter relevant cid
     GROUP BY cid
    ) p 
    ON a.cid = p.cid
WHERE 
    c.u_type IN (?) AND c.cid IN (?) 
    AND (
        (COALESCE(i.latest_date, p.latest_date) BETWEEN ? AND ?)
    )
GROUP BY 
    a.cid, a.opening_bal, c.u_type, fy
ORDER BY fy";
    //echo $u_type;
  
 if ($prev == 0) {
    $query2 = $this->db->query($sql2, [$cid, $cid, $cid, $u_type, $cid, ($startyear).'-04-01', ($endyear).'-03-31']);
} else {
    $query2 = $this->db->query($sql2, [$cid, $cid, $cid, $u_type, $cid, ($startyear - 1).'-04-01', ($endyear - 1).'-03-31']);
}

    $result2 = $query2->getResultArray();





    //print_r($result2);   

    //$lastRow = end($result2);

    // Access the 'opening_balance' of the last row
   //$lastOpeningBalance = $lastRow['opening_balance'];

   // if($lastOpeningBalance == null)
   // {
   //  $lastOpeningBalance=0;
   // }
   if (!empty($result2)) {
    $lastRow = end($result2);
    $lastOpeningBalance = $lastRow['opening_balance'] ?? 0;
} else {
    $lastOpeningBalance = 0;  // Set a default value if no data is found
}


  // echo $lastOpeningBalance;


    return view('info layout/getledger', [
     'cid'=> $cid,   
    'u_type' => $ledgerDetails['u_type'],
    'ledgerDetails' => $ledgerDetails['ledger']??[],  // Pass only the ledger array
    'accountInfo' => $accountInfo ?? [],
    'pay_id'=> $value,
    'fy'=> $result3 ?? [],
   'dops'=>$lastOpeningBalance ?? 0
]);

}


// public function reportdrcr()
// {
//     return view('report/report_dcrcr');
// }

public function demo(){
    $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}

    $cddata=new Acctype_model();

    $cz=$cddata->getAccountTypeDetails();

     $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($cz),
        "iTotalDisplayRecords" => count($cz),
        "aaData" => $cz
    ];

    // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }

    // Prepare data for view
    $data = [
        'results' => json_encode($results)
    ];


    return view('layout/addview',$data);
}


public function get_next_id()
{
    try {
        // Your logic to get the next ID
        $next_id = $this->crudModel->get_last_cid(); // Adjust this line based on your logic
        return $this->response->setJSON(['next_id' => $next_id]);
    } catch (Exception $e) {
        log_message('error', 'Failed to get next ID: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to fetch next ID.']);
    }
}


public function manageaccounts()
{
    $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}

    $accountModel = new \App\Models\Account_Model();

    // Fetch all records using the custom method
    $records = $accountModel->getAccountDetails();


    $last_cid = $this->crudModel->get_last_cid();
    $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;

    // Format the data for DataTables
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($records),
        "iTotalDisplayRecords" => count($records),
        "aaData" => $records
    ];

    // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }

    // Prepare data for view
    $data = [
        'next_cid' => $next_cid,
        'results' => json_encode($results)
    ];

    return view('layout/manage-account', $data);
}


public function getclient()
{
    $this->crudModel2 = new Client_model();
    $categoryName = $this->request->getGet('category_name');
    $results = [];

    // Get cids from the account table
    $accountedClientIds = $this->crudModel->select('cid')->get()->getResultArray();
    $excludedIds = array_column($accountedClientIds, 'cid');

    // Build query
    if ($categoryName) {
        // Use LIKE query with wildcards and exclude `cid` in the `account` table
        $clients = $this->crudModel2
                        ->whereNotIn('cid', $excludedIds)
                        ->like('c_name', $categoryName, 'both') // Match partial strings in `c_name`
                        ->findAll();
    } else {
        // If no category name is provided, retrieve all clients excluding those in `account`
        $clients = $this->crudModel2
                        ->whereNotIn('cid', $excludedIds)
                        ->findAll();
    }

    // Format the results for Select2
    foreach ($clients as $client) {
        $results[] = [
            'id' => $client['cid'],
            'text' => $client['c_name'],
            'c_add' => $client['c_add']
        ];
    }

    return $this->response->setJSON($results);
}


   


public function insert() {

    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

            $last_cid = $this->crudModel->get_last_cid();
            $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;

        
              //$this->crudModel->set_auto_increment();
                    
            $this->crudModel2 = new Client_model();

            $cid=$this->request->getPost('ctype');

            $client = $this->crudModel2->where('cid', $cid)->first(); // Assuming `cid` is the column name

            // Check if the client record was found and retrieve `u_type`
        if ($client) {
            $utype = $client['u_type']; // Extract `u_type` value
        } 

        $created = $this->request->getPost('created');

            // Convert the input date to DateTime object
            $date = new \DateTime($created);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');

            // Prepare data for insertion
            $data = [
                'aid'      => $this->request->getPost('aid'),
                'cid'   => $this->request->getPost('ctype'),
                'opening_bal'   => $this->request->getPost('opbal'),
                                
                'acc_type'   => $utype, // Ensure this is included
                'created'  => $formattedDate,
            ];
            //print_r($this->request->getPost());

            //print_r($data);   
            // Attempt to save the record
            $response = $this->crudModel->saverecords($data);

            //echo $this->crudModel->setQuery($response);


            //print_r($response);

            $lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query


            if ($response) {

                
            
                // Return success response in JSON format
                return $this->response->setJSON([
                    'res' => 'success',
                    'message' => 'Records saved successfully.',
                    'query' => (string) $lastQuery, // Include the last query in the response

                //'redirect' => base_url('/client/manageclients'), 
                ]);
                
            } else {
                $error = $this->db->error();

                // Return error response if insertion fails
                return $this->response->setJSON([
                    'res' => 'error',
                    //'message' => 'Insert failed.',
                    'message' => $error['message'],
            'code' => $error['code'],
                ]);
            }
       
    } else {
        // If not a valid request, return an error
        return $this->response->setJSON([
            'res' => 'error',
            'message' => 'Invalid Request'
        ]);
    }
}



public function delete(int $id)
{
    // Log the ID to confirm it's correct
    log_message('debug', 'Deleting record with ID: ' . $id);

    // Ensure the request is AJAX
    if ($this->request->isAJAX()) {

          // Check if deleterecord method exists in the model
        if (!method_exists($this->crudModel, 'deleterecord')) {
            return $this->response->setJSON([
                'res' => 'error',
                'message' => 'Delete method not found.'
            ]);
        }
        // Delete the record from the database
        $delete = $this->crudModel->deleterecord($id);

        if ($delete) {
            return $this->response->setJSON([
                'res' => 'success',
                'message' => 'Record deleted successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'res' => 'error',
                'message' => 'Failed to delete the record.'
            ]);
        }
    }

    return $this->response->setStatusCode(400)->setJSON([
        'res' => 'error',
        'message' => 'Invalid request.'
    ]);
}


// public function delete() {
//     $del_id = $this->request->getGet('del_id');
    
//     if ($this->crudModel->deleteRecord($del_id)) {
//         return $this->response->setJSON(['res' => 'success']);
//     } else {
//         return $this->response->setJSON(['res' => 'error']);
//     }
// }



    public function edit()
   {
        if ($this->request->getMethod() === 'get' || $this->request->isAJAX()) {  // Corrected to use $this->request->isAJAX()

        $edit_id = $this->request->getGet('edit_id');  // Corrected to use $this->request->getGet()

        if ($post = $this->crudModel->single_entry($edit_id)) {
            $data = array('res' => "success", 'post' => $post);
        } else {
            $data = array('res' => "error", 'message' => "Failed to fetch data");
        }

        return $this->response->setJSON($data);  // Return JSON response
    } else {
        return $this->response->setJSON([
            'res' => 'error',
            'message' => 'No direct script access allowed'
        ]);
    }
}


    // Example controller method (updaterecord)
public function update()
{
    $openingBal = $this->request->getPost('opening_bal');
    $cid = $this->request->getPost('cid');
    $aid = $this->request->getPost('aid');

        // echo "\n".$openingBal;
        // echo "\n".$cid;
        // echo "\n".$aid;

  // Load the model
    $accountModel = new Account_model();

    // Data to update
    $data = [
        'opening_bal' => $openingBal,
        'cid' => $cid,
    ];

    // Call the model's updaterecord method
    $update = $accountModel->updaterecord($data, $aid);

    if ($update) {
        return $this->response->setJSON(['res' => 'success', 'message' => 'Record updated successfully!']);
    } else {
        return $this->response->setJSON(['res' => 'error', 'message' => 'Failed to update record.']);
    }
}



}
?>