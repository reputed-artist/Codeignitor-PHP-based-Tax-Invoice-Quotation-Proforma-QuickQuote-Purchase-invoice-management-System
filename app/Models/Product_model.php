<?php

namespace App\Models;

use CodeIgniter\Model;

class Product_model extends Model
{
    protected $table = 'products'; // Specify your table name
    protected $primaryKey = 'p_id'; // Specify your primary key column

    

    protected $allowedFields = ['p_id','name', 'hsn','description','p_type','cattype','img_loc','techs','created']; // Specify allowed fields


    // public function __construct() {
    //     parent::__construct();
    //     $this->load->database(); // Load the database
    // }

    
    public function saverecords(array $data)
    {

        //echo "model".$this->insert($data);
        $this->insert($data); // Insert data into the table
        return $this->db->insertID();  
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
        return $this->delete(['p_id' => $id]); //getp Update data in the table
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


    public function getProductDetails($cid)
    {
        
//         $sql="SELECT 
//     products.p_id AS p_id,
//     products.name AS name,
//     products.img_loc,
//     COALESCE(techsps.techs, '') AS techs,
//     COALESCE(techsps.img_loc, '') AS img_loc,
//     COALESCE(products.hsn, '') AS hsn,
//     COALESCE(products.p_type, '') AS p_type,
//     COALESCE(techsps.subcat, '') AS subcat,
//     products.created AS created,
//     COUNT(DISTINCT invtest2.invid) AS invid_count,
//     SUM(invtest.quantity) AS item_sold,
//     SUM(invtest2.totalamount) AS total
// FROM 
//     products
// LEFT JOIN 
//     techsps ON techsps.p_id = products.p_id
// LEFT JOIN 
//     invtest ON invtest.item_name = products.name
// LEFT JOIN 
//     invtest2 ON invtest.orderid = invtest2.orderid
// WHERE 
//     products.p_id = ?
// GROUP BY 
//     products.p_id, products.name, techsps.techs, techsps.img_loc, 
//     products.hsn, products.p_type, techsps.subcat, products.created
// ORDER BY 
//     item_sold DESC";
        $sql="SELECT 
    products.p_id AS p_id,
    products.name AS name,
    products.techs,
    products.img_loc,
    COALESCE(products.hsn, '') AS hsn,
    COALESCE(products.p_type, '') AS p_type,
    products.created AS created,
    COUNT(DISTINCT invtest2.invid) AS invid_count,
    SUM(invtest.quantity) AS item_sold,
    SUM(invtest2.totalamount) AS total
FROM 
    products

LEFT JOIN 
    invtest ON invtest.item_name = products.name
LEFT JOIN 
    invtest2 ON invtest.orderid = invtest2.orderid
WHERE 
    products.p_id = ?
GROUP BY 
    products.p_id, products.name,  
    products.hsn, products.p_type, products.created
ORDER BY 
    item_sold DESC";

            log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());

        return $this->db->query($sql, [$cid])->getRowArray();
    }

    // public function getproductpie($cid)
    // {
    //     $sql="SELECT CASE WHEN MONTH(invtest2.created) >= 4 THEN CONCAT(YEAR(invtest2.created), '-', RIGHT(YEAR(invtest2.created) + 1, 2)) ELSE CONCAT(YEAR(invtest2.created) - 1, '-', RIGHT(YEAR(invtest2.created), 2)) END AS FinancialYear, invtest.`item_name` AS ItemName, count(invtest.quantity) AS TotalQuantity FROM invtest INNER JOIN invtest2 ON invtest.orderid = invtest2.orderid WHERE invtest.item_name =? GROUP BY FinancialYear, invtest.`item_name` ORDER BY FinancialYear DESC LIMIT 8";

    //         log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());

    //     return $this->db->query($sql, [$cid])->getRowArray();
    // }
    public function getproductpie($pn)
{
    // Fetch pie chart data for the given product name
    $sql = "SELECT 
        CASE 
            WHEN MONTH(invtest2.created) >= 4 THEN CONCAT(YEAR(invtest2.created), '-', RIGHT(YEAR(invtest2.created) + 1, 2)) 
            ELSE CONCAT(YEAR(invtest2.created) - 1, '-', RIGHT(YEAR(invtest2.created), 2)) 
        END AS FinancialYear, 
        invtest.`item_name` AS ItemName, 
        COUNT(invtest.quantity) AS TotalQuantity 
    FROM 
        invtest 
    INNER JOIN 
        invtest2 ON invtest.orderid = invtest2.orderid 
    WHERE 
        invtest.item_name = ?
    GROUP BY 
        FinancialYear, invtest.`item_name` 
    ORDER BY 
        FinancialYear DESC 
    LIMIT 8";

    log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());
    // Execute the query and return the result
    return $this->db->query($sql, [$pn])->getResultArray();
}

  public function getproductinv($vn){
    $sql="SELECT invtest.item_name 'Item', invtest2.invid, invtest2.orderid,invtest2.created, client.c_name,substring_index(client.c_add, ',', -1) as location,invtest2.totalamount 'totalamount' from invtest2 inner join invtest on invtest.orderid = invtest2.orderid and invtest.item_name= ? inner join client on invtest2.cid = client.cid  GROUP by invtest.orderid";

    log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());
    
    return $this->db->query($sql, [$vn])->getResultArray();
  }

  public function getproductproinv($vns){
    $sql="SELECT protest.item_name 'Item', protest2.invid, protest2.orderid,protest2.created, client.c_name,substring_index(client.c_add, ',', -1) as location,protest2.totalamount 'totalamount' from protest2 inner join protest on protest.orderid = protest2.orderid and protest.item_name= ? inner join client on protest2.cid = client.cid  GROUP by protest.orderid";

    log_message('debug', 'Executing SQL: ' . $this->db->getLastQuery());
    
    return $this->db->query($sql, [$vns])->getResultArray();
  }
}
?>