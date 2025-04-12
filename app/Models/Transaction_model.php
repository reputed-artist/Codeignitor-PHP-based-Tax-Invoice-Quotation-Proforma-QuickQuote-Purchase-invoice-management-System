<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaction_model extends Model
{
    protected $table = 'paidhistory'; // Specify your table name
    protected $primaryKey = 'pay_id'; // Specify your primary key column

    

    protected $allowedFields = ['pay_id','cid', 'amount', 'bank','dateofpayment','purpose','created']; // Specify allowed fields

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

public function updaterecord(string $id, array $data)
{
    $result = $this->update($id, $data);
    if (!$result) {
        log_message('error', 'Update failed: ' . print_r($this->errors(), true));
    } else {
        log_message('debug', 'Update success for ID: ' . $id);
    }
    return $result;
}

//     public function deleterecord(int $id)
// {
//     // Use CodeIgniter's built-in delete method
//     return $this->db->table('client')->delete(['cid' => $id]);
// }

    // public function deleterecord(string $id)
    // {
    //     return $this->delete(['pay_id' => $id]); // Update data in the table
    // }


    public function deleterecord(string $id)
    {
         $this->db->table('paidhistory')->delete(['pay_id' => $id]); 
        //return $this->delete(['orderid' => $id]); // Update data in the table
    }


public function single_entry($edit_id)
{
    // Use query builder methods properly
    return $this->db->table('paidhistory')  // Assuming your table is 'table_name'
                    ->where('pay_id', $edit_id)
                    ->get()
                    ->getRowArray();
}


public function getTransactions($startDate = null, $endDate = null, $customer = null, $clienttype=null)
{
    $db = \Config\Database::connect();
    // $builder = $db->table('paidhistory ph')
    //               ->select("ph.pay_id, 
    //                        COALESCE(s.pcname, c.c_name, 'Unknown') AS c_name,
    //                        COALESCE(SUBSTRING_INDEX(s.pcadd, ',', -1), SUBSTRING_INDEX(c.c_add, ',', -1)) AS location,
    //                        ph.amount, ph.dateofpayment, c.u_type, ph.purpose, ph.bank, ph.created")
    //               ->join('purchasecom s', 'ph.cid = s.pcid', 'left')
    //               ->join('client c', 'ph.cid = c.cid', 'left');
    

    $builder = $db->table('client c')
        ->select("c.cid, c.c_name, c.c_add, ph.pay_id, 
                  COALESCE(SUBSTRING_INDEX(c.c_add, ',', -1), 'Unknown') AS location,
                  ph.amount, ph.dateofpayment, c.u_type, ph.purpose, ph.bank, ph.created")
        ->join('paidhistory ph', 'ph.cid = c.cid','right');
              

    // // Apply filters if provided
    // if ($startDate && $endDate) {
    //     $builder->where("ph.dateofpayment BETWEEN '$startDate' AND '$endDate'");
    // }
    if ($startDate && $endDate) {
    $builder->where("ph.dateofpayment >=", $startDate)
            ->where("ph.dateofpayment <=", $endDate);
}
    
    if ($customer) {
        $builder->where("c.cid", $customer);
    }
    if (is_numeric($clienttype)) {
    $builder->where("c.u_type", $clienttype);
}


    $query = $builder->get();

    //print_r($query);
        //$query = $builder->get();

    // 👇 Print the actual executed query
    //echo $db->getLastQuery();

    return $query->getResultArray();
}



public function getClientDetails($cid)
{
    return $this->db->table('client') // Assuming the table name is `client`
        ->select('cid, c_name') // Select only what you need
        ->where('cid', $cid) // Match the specific client ID
        ->get()
        ->getRowArray(); // Return a single row as an associative array
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
}
