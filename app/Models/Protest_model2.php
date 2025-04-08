<?php

namespace App\Models;

use CodeIgniter\Model;

class Protest_model2 extends Model
{
    protected $table = 'protest2'; // Specify your table name
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
        $this->db->table('protest2')->where('orderid', $orderid)->update($updateData);

    }


    public function deleterecord(string $id)
{
    $builder = $this->db->table('protest2');
    $builder->delete(['orderid' => $id]);

    // Check if any rows were affected (deleted) and return true if successful
    return $this->db->affectedRows() > 0;
}


    
    public function getFinancialYears()
{
    return $this->db->table('protest2')  // Specify the table to query from
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


public function getprotest($startyear = null, $endyear = null, $client = null, $product = null, $limit, $offset)
{
    $builder = $this->db->table('protest')
                        ->select('protest.orderid, protest2.invid, protest.item_name, protest2.*, SUM(protest2.totalamount) as total_amount, client.c_name, GROUP_CONCAT(protest.item_name SEPARATOR ", ") AS item_names, SUBSTRING_INDEX(client.c_add, ",", -1) as location')
                        ->join('protest2', 'protest.orderid = protest2.orderid', 'left')  // Use LEFT JOIN for protest2
                        ->join('client', 'protest2.cid = client.cid', 'left');  // Always filter by u_type

      // Check if year parameters are provided, otherwise set default year
    if ($startyear && $endyear) {
        $builder->where('protest2.created >=', "$startyear-04-01")
                ->where('protest2.created <=', "$endyear-03-31");
    }   elseif (!$client) { 
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


        $builder->where('protest2.created >=', "$defaultStartYear-04-01")
                ->where('protest2.created <=', "$defaultEndYear-03-31");
    }

    // Apply client filter only if a client is selected
    if ($client) {
        $builder->where('protest2.cid', $client);
    }

    // Apply product filter only if a product (item_name) is selected
    if ($product) {
        $builder->where('protest.item_name', $product);
    }

    // Group by orderid and client id to avoid duplicate rows
    $builder->groupBy('protest.orderid, protest2.cid');

    // Apply limit and offset for pagination
    return $builder->limit($limit, $offset)
                   ->orderBy('protest.orderid', 'DESC')  // Order by orderid
                   ->get()
                   ->getResult();


}


public function countAllInvoices($startyear = null, $endyear = null, $client = null, $product = null)
{
    $builder = $this->db->table('protest2')
                        ->join('client', 'protest2.cid = client.cid')
                        ->join('protest', 'protest2.orderid = protest.orderid', 'left');

    // Apply date range filters
    if ($startyear && $endyear) {
        $builder->where('protest2.created >=', "$startyear-04-01")
                ->where('protest2.created <=', "$endyear-03-31");
    } else {
        // Set default financial year range
        $currentYear = date('Y');
        $currentMonth = date('m');

        if ($currentMonth > 3) {
            $defaultStartYear = $currentYear;
            $defaultEndYear = $currentYear + 1;
        } else {
            $defaultStartYear = $currentYear - 1;
            $defaultEndYear = $currentYear;
        }

        $builder->where('protest2.created >=', "$defaultStartYear-04-01")
                ->where('protest2.created <=', "$defaultEndYear-03-31");
    }

    // Apply client filter
    if ($client) {
        $builder->where('client.cid', $client);
    }

    // Apply product filter
    if ($product) {
        $builder->where('protest.item_name', $product);
    }

    // Group by orderid and cid to count unique records
    $builder->groupBy('protest2.orderid, protest2.cid');

    // Return the count of unique rows
    return count($builder->get()->getResult());
}


public function insertItems(array $items) {
        // Using insertBatch for batch insert to improve performance
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
        return $this->db->table('protest2')->updateBatch($set, $index, $batchSize);
    } catch (\Exception $e) {
        log_message('error', 'UpdateBatch failed: ' . $e->getMessage());
        return false;
    }
}

public function printprodata($orderid)
{
    if (!$orderid) {
        return false; // Return false or handle the case where order ID is missing
    }

    $builder = $this->db->table('protest2');
    $builder->select('client.*, protest2.*');
    $builder->join('client', 'protest2.cid = client.cid', 'inner');
    $builder->where('protest2.orderid', $orderid);

    $query = $builder->get();
    return $query->getResultArray(); // Return the fetched data as an array
}

}
