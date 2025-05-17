<?php

namespace App\Models;

use CodeIgniter\Model;

class Supplier_model extends Model
{
    protected $table = 'client'; // Specify your table name
    protected $primaryKey = 'cid'; // Specify your primary key column

    

    protected $allowedFields = ['c_name', 'c_add', 'mob','country','gst','email', 'c_type','u_type','created']; // Specify allowed fields

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

    public function updaterecord(int $id, array $data)
    {
        return $this->update($id, $data); // Update data in the table
    }
    
//     public function deleterecord(int $id)
// {
//     // Use CodeIgniter's built-in delete method
//     return $this->db->table('client')->delete(['cid' => $id]);
// }

    public function deleterecord(int $id)
    {
        return $this->delete(['cid' => $id]); // Update data in the table
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

        public function getSupplierDetails($cid)
    {
        $sql = "
            SELECT 
                SUM(purchaseinv2.totalitems) AS totalitems, COUNT(purchaseinv2.invid) AS invid,  SUM(purchaseinv2.totalamount) AS purchase, 
                client.c_name, 
                client.c_add, 
                client.mob, 
                client.gst, 
                client.c_type,
                client.u_type, 
                client.country, 
                client.created 
            FROM purchaseinv2
            RIGHT JOIN client USING (cid)  
            WHERE cid = ? 
            GROUP BY client.cid";
            log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());

        return $this->db->query($sql, [$cid])->getRowArray();
    }   
        public function getFinancialYearTotals($cid)
    {
        $sql = "
            SELECT 
                CASE 
                    WHEN MONTH(purchaseinv2.created) >= 4 
                    THEN CONCAT(YEAR(purchaseinv2.created), '-', RIGHT(YEAR(purchaseinv2.created) + 1, 2)) 
                    ELSE CONCAT(YEAR(purchaseinv2.created) - 1, '-', RIGHT(YEAR(purchaseinv2.created), 2)) 
                END AS FinancialYear, 
                SUM(purchaseinv2.totalamount) AS TotalAmount 
            FROM purchaseinv2 
            WHERE purchaseinv2.cid = ? 
            GROUP BY FinancialYear 
            ORDER BY FinancialYear DESC 
            LIMIT 5";
            log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());

        return $this->db->query($sql, [$cid])->getResultArray();
    }

    public function getsupplierinv($vn){
    $sql="SELECT purchaseinv2.orderid, purchaseinv.item_name 'Item', purchaseinv2.invid,purchaseinv2.created, client.c_name,substring_index(client.c_add, ',', -1) as location,purchaseinv2.totalamount 'totalamount' from purchaseinv INNER JOIN purchaseinv2 on purchaseinv.orderid = purchaseinv2.orderid INNER JOIN client on purchaseinv2.cid = client.cid and client.cid = ? GROUP by purchaseinv.orderid";


    log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());
    
    return $this->db->query($sql, [$vn])->getResultArray();
  }


   public function getsupplierproinv($vns){
    $sql="SELECT protest2.orderid, protest.item_name 'Item', protest2.invid,protest2.created, client.c_name,substring_index(client.c_add, ',', -1) as location,protest2.totalamount 'totalamount' from protest INNER JOIN protest2 on protest.orderid = protest2.orderid INNER JOIN client on protest2.cid = client.cid and client.cid = ? GROUP by protest.orderid";


    log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());
    
    return $this->db->query($sql, [$vns])->getResultArray();
  }



  public function getsuppliersalesinv($vnss){
    $sql="SELECT invtest2.orderid, invtest.item_name 'Item', invtest2.invid,invtest2.created, client.c_name,substring_index(client.c_add, ',', -1) as location,invtest2.totalamount 'totalamount' from invtest INNER JOIN invtest2 on invtest.orderid = invtest2.orderid INNER JOIN client on invtest2.cid = client.cid and client.cid = ? GROUP by invtest.orderid";


    log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());
    
    return $this->db->query($sql, [$vnss])->getResultArray();
  }
}
