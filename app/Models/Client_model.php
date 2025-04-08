<?php

namespace App\Models;

use CodeIgniter\Model;

class Client_model extends Model
{
    protected $table = 'client'; // Specify your table name
    protected $primaryKey = 'cid'; // Specify your primary key column

    

    protected $allowedFields = ['c_name', 'c_add', 'mob','country','gst','email', 'c_type','u_type','created']; // Specify allowed fields

   
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


     $builder = $this->builder('client');
    $builder->selectMax('cid'); // selectMax is the correct method
    $query = $builder->get(); // Execute the query

    // Debugging: Check what the raw SQL query is
    //log_message('debug', $builder->getLastQuery());

    $result = $query->getRow();
    return $result ? (int)$result->cid : null; 


        }



     public function getClientDetails($cid)
    {
        $sql = "
            SELECT 
                SUM(invtest2.totalitems) AS totalitems, COUNT(invtest2.invid) AS invid,  SUM(invtest2.totalamount) AS sales, 
                client.c_name, 
                client.c_add, 
                client.mob, 
                client.gst, 
                client.c_type,
                client.u_type, 
                client.country, 
                client.created
            FROM invtest2 
            INNER JOIN client USING (cid)  
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
                    WHEN MONTH(invtest2.created) >= 4 
                    THEN CONCAT(YEAR(invtest2.created), '-', RIGHT(YEAR(invtest2.created) + 1, 2)) 
                    ELSE CONCAT(YEAR(invtest2.created) - 1, '-', RIGHT(YEAR(invtest2.created), 2)) 
                END AS FinancialYear, 
                SUM(invtest2.totalamount) AS TotalAmount 
            FROM invtest2 
            WHERE invtest2.cid = ? 
            GROUP BY FinancialYear 
            ORDER BY FinancialYear DESC 
            LIMIT 5";
            log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());

        return $this->db->query($sql, [$cid])->getResultArray();
    }

     public function getTaxinvoices($cid)
    {
        $sql = "
            SELECT invtest.orderid,invtest.item_name 'Item', invtest2.invid,invtest2.created, client.c_name,substring_index(client.c_add, ',', -1) as location,invtest2.totalamount 'totalamount', invtest2.orderid from invtest2 INNER JOIN invtest on invtest.orderid = invtest2.orderid INNER JOIN client on invtest2.cid = client.cid and client.cid =? GROUP by invtest.orderid";

        log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());

        return $this->db->query($sql, [$cid])->getResultArray();
    }

     public function getProinvoices($cid)
    {
        $sql = "
            SELECT protest.orderid,protest.item_name 'Item', protest2.invid,protest2.created, client.c_name,substring_index(client.c_add, ',', -1) as location,protest2.totalamount 'totalamount' FROM protest2 INNER JOIN protest on protest.orderid = protest2.orderid INNER JOIN client on protest2.cid = client.cid and client.cid = ? GROUP by protest.orderid";

            log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());

        return $this->db->query($sql, [$cid])->getResultArray();
    }
}
