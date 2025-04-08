<?php

namespace App\Models;

use CodeIgniter\Model;

class Quickquote_model extends Model
{
    protected $table = 'quickquote'; // Specify your table name
    protected $primaryKey = 'sr_no'; // Specify your primary key column

    protected $allowedFields = ['q_id', 'p_id', 'mob','quantity','price','subtotal','gst','total','created']; // Specify allowed fields

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
    
    public function saverecords($data)
    {
        $this->insert($data); // Insert data into the table
         return $this->affectedRows() > 0; // Ensures data was inserted
    }

  public function fulldata($id)
{
    $query = "SELECT quickquote.q_id, products.name, products.img_loc, products.techs, 
                     products.hsn, quickquote.mob, quickquote.quantity, quickquote.subtotal, 
                     quickquote.gst, quickquote.total, quickquote.created 
              FROM quickquote 
              INNER JOIN products ON products.p_id = quickquote.p_id 
              WHERE quickquote.q_id = ? "; 

    $result = $this->db->query($query, [$id])->getResultArray();

    if (empty($result)) {
        log_message('error', 'No data found for Q_ID: ' . $id);
        return ['error' => 'No records found for this Q_ID'];
    }

    return $result;
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
    // public function deleterecord(int $id)
    // {
    //     return $this->delete($id); // Update data in the table
    // }
}
