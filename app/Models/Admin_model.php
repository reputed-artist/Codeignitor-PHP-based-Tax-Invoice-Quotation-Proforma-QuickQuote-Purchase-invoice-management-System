<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin_model extends Model
{
    protected $table = 'admin'; // Specify your table name
    protected $primaryKey = 'id'; // Specify your primary key column

    

    protected $allowedFields = ['username', 'password','name','email','qualification','location','skills','c_name','c_add','profession','mob','gst','pan','picture','picturelogo']; // Specify allowed fields

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

    public function updaterecord(int $id, string $data)
    {
        return $this->update($id, $data); // Update data in the table
    }

    public function updatez($id=1, $data)
{
    return $this->db->table('admin')->where('id', $id)->update($data);
}

    
//     public function deleterecord(int $id)
// {
//     // Use CodeIgniter's built-in delete method
//     return $this->db->table('client')->delete(['cid' => $id]);
// }

    public function deleterecord(int $id)
    {
        return $this->delete(['p_id' => $id]); // Update data in the table
    }


public function single_entry($edit_id)
{
    // Use query builder methods properly
    return $this->db->table('products')  // Assuming your table is 'table_name'
                    ->where('p_id', $edit_id)
                    ->get()
                    ->getRowArray();
}


    public function get_last_cid(){

      //   $this->db->select_max('cid'); // Assuming 'cid' is your column name
      //   $query = $this->db->get('client'); // Replace with your table name
      // return $query->row()->cid; // Return the max cid value
     $builder = $this->builder('products');
    $builder->selectMax('p_id'); // selectMax is the correct method
    $query = $builder->get(); // Execute the query

    // Debugging: Check what the raw SQL query is
    //log_message('debug', $builder->getLastQuery());

    $result = $query->getRow();
    return $result ? (int)$result->p_id : null; 


        }

     public function coinfo() {
        return $this->db->table('admin')
        ->select('*')
        ->get()
        ->getRow();
     }  
}
?>