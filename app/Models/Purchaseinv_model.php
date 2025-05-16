<?php

namespace App\Models;

use CodeIgniter\Model;

class Purchaseinv_model extends Model
{
    protected $table = 'purchaseinv';
    
    protected $primaryKey = 'orderno'; // Specify your primary key column

        

    protected $allowedFields = ['orderid', 'item_name', 'item_desc','hsn','quantity','price', 'total']; // Specify allowed fields

    


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

    public function updaterecord(int $id, array $data)
    {
        return $this->update($id, $data); // Update data in the table
    }
    
//     public function deleterecord(int $id)
// {
//     // Use CodeIgniter's built-in delete method
//     return $this->db->table('client')->delete(['cid' => $id]);
// }

    public function deleterecord(string $id)
    {
        return $this->db->table('purchaseinv')->delete(['orderid' => $id]); 
        //return $this->delete(['orderid' => $id]); // Update data in the table
    }


public function single_entry($edit_id)
{
    // Use query builder methods properly
    return $this->db->table('client')  // Assuming your table is 'table_name'
                    ->where('cid', $edit_id)
                    ->get()
                    ->getRowArray();
}


public function get_last_cid(){

      //   $this->db->select_max('cid'); // Assuming 'cid' is your column name
      //   $query = $this->db->get('client'); // Replace with your table name
      // return $query->row()->cid; // Return the max cid value
     $builder = $this->builder('client');
    $builder->selectMax('cid'); // selectMax is the correct method
    $query = $builder->get(); // Execute the query

    // Debugging: Check what the raw SQL query is
    //log_message('debug', $builder->getLastQuery());

    $result = $query->getRow();
    return $result ? (int)$result->cid : null; 

}

    // public function updateBatch(?array $set = null, ?string $index = null, int $batchSize = 100, bool $returnSQL = true)
    // {
    //     $index = 'orderid';

    //     echo $index;

    //     try {
    //      parent::updateBatch($set, $index, $batchSize, $returnSQL);
    //         return $this->db->last_query();
    //     } catch (\Exception $e) {
    //         log_message('error', 'UpdateBatch failed: ' . $e->getMessage());
    //         return $this->db->last_query();
        
    //     }
    // }

public function updateBatch(?array $set = NULL, ?string $index = NULL, int $batchSize = 100, bool $returnSQL = false)
{
    try {
        // Check if data is correctly formatted
        if (empty($set)) {
            throw new \Exception('No data to update.');
        }

        // Log the data being passed
        log_message('debug', 'UpdateBatch data: ' . json_encode($set));

        // Perform the update
        $result = $this->db->table($this->table)->updateBatch($set, $index, $batchSize, $returnSQL);

        if (!$result) {
            throw new \Exception('UpdateBatch failed.');
        }

        return true;
    } catch (\Exception $e) {
        log_message('error', 'UpdateBatch failed: ' . $e->getMessage());
        return false;
    }
}



    public function updatePurchaseInvoice($orderid, $data)
{
    return $this->db->table($this->table)
        ->where('orderid', $orderid)
        ->update($data);
}


 public function fetchitemdata($orderid)
{
    if (!$orderid) {
        return false; // Return false or handle the case where order ID is missing
    }

    $builder = $this->db->table('purchaseinv');
    $builder->select('purchaseinv.*'); // Remove "FROM" from the select clause
    $builder->where('orderid', $orderid);
    $query = $builder->get();
    
    return $query->getResultArray();
}
}
