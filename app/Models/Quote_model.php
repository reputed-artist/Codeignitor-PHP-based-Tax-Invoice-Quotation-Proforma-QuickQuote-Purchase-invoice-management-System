<?php

namespace App\Models;

use CodeIgniter\Model;

class Quote_model extends Model
{
    protected $table = 'Quote';
    
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
    $builder = $this->db->table('quote');
    $builder->delete(['orderid' => $id]);

    // Check if any rows were affected (deleted) and return true if successful
    return $this->db->affectedRows() > 0;
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

    public function insertItems(array $items) {
        return $this->insertBatch($items);
    }


   public function fetchitemdata($orderId)
{
    // Use the query builder to join the tables
    return $this->db->table('quote')
        ->select('quote.*, products.*') // Select fields from both tables
        ->join('products', 'quote.item_name = products.name')
        ->where('quote.orderid', $orderId) // Add the condition for orderid
        ->get() // Execute the query
        ->getResultArray(); // Return the result as an array
}

}
