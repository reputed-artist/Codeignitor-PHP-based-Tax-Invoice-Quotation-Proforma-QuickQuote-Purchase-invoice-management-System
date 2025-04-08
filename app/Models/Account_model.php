<?php

namespace App\Models;

use CodeIgniter\Model;

class Account_model extends Model
{
    protected $table = 'account'; // Specify your table name
    protected $primaryKey = 'aid'; // Specify your primary key column

    

    protected $allowedFields = ['aid','cid', 'acc_type', 'opening_bal','created']; // Specify allowed fields



public function getFinancialYears($cid)
    {
        $query = $this->db->query("
            SELECT CASE 
                WHEN MONTH(created) >= 4 
                THEN CONCAT(YEAR(created), '-', YEAR(created) + 1) 
                ELSE CONCAT(YEAR(created) - 1, '-', YEAR(created)) 
            END AS financial_year 
            FROM invtest2 where cid=$cid
            GROUP BY financial_year 
            ORDER BY financial_year DESC limit 5
        ");

        return $query->getResultArray();
    }

public function getLedgerByFY($fy, $cid)
{
    // Extract financial year start and end dates
    list($startYear, $endYear) = explode("-", $fy);
    $startDate = "$startYear-04-01"; // Start from April 1st
    $endDate = "$endYear-03-31"; // End on March 31st

    return $this->db->table('client')
        ->select('client.c_name, account.aid, account.opening_bal, paidhistory.dateofpayment, paidhistory.amount, paidhistory.bank, paidhistory.purpose')
        ->join('account', 'account.cid = client.cid', 'left') // Ensure account data is included
        ->join('paidhistory', 'paidhistory.cid = client.cid AND (paidhistory.dateofpayment BETWEEN "'.$startDate.'" AND "'.$endDate.'")', 'left') // Join payment history if available
        ->where('client.cid', $cid) // Fetch only selected client
        ->orderBy('client.cid', 'ASC')
        ->get()
        ->getResultArray();
}


    
    public function saverecords(array $data)
    {

        //echo "model".$this->insert($data);
        return $this->insert($data); // Insert data into the table

    }

public function set_auto_increment() {
    // Get the last cid
    $lastCid = $this->get_last_cid(); 
    $newAutoIncrementValue = $lastCid ? $lastCid + 1 : 1; // Set to 1 if no records

    // Prepare and execute the SQL to set auto-increment
    $sql = "ALTER TABLE `client` AUTO_INCREMENT = ?";
    $this->db->query($sql, [$newAutoIncrementValue]);

    return $this->db->affectedRows() > 0; // Check if the operation was successful
}

    
// Inside your Account model
public function updaterecord($data, $aid)
{
    return $this->db->table('account')
                    ->where('aid', $aid)
                    ->update($data);
}

    
//     // In AccountModel.php
// public function getLedgerById($aid)
// {
//     return $this->db->table('ledger') // Replace 'ledger' with the correct table name
//                     ->where('aid', $aid)
//                     ->get()
//                     ->getResultArray();
// }

// In Account_model

public function getCidFromAid($aid)
{
    return $this->db->table('account')
                    ->select('cid')
                    ->where('aid', $aid)
                    ->get()
                    ->getRowArray()['cid'];
}

public function getAccountInfo($cid)
{
    return $this->db->table('account')
                    ->select('account.opening_bal, client.c_name, SUBSTRING_INDEX(client.c_add, \',\', -1) AS location, client.u_type')
                    ->join('client', 'client.cid = account.cid')
                    ->where('account.cid', $cid)
                    ->get()
                    ->getRow(); // Returns a single row with opening balance, name, and address
}



public function getLedgerDetails($cid, $startyear, $endyear)
{
    $client = $this->db->table('client')
                       ->select('u_type')
                       ->where('cid', $cid)
                       ->get()
                       ->getRow();

    if (!$cid || !$startyear || !$endyear) {
    die ("Missing parameters: cid=$cid, startyear=$startyear, endyear=$endyear");
}
                   

    if (!$client) {
        return ['u_type' => null, 'ledger' => []];
    }

    $u_type = (int)$client->u_type;

    if (!isset($client->u_type)) {
    die("u_type not found for cid: $cid");
}

    //echo $u_type;

    // Define start and end dates once
    $start_date = "$startyear-04-01";
    $end_date = "$endyear-03-31";
    $parameters = [$cid, $start_date, $end_date, $cid, $start_date, $end_date];
    //$parameters = [$cid, $start_date, $end_date, $cid, $start_date, $end_date, $cid, $start_date, $end_date];

    if ($u_type == 0) {
        // Sales and Receipts Ledger
        $sql = "
SELECT 
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
        ELSE CONCAT(X.invoice_details, '+', COALESCE(X.orderid, 'N/A'))  
    END AS invoice_details,
    
    -- Original credit and debit fields
    X.credit, 
    X.debit, 

    -- New formatted credit and debit fields
    FORMAT(X.credit, 2) AS formatted_credit, 
    FORMAT(X.debit, 2) AS formatted_debit, 
    
    X.created, 
    X.voucher_type
FROM (
    -- Subquery for Sales Vouchers (Credit)
    SELECT 
        invtest2.orderid,
        invtest2.invid AS invoice_details, 
        NULL AS debit,                       -- Set debit to NULL for Sales
        invtest2.totalamount AS credit,      -- Assign totalamount to credit for Sales
        invtest2.created, 
        'Sales' AS voucher_type
    FROM 
        invtest2 
    WHERE 
        invtest2.cid = ?
        AND invtest2.created BETWEEN ? AND ?
        
    UNION
    
    -- Subquery for Receipt Vouchers (Debit)
    SELECT 
        NULL AS orderid,                     -- Add orderid as NULL
        NULL AS invoice_details,             -- Add invoice_details as NULL for Receipts
        paidhistory.amount AS debit,         -- Assign amount to debit for Receipts
        NULL AS credit,                      -- Set credit to NULL for Receipts
        paidhistory.dateofpayment AS created, 
        'Receipt' AS voucher_type
    FROM 
        paidhistory 
    WHERE 
        paidhistory.cid = ?
        AND paidhistory.dateofpayment BETWEEN ? AND ?
) AS X, (SELECT @serial_number := 0) AS init
ORDER BY X.created ASC";

    } elseif ($u_type == 1) {

$sql="SELECT  
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
        ELSE COALESCE(CONCAT(X.invoice_details, '+', X.orderid), 'N/A')
    END AS invoice_details,
    
    -- Original debit column
    X.debit, 
    
    -- Original credit column
    X.credit, 
    
    -- New formatted debit in Indian currency format
    FORMAT(COALESCE(X.debit, 0), 2) AS formatted_debit, 

    -- New formatted credit in Indian currency format
    FORMAT(COALESCE(X.credit, 0), 2) AS formatted_credit, 

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
        COALESCE(paidhistory.amount, 0) AS credit, -- Handle NULL amounts
        paidhistory.dateofpayment AS created, 
        'Receipt' AS voucher_type
    FROM 
        paidhistory 
    WHERE 
        paidhistory.cid = ? 
        AND (paidhistory.dateofpayment BETWEEN ? AND ? OR paidhistory.dateofpayment IS NULL)
) AS X, (SELECT @serial_number := 0) AS init
ORDER BY X.created ASC";

    } elseif ($u_type == 2) {
       

// $sql="

// SELECT 
//     CASE 
//         WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
//         WHEN X.voucher_type IN ('Sales', 'Purchase') THEN 
//             CONCAT(COALESCE(X.invoice_details, 'N/A'), '+', COALESCE(X.orderid, 'N/A'))
//         ELSE X.invoice_details
//     END AS invoice_details,
    
//     -- Credit/Debit Assignments
//     CASE 
//         WHEN X.voucher_type = 'Receipt' THEN X.credit
//         WHEN X.voucher_type = 'Sales' THEN X.credit
//         WHEN X.voucher_type = 'Purchase' THEN 0
//         ELSE NULL
//     END AS credit,
    
//     CASE 
//         WHEN X.voucher_type = 'Purchase' THEN X.debit
//         WHEN X.voucher_type = 'Receipt' THEN 0
//         WHEN X.voucher_type = 'Sales' THEN 0
//         ELSE NULL
//     END AS debit,
    
//     DATE_FORMAT(X.created, '%Y-%m-%d') AS created, 
//     X.voucher_type,

//     -- Apply Formatting for Display
//     CASE 
//         WHEN X.voucher_type = 'Receipt' THEN FORMAT(CAST(X.credit AS DECIMAL(10,2)), 2)
//         WHEN X.voucher_type = 'Sales' THEN FORMAT(CAST(X.credit AS DECIMAL(10,2)), 2)
//         ELSE NULL
//     END AS formatted_credit,

//     CASE 
//         WHEN X.voucher_type = 'Purchase' THEN FORMAT(CAST(X.debit AS DECIMAL(10,2)), 2)
//         ELSE NULL
//     END AS formatted_debit

// FROM (
//     -- Purchases (Debit)
//     SELECT 
//         p2.orderid,
//         p2.invid AS invoice_details,
//         NULL AS credit,
//         p2.totalamount AS debit,  
//         p2.invdate AS created,
//         'Purchase' AS voucher_type
//     FROM purchaseinv2 p2
//     WHERE p2.cid = ?
//     AND p2.invdate BETWEEN ? AND ?

//     UNION ALL 

//     -- Sales (Credit) 
//     SELECT 
//         i.orderid,
//         i.invid AS invoice_details,  
//         i.totalamount AS credit,  
//         NULL AS debit,  
//         i.created,
//         'Sales' AS voucher_type
//     FROM invtest2 i
//     WHERE i.cid = ?
//     AND i.created BETWEEN ? AND ?

//     UNION ALL 

//     -- Receipts (Credit) (Use LEFT JOIN to avoid failures when empty)
//     SELECT 
//         NULL AS orderid,
//         NULL AS invoice_details,
//         ph.amount AS credit,  
//         NULL AS debit,
//         ph.dateofpayment AS created,
//         'Receipt' AS voucher_type
//     FROM paidhistory ph
//     WHERE ph.cid = ?
//     AND ph.dateofpayment BETWEEN ? AND ?

//     UNION ALL 

//     -- Fallback row when all tables are empty
//     SELECT 
//         NULL AS orderid,
//         'No Transactions' AS invoice_details,
//         NULL AS credit,
//         NULL AS debit,
//         NOW() AS created,
//         'Info' AS voucher_type
//     WHERE NOT EXISTS (
//         SELECT 1 FROM purchaseinv2 WHERE cid = ? AND invdate BETWEEN ? AND ?
//         UNION ALL
//         SELECT 1 FROM invtest2 WHERE cid = ? AND created BETWEEN ? AND ?
//         UNION ALL
//         SELECT 1 FROM paidhistory WHERE cid = ? AND dateofpayment BETWEEN ? AND ?
//     )

// ) AS X
// ORDER BY X.created ASC";

   $sql="SELECT 
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
        WHEN X.voucher_type IN ('Sales', 'Purchase') THEN CONCAT(X.invoice_details, '+', COALESCE(X.orderid, 'N/A'))
        ELSE X.invoice_details
    END AS invoice_details,
    CASE 
        WHEN X.voucher_type IN ('Receipt', 'Sales') THEN X.credit  
        WHEN X.voucher_type = 'Purchase' THEN 0  
        ELSE NULL
    END AS credit,
    CASE 
        WHEN X.voucher_type = 'Purchase' THEN X.debit  
        ELSE 0
    END AS debit,
    X.created,
    X.voucher_type,
    -- Format for display purposes
    CASE 
        WHEN X.voucher_type IN ('Receipt', 'Sales') THEN FORMAT(X.credit, 2)  
        ELSE 0
    END AS formatted_credit,
    CASE 
        WHEN X.voucher_type = 'Purchase' THEN FORMAT(X.debit, 2)  
        ELSE 0
    END AS formatted_debit
FROM (
    -- Purchase Transactions (Debits)
    SELECT 
        purchaseinv2.orderid,
        purchaseinv2.invid AS invoice_details,
        NULL AS credit,
        purchaseinv2.totalamount AS debit,  
        purchaseinv2.invdate AS created,
        'Purchase' AS voucher_type
    FROM purchaseinv2
    WHERE purchaseinv2.cid = ?
        AND purchaseinv2.invdate BETWEEN ? AND ?

    UNION 

    -- Receipt Transactions (Credits)
    SELECT 
        NULL AS orderid,
        NULL AS invoice_details,
        paidhistory.amount AS credit,  
        NULL AS debit,
        paidhistory.dateofpayment AS created,
        'Receipt' AS voucher_type
    FROM paidhistory
    WHERE paidhistory.cid = ?
        AND paidhistory.dateofpayment BETWEEN ? AND ?

    UNION 
    
    -- Sales Transactions (Credits)
    SELECT 
        invtest2.orderid,
        invtest2.invid AS invoice_details,  
        invtest2.totalamount AS credit,  
        NULL AS debit,  
        invtest2.created,
        'Sales' AS voucher_type
    FROM invtest2
    WHERE invtest2.cid = ?
        AND invtest2.created BETWEEN ? AND ?
) AS X, (SELECT @serial_number := 0) AS init
ORDER BY X.created ASC";
  
//$parameters=[];
        // Add extra bindings for u_type 2 as it has three UNIONs
        //$parameters = array_merge($parameters, [$cid, $start_date, $end_date,$cid, $start_date, $end_date,$cid, $start_date, $end_date]);
$parameters = [$cid, $start_date, $end_date, $cid, $start_date, $end_date, $cid, $start_date, $end_date];

    } 
    // else {
    //     return ['u_type' => $u_type, 'ledger' => []];
    // }


try {
    $this->db->query("SET @serial_number = 0");

    $query = $this->db->query($sql, $parameters);
    
    if (!$query) {
        die("SQL Query failed: " . json_encode($this->db->error()));
    }

    $ledger = $query->getResult();
    // echo "<pre>";
    // print_r($ledger);
    // echo "</pre>";
    if (empty($ledger)) {
            return ['u_type' => $u_type, 'ledger' => [], 'message' => 'No transactions found for the selected year.'];
        }
        
return ['u_type' => $u_type, 'ledger' => $ledger];
} catch (\Exception $e) {
    die("SQL Error: " . $e->getMessage());
}
   
}



    public function deleterecord(int $id)
    {
        //return $this->delete(['aid' => $id]); // Update data in the table
        return $this->db->table('account')->delete(['aid' => $id]);

    }


public function single_entry($edit_id)
{
    // Use query builder methods properly
    // return $this->db->table('account')  // Assuming your table is 'table_name'
    //                 ->where('aid', $edit_id)
    //                 ->get()
    //                 ->getRowArray();


         return $this->db->table('account')
                    ->select('account.*, client.c_name')  // Select all fields from your table plus c_name from client
                    ->join('client', 'client.cid = account.cid', 'left') // Adjust table and column names
                    ->where('account.aid', $edit_id) // Change 'id' to the correct column for your table's primary key
                    ->get()
                    ->getRowArray();                
}


    public function get_last_cid()
{
    // Use the builder to access the 'account' table
    $builder = $this->db->table('account');
    
    // Select the maximum 'aid' from the 'account' table
    $builder->selectMax('aid');
    
    // Execute the query
    $query = $builder->get();
    
    // Get the row from the result
    $result = $query->getRow();

    // If there's a result, return the 'aid' as an integer, otherwise return null
    return $result ? (int)$result->aid : null; 
}

    public function getAccountDetails()
    {
        return $this->select('account.aid, client.cid, client.c_name, 
                              SUBSTRING_INDEX(client.c_add, \',\', -1) AS location, 
                              client.mob,client.u_type, account.opening_bal, account.created')
                    ->join('client', 'client.cid = account.cid')

                    ->findAll();
    }
}
