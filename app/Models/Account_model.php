<?php

namespace App\Models;

use CodeIgniter\Model;

class Account_model extends Model
{
    protected $table = 'account'; // Specify your table name
    protected $primaryKey = 'aid'; // Specify your primary key column

    

    protected $allowedFields = ['aid','cid', 'acc_type', 'opening_bal','created']; // Specify allowed fields

    // Optionally, you can define validation rules
    // protected $validationRules = [
    //     'name'  => 'required|string',
    //     'email' => 'required|valid_email',
    //     'city'  => 'required|string',
    // ];

    // // Optionally, you can define custom validation messages
    // protected $validationMessages = [
    //     'name' => [
    //         'required' => 'The name field is required.',
    //         'string'   => 'The name field must be a string.',
    //     ],
    //     'email' => [
    //         'required'    => 'The email field is required.',
    //         'valid_email' => 'The email address is not valid.',
    //     ],
    //     'city' => [
    //         'required' => 'The city field is required.',
    //         'string'   => 'The city field must be a string.',
    //     ],
    // ];

    /**
     * Insert a record into the database
     *
     * @param array $data - Data to be inserted
     * @return boolean - Success or failure of the operation
     */

    // public function __construct() {
    //     parent::__construct();
    //     $this->load->database(); // Load the database
    // }

    
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

    /**
     * Update a specific record by primary key
     *
     * @param int $id - Primary key of the record to be updated
     * @param array $data - Data to be updated
     * @return boolean - Success or failure of the update operation
     */

    // public function updaterecord(int $id, array $data)
    // {
    //     return $this->update($id, $data); // Update data in the table
    // }
// In your model
// public function updaterecord(int $id, array $data)
// {
//     return $this->db->table('account')->update($data, ['aid' => $id]);
// }
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


// public function getLedgerDetails($cid, $startyear, $endyear)
// {
//     $client = $this->db->table('client')
//                        ->select('u_type')
//                        ->where('cid', $cid)
//                        ->get()
//                        ->getRow();

//     if (!$client) {
//         return ['u_type' => null, 'ledger' => []]; // Return empty data if client not found
//     }

//     // Check u_type to decide which query to execute
//     $u_type = $client->u_type;

//     if ($u_type == 0) {
//         $sql = "
//             SELECT 
//                 CASE 
//                     WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
//                     ELSE X.`invoice_details`
//                 END AS `invoice_details`,
//                 X.credit, 
//                 X.debit, 
//                 X.created, 
//                 X.voucher_type
//             FROM (
//                 SELECT 
//                     invtest2.invid AS `invoice_details`, 
//                     invtest2.totalamount AS `debit`, 
//                     NULL AS `credit`, 
//                     invtest2.created, 
//                     'Sales' AS `voucher_type`
//                 FROM 
//                     invtest2 
//                 WHERE 
//                     invtest2.cid = ? 
//                     AND invtest2.created BETWEEN ? AND ? 
                    
//                 UNION 
                
//                 SELECT 
//                     NULL AS `invoice_details`, 
//                     NULL AS `debit`, 
//                     paidhistory.amount AS `credit`, 
//                     paidhistory.dateofpayment AS `created`, 
//                     'Receipt' AS `voucher_type`
//                 FROM 
//                     paidhistory 
//                 WHERE 
//                     paidhistory.cid = ? 
//                     AND paidhistory.dateofpayment BETWEEN ? AND ? 
//             ) AS X, (SELECT @serial_number := 0) AS init
//             ORDER BY 
//                 X.created ASC";
//     } elseif ($u_type == 1) {
//         $sql = "
//             SELECT 
//                 CASE 
//                     WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
//                     ELSE X.`invoice_details`
//                 END AS `invoice_details`,
//                 X.credit, 
//                 X.debit, 
//                 X.created, 
//                 X.voucher_type
//             FROM (
//                 SELECT 
//                     purchaseinv2.invid AS `invoice_details`, 
//                     purchaseinv2.totalamount AS `credit`, 
//                     NULL AS `debit`, 
//                     purchaseinv2.invdate AS `created`, 
//                     'Purchase' AS `voucher_type`
//                 FROM 
//                     purchaseinv2 
//                 WHERE 
//                     purchaseinv2.cid = ? 
//                     AND purchaseinv2.invdate BETWEEN ? AND ? 
                    
//                 UNION 
                
//                 SELECT 
//                     NULL AS `invoice_details`, 
//                     NULL AS `credit`, 
//                     paidhistory.amount AS `debit`, 
//                     paidhistory.dateofpayment AS `created`, 
//                     'Receipt' AS `voucher_type`
//                 FROM 
//                     paidhistory 
//                 WHERE 
//                     paidhistory.cid = ? 
//                     AND paidhistory.dateofpayment BETWEEN ? AND ? 
//             ) AS X, (SELECT @serial_number := 0) AS init
//             ORDER BY 
//                 X.created ASC";
//     } elseif ($u_type == 2) {
//         $sql = "
//             SELECT 
//                 CASE 
//                     WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
//                     ELSE X.invoice_details
//                 END AS invoice_details,
//                 X.credit,
//                 X.debit,
//                 X.created,
//                 X.voucher_type
//             FROM (
//                 SELECT 
//                     purchaseinv2.invid AS invoice_details,
//                     purchaseinv2.totalamount AS credit,
//                     NULL AS debit,
//                     purchaseinv2.invdate AS created,
//                     'Purchase' AS voucher_type
//                 FROM 
//                     purchaseinv2
//                 WHERE 
//                     purchaseinv2.cid = ?
//                     AND purchaseinv2.invdate BETWEEN ? AND ?

//                 UNION 

//                 SELECT 
//                     NULL AS invoice_details,
//                     NULL AS credit,
//                     paidhistory.amount AS debit,
//                     paidhistory.dateofpayment AS created,
//                     'Receipt' AS voucher_type
//                 FROM 
//                     paidhistory
//                 WHERE
//                     paidhistory.cid = ?
//                     AND paidhistory.dateofpayment BETWEEN ? AND ?

//                 UNION 
                
//                 SELECT 
//                     invtest2.invid AS invoice_details,  
//                     NULL AS credit,
//                     invtest2.totalamount AS debit,
//                     invtest2.created,
//                     'Sales' AS voucher_type
//                 FROM 
//                     invtest2
//                 WHERE 
//                     invtest2.cid = ?
//                     AND invtest2.created BETWEEN ? AND ?

//             ) AS X, (SELECT @serial_number := 0) AS init
//             ORDER BY X.created ASC";
//     } else {
//         return ['u_type' => $u_type, 'ledger' => []];
//     }

//     $ledger = $this->db->query($sql, [
//         $cid, 
//         "$startyear-04-01", 
//         "$endyear-03-31", 
//         $cid, 
//         "$startyear-04-01", 
//         "$endyear-03-31",
//         $cid,
//         "$startyear-04-01", 
//         "$endyear-03-31"
//     ])->getResult();

//     return ['u_type' => $u_type, 'ledger' => $ledger];
// }
public function getLedgerDetails($cid, $startyear, $endyear)
{
    $client = $this->db->table('client')
                       ->select('u_type')
                       ->where('cid', $cid)
                       ->get()
                       ->getRow();

    if (!$client) {
        return ['u_type' => null, 'ledger' => []];
    }

    $u_type = $client->u_type;

    // Define start and end dates once
    $start_date = "$startyear-04-01";
    $end_date = "$endyear-03-31";
    $parameters = [$cid, $start_date, $end_date, $cid, $start_date, $end_date];

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


    } elseif ($u_type == 2) {
        // Complete Ledger (Purchases, Receipts, Sales)
        $sql = "
          SELECT 
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN (@serial_number := @serial_number + 1)
        WHEN X.voucher_type IN ('Sales', 'Purchase') THEN CONCAT(X.invoice_details, '+', COALESCE(X.orderid, 'N/A'))
        ELSE X.invoice_details
    END AS invoice_details,
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN X.credit  -- Keep credit as a number for calculation
        WHEN X.voucher_type = 'Sales' THEN X.credit   -- Keep credit as a number for calculation
        WHEN X.voucher_type = 'Purchase' THEN NULL    -- No credit for Purchase
        ELSE NULL
    END AS credit,
    CASE 
        WHEN X.voucher_type = 'Purchase' THEN X.debit  -- Keep debit as a number for calculation
        WHEN X.voucher_type = 'Receipt' THEN NULL      -- No debit for Receipt
        WHEN X.voucher_type = 'Sales' THEN NULL        -- No debit for Sales
        ELSE NULL
    END AS debit,
    X.created,
    X.voucher_type,
    -- Apply formatting for display only
    CASE 
        WHEN X.voucher_type = 'Receipt' THEN FORMAT(X.credit, 2)  -- Format Receipt as credit
        WHEN X.voucher_type = 'Sales' THEN FORMAT(X.credit, 2)   -- Format Sales as credit
        WHEN X.voucher_type = 'Purchase' THEN NULL  -- No credit for Purchase
        ELSE NULL
    END AS formatted_credit,
    CASE 
        WHEN X.voucher_type = 'Purchase' THEN FORMAT(X.debit, 2)  -- Format Purchase as debit
        WHEN X.voucher_type = 'Receipt' THEN NULL   -- No debit for Receipt
        WHEN X.voucher_type = 'Sales' THEN NULL        -- No debit for Sales
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

    -- Get Receipt records (Receipt is a credit)
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
    
    -- Get Sales records (Sales is a credit)
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


        // Add extra bindings for u_type 2 as it has three UNIONs
        $parameters = array_merge($parameters, [$cid, $start_date, $end_date]);
    } else {
        return ['u_type' => $u_type, 'ledger' => []];
    }



    $ledger = $this->db->query($sql, $parameters)->getResult();

    return ['u_type' => $u_type, 'ledger' => $ledger];
}

//     public function deleterecord(int $id)
// {
//     // Use CodeIgniter's built-in delete method
//     return $this->db->table('client')->delete(['cid' => $id]);
// }

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
