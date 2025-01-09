<?php

namespace App\Models;

use CodeIgniter\Model;

class Crud_model extends Model
{
    protected $table = 'crud'; // Specify your table name
    protected $primaryKey = 'id'; // Specify your primary key column

    protected $allowedFields = ['name', 'email', 'city']; // Specify allowed fields

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
    public function updaterecord(int $id, array $data)
    {
        return $this->update($id, $data); // Update data in the table
    }
    public function deleterecord(int $id)
    {
        return $this->delete($id); // Update data in the table
    }
}
