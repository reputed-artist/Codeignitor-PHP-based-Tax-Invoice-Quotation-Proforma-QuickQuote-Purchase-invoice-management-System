<?php

namespace App\Models;

use CodeIgniter\Model;

class Invtest_model2 extends Model
{
    protected $table = 'invtest2'; // Specify your table name
    //protected $primaryKey = 'invid'; // Specify your primary key column

    protected $allowedFields = ['invid','cid', 'orderid', 'totalitems','subtotal','taxrate','taxamount','totalamount','created']; // Specify allowed fields

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
    
    public function saverecords(array $data)
    {
        return $this->insert($data); // Insert data into the table
    }

    /**
     * Update a specific record by primary key
     *
     * @param int $id - Primary key of the record to be updated
     * @param array $data - Data to be updated
     * @return boolean - Success or failure of the update operation
     */
     public function updaterecord($orderid, array $updateData)
    {
        //return $this->update($id, $data); // Update data in the table
        $this->db->table('invtest2')->where('orderid', $orderid)->update($updateData);

    }

     public function deleterecordfromsecond(string $id)
    {
        return $this->db->table('invtest2')->delete(['orderid' => $id]); 
        //return $this->delete(['orderid' => $id]); // Update data in the table
    }
    
    
    public function getFinancialYears()
{
    return $this->db->table('invtest2')  // Specify the table to query from
                    ->select("CASE 
                                WHEN MONTH(created) >= 4 
                                THEN CONCAT(YEAR(created), '-', YEAR(created) + 1) 
                                ELSE CONCAT(YEAR(created) - 1, '-', YEAR(created)) 
                              END AS financial_year")
                    ->groupBy("financial_year")  // Group by financial year
                    ->orderBy('financial_year', 'DESC')
                    ->get()
                    ->getResult(); // Fetches the results as an array of objects
}


public function getinvtest($startyear = null, $endyear = null, $client = null, $product = null, $limit, $offset)
{
    $builder = $this->db->table('invtest')
                        ->select('invtest.orderid, invtest2.invid, invtest.item_name, invtest2.*, SUM(invtest2.totalamount) as total_amount, client.c_name, GROUP_CONCAT(invtest.item_name SEPARATOR ", ") AS item_names, SUBSTRING_INDEX(client.c_add, ",", -1) as location')
                        ->join('invtest2', 'invtest.orderid = invtest2.orderid', 'left')  // Use LEFT JOIN for invtest2
                        ->join('client', 'invtest2.cid = client.cid', 'left');  // Use LEFT JOIN for client
    
    // Apply year filter only if both startyear and endyear are provided
    if ($startyear && $endyear) {
        $builder->where('invtest2.created >=', "$startyear-04-01")
                ->where('invtest2.created <=', "$endyear-03-31");
    } elseif (!$client) { 
        // If no client is selected, apply default year filter (last financial year)
        $currentYear = date('Y');
        $currentMonth = date('m');

        if ($currentMonth > 3) {
            $defaultStartYear = $currentYear; // Current year
            $defaultEndYear = $currentYear + 1; // Next year
        } else {
            $defaultStartYear = $currentYear - 1; // Previous year
            $defaultEndYear = $currentYear; // Current year
        }

        $builder->where('invtest2.created >=', "$defaultStartYear-04-01")
                ->where('invtest2.created <=', "$defaultEndYear-03-31");
    }

    // Apply client filter if provided
    if ($client) {
        $builder->where('invtest2.cid', $client);
    }

    // Apply product filter if provided
    if ($product) {
        $builder->where('invtest.item_name', $product);
    }

    // Group by orderid and client id to avoid duplicate rows
    $builder->groupBy('invtest.orderid, invtest2.cid');

    // Apply limit and offset for pagination
    return $builder->limit($limit, $offset)
                   ->orderBy('invtest.orderid', 'DESC')  // Order by orderid
                   ->get()
                   ->getResult();
}



// public function countAllInvoices($startyear = null, $endyear = null, $client = null, $product = null)
// {
//     $builder = $this->db->table('invtest2')
//                         ->join('client', 'invtest2.cid = client.cid')
//                         ->join('invtest', 'invtest2.orderid = invtest.orderid', 'left')  // Join with invtest
//                         ->where('client.u_type', 0);  // Always filter by u_type

//      // Check if year parameters are provided, otherwise set default year
//     if ($startyear && $endyear) {
//         $builder->where('invtest2.created >=', "$startyear-04-01")
//                 ->where('invtest2.created <=', "$endyear-03-31");
//     } else {
//         // Set default year (last financial year)
//         $currentYear = date('Y');
//         $currentMonth = date('m');

//         if ($currentMonth > 3) {
//             $defaultStartYear = $currentYear; // Current year
//             $defaultEndYear = $currentYear + 1; // Next year
//         } else {
//             $defaultStartYear = $currentYear - 1; // Previous year
//             $defaultEndYear = $currentYear; // Current year
//         }

//         $builder->where('invtest2.created >=', "$defaultStartYear-04-01")
//                 ->where('invtest2.created <=', "$defaultEndYear-03-31");
//     }

//     // Apply client filter only if a client is selected
//     if ($client) {
//         $builder->where('client.cid', $client);
//     }

//     // Apply product filter only if a product (item_name) is selected
//     if ($product) {
//         $builder->where('invtest.item_name', $product);
//     }

//     // Group by orderid and cid to count unique records
//     $builder->groupBy('invtest2.orderid, invtest2.cid');

//     return $builder->countAllResults();
// }
public function countAllInvoices($startyear = null, $endyear = null, $client = null, $product = null)
{
    $builder = $this->db->table('invtest2')
                        ->join('client', 'invtest2.cid = client.cid')
                        ->join('invtest', 'invtest2.orderid = invtest.orderid', 'left');  // Join with invtest
                     // Always filter by u_type

    // Check if year parameters are provided, otherwise set default year
    if ($startyear && $endyear) {
        $builder->where('invtest2.created >=', "$startyear-04-01")
                ->where('invtest2.created <=', "$endyear-03-31");
    } else {
        // Set default year (last financial year)
        $currentYear = date('Y');
        $currentMonth = date('m');

        if ($currentMonth > 3) {
            $defaultStartYear = $currentYear;
            $defaultEndYear = $currentYear + 1;
        } else {
            $defaultStartYear = $currentYear - 1;
            $defaultEndYear = $currentYear;
        }

        $builder->where('invtest2.created >=', "$defaultStartYear-04-01")
                ->where('invtest2.created <=', "$defaultEndYear-03-31");
    }

    // Apply client filter only if a client is selected
    if ($client) {
        $builder->where('client.cid', $client);
    }

    // Apply product filter only if a product (item_name) is selected
    if ($product) {
        $builder->where('invtest.item_name', $product);
    }

    // Group by orderid and cid to get unique records
    $builder->groupBy('invtest2.orderid, invtest2.cid');

    // Count the unique results by retrieving the grouped data and using count()
    return count($builder->get()->getResult());
}

public function insertItems(array $items) {
        return $this->insertBatch($items);
    }

public function updateBatch(?array $set = null, ?string $index = null, int $batchSize = 100, bool $returnSQL = true)
{
    $index ='orderid';  // Default to the primary key if not provided

    if (empty($set)) {
        return false; // No data to update
    }

    try {
        // Use 'purchaseinv2' as the table name
        return $this->db->table('invtest2')->updateBatch($set, $index, $batchSize);
    } catch (\Exception $e) {
        log_message('error', 'UpdateBatch failed: ' . $e->getMessage());
        return false;
    }
}


public function printinvdata($orderid)
{
    if (!$orderid) {
        return false; // Return false or handle the case where order ID is missing
    }

    $builder = $this->db->table('invtest2');
    $builder->select('client.*, invtest2.*');
    $builder->join('client', 'invtest2.cid = client.cid', 'inner');
    $builder->where('invtest2.orderid', $orderid);

    $query = $builder->get();
    return $query->getResultArray(); // Return the fetched data as an array
}


public function getInvoices($startDate = null, $endDate = null, $item = null, $customer = null, $ctype=null)
{

    $sql = "SELECT 
                ROW_NUMBER() OVER () AS id, 
                invtest.item_name AS item, 
                invtest2.invid AS `inv no`, 
                invtest2.created AS `inv date`, 
                client.c_name AS client, 
                SUBSTRING_INDEX(client.c_add, ',', -1) AS location, 
                client.gst AS GST, 
                client.c_type AS c_type,
                invtest2.subtotal AS subtotal, 
                invtest2.taxrate AS taxrate, 
                invtest2.taxamount AS taxamount, 
                invtest2.totalamount AS totalamount 

            FROM invtest2 
            INNER JOIN invtest ON invtest.orderid = invtest2.orderid 
            INNER JOIN client ON invtest2.cid = client.cid";

    // Add conditions dynamically
    $conditions = [];
    $params = [];



  if (!empty($customer)) {
        $conditions[] = "client.cid = ?";
        $params[] = $customer;
    }


    if (!empty($startDate) && !empty($endDate)) {
        $conditions[] = "invtest2.created BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
    }

  
    //  if (!empty($ctype)) {
    //     $conditions[] = "client.u_type = ?";
    //     $params[] = $ctype;
    // }

    // Append conditions to SQL query
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // Add GROUP BY clause
    $sql .= "GROUP BY invtest.orderid";

//    echo $sql;

    // Execute the query
    $query = $this->db->query($sql, $params);

    //print_r($query);

    // Return the results
    return $query->getResult();
}

public function getItemreport($startDate = null, $endDate = null, $item = null)
{
    $sql = "
        SELECT 
            ROW_NUMBER() OVER () AS id,
            invtest2.created, 
            invtest.item_name AS item, 
            invtest.item_desc AS description, 
            invtest.hsn, 
            invtest.price,
            invtest.quantity, 
            invtest.total AS subtotal, 
            invtest2.taxrate, 
            invtest2.taxamount,
            invtest2.totalamount
 
        FROM 
            invtest2 
        INNER JOIN 
            invtest ON invtest.orderid = invtest2.orderid 
        INNER JOIN 
            products ON invtest.item_name = products.name
    ";

    // Initialize conditions and parameters
    $conditions = [];
    $params = [];

    // Add date range condition
    if (!empty($startDate) && !empty($endDate)) {
        $conditions[] = "invtest2.created BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
    }

    // Add item condition
    if (!empty($item)) {
        $conditions[] = "invtest.item_name = ?";
        $params[] = $item;
    }

    // Ensure at least one condition is applied
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    } else {
        // No conditions provided; return an empty result
        return [];
    }

    //echo $sql;

    // Execute the query
    $query = $this->db->query($sql, $params);

    // Return the results
    return $query->getResult();
}



}
