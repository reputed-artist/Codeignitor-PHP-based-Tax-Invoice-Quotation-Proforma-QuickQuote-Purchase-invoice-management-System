<?php

namespace App\Models;

use CodeIgniter\Model;

class Quote_model2 extends Model
{
    protected $table = 'quote2'; // Specify your table name
    protected $primaryKey = 'invid'; // Specify your primary key column

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
        $this->db->table('quote2')->where('orderid', $orderid)->update($updateData);

    }

    public function deleterecord(string $id)
{
    $builder = $this->db->table('quote2');
    $builder->delete(['orderid' => $id]);

    // Check if any rows were affected (deleted) and return true if successful
    return $this->db->affectedRows() > 0;
}


    
    public function getFinancialYears()
{
    return $this->db->table('quote2')  // Specify the table to query from
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


public function getquote($startyear=null, $endyear=null, $client = null, $product = null, $limit, $offset)
{
    $builder = $this->db->table('quote')
                        ->select('quote.orderid, quote2.invid, quote.item_name, quote2.*, SUM(quote2.totalamount) as total_amount, client.c_name, GROUP_CONCAT(quote.item_name SEPARATOR ", ") AS item_names, SUBSTRING_INDEX(client.c_add, ",", -1) as location')
                        ->join('quote2', 'quote.orderid = quote2.orderid', 'left')  // Use LEFT JOIN for quote2
                        ->join('client', 'quote2.cid = client.cid', 'left'); // Always filter by u_type

     // Check if year parameters are provided, otherwise set default year
    if ($startyear && $endyear) {
        $builder->where('quote2.created >=', "$startyear-04-01")
                ->where('quote2.created <=', "$endyear-03-31");
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

        $builder->where('quote2.created >=', "$defaultStartYear-04-01")
                ->where('quote2.created <=', "$defaultEndYear-03-31");
    }

    // Apply client filter only if a client is selected
    if ($client) {
        $builder->where('quote2.cid', $client);
    }

    // Apply product filter only if a product (item_name) is selected
    if ($product) {
        $builder->where('quote.item_name', $product);
    }

    // Group by orderid and client id to avoid duplicate rows
    $builder->groupBy('quote.orderid, quote2.cid');

    // Apply limit and offset for pagination
    return $builder->limit($limit, $offset)
                   ->orderBy('quote.orderid', 'DESC')  // Order by orderid
                   ->get()
                   ->getResult();
}


public function countAllInvoices($startyear = null, $endyear = null, $client = null, $product = null)
{
    $builder = $this->db->table('quote2')
                        ->join('client', 'quote2.cid = client.cid')
                        ->join('quote', 'quote2.orderid = quote.orderid', 'left');  // Join with quote
                        //->where('client.u_type', 0);  // Always filter by u_type

      // Check if year parameters are provided, otherwise set default year
    if ($startyear && $endyear) {
        $builder->where('quote2.created >=', "$startyear-04-01")
                ->where('quote2.created <=', "$endyear-03-31");
    } else {
        // Set default year (last financial year)
        $currentYear = date('Y');
        $currentMonth = date('m');

        if ($currentMonth > 3) {
            $defaultStartYear = $currentYear; // Current year
            $defaultEndYear = $currentYear + 1; // Next year
        } else {
            $defaultStartYear = $currentYear - 1; // Previous year
            $defaultEndYear = $currentYear; // Current year
        }

        $builder->where('quote2.created >=', "$defaultStartYear-04-01")
                ->where('quote2.created <=', "$defaultEndYear-03-31");
    }


    // Apply client filter only if a client is selected
    if ($client) {
        $builder->where('client.cid', $client);
    }

    // Apply product filter only if a product (item_name) is selected
    if ($product) {
        $builder->where('quote.item_name', $product);
    }

    // Group by orderid and cid to get unique records
    $builder->groupBy('quote2.orderid, quote2.cid');

    //return $builder->countAllResults();
    // Count the unique results by retrieving the grouped data and using count()
    return count($builder->get()->getResult());
}

    public function insertItems(array $items) {
        // Using insertBatch for batch insert to improve performance
        return $this->insertBatch($items);
    }



    public function fetchquotedata($did)
{
    $query = $this->db->table('quote')
        ->select('quote.orderid, 
                  quote.item_name, 
                  quote.quantity, 
                  quote.total, 
                  quote2.invid, 
                  quote2.cid, 
                  quote2.subtotal, 
                  quote2.taxrate, 
                  quote2.taxamount, 
                  quote2.totalamount, 
                  quote2.created, 
                  quote2.note')
        ->join('quote2', 'quote.orderid = quote2.orderid') // Join quote2 table
        
        ->where('quote2.orderid', $did)                  // Add condition
        ->get();

    // Return results as an array
    return $query->getResultArray();
}


public function printquotedata($orderid)
{
    if (!$orderid) {
        return false; // Return false or handle the case where order ID is missing
    }

    $builder = $this->db->table('quote2');
    $builder->select('client.*, quote2.*');
    $builder->join('client', 'quote2.cid = client.cid', 'inner');
    $builder->where('quote2.orderid', $orderid);

    $query = $builder->get();
    return $query->getResultArray(); // Return the fetched data as an array
}

public function getInvoices($startDate = null, $endDate = null, $item = null, $customer = null, $ctype=null)
{

    $sql = "SELECT 
                ROW_NUMBER() OVER () AS id, 
                quote.item_name AS item, 
                quote2.invid AS `inv no`, 
                quote2.created AS `inv date`, 
                client.c_name AS client, 
                SUBSTRING_INDEX(client.c_add, ',', -1) AS location, 
                client.gst AS GST, 
                client.c_type AS c_type,
                quote2.subtotal AS subtotal, 
                quote2.taxrate AS taxrate, 
                quote2.taxamount AS taxamount, 
                quote2.totalamount AS totalamount 

            FROM quote2 
            INNER JOIN quote ON quote.orderid = quote2.orderid 
            INNER JOIN client ON quote2.cid = client.cid";

    // Add conditions dynamically
    $conditions = [];
    $params = [];



  if (!empty($customer)) {
        $conditions[] = "client.cid = ?";
        $params[] = $customer;
    }


    if (!empty($startDate) && !empty($endDate)) {
        $conditions[] = "quote2.created BETWEEN ? AND ?";
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
    $sql .= "GROUP BY quote.orderid";

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
            quote2.created, 
            quote.item_name AS item, 
            -- quote.item_desc AS description, 
            -- quote.hsn, 
            quote.price,
            quote.quantity, 
            quote.total AS subtotal, 
            quote2.taxrate, 
            quote2.taxamount,
            quote2.totalamount
 
        FROM 
            quote2 
        INNER JOIN 
            quote ON quote.orderid = quote2.orderid 
        INNER JOIN 
            products ON quote.item_name = products.name
    ";

    // Initialize conditions and parameters
    $conditions = [];
    $params = [];

    // Add date range condition
    if (!empty($startDate) && !empty($endDate)) {
        $conditions[] = "quote2.created BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
    }

    // Add item condition
    if (!empty($item)) {
        $conditions[] = "quote.item_name = ?";
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
