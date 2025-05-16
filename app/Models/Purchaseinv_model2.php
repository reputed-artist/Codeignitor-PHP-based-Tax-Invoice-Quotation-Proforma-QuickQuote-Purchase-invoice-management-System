<?php


namespace App\Models;

use CodeIgniter\Model;

class Purchaseinv_model2 extends Model
{
    protected $table = 'purchaseinv2';
    protected $primaryKey = 'nid';
    protected $allowedFields = ['invid', 'cid', 'invdate', 'orderid', 'totalitems', 'subtotal', 'taxrate', 'taxamount', 'totalamount', 'created'];
    public function saverecords(array $data)
    {

        //echo "model".$this->insert($data);
        return $this->insert($data); // Insert data into the table

    }

// public function getPurchaseInvoices($startyear = null, $endyear = null, $client = null, $product = null, $limit, $offset)
// {
//     $builder = $this->db->table('purchaseinv2')
//                         ->select('purchaseinv2.*, client.c_name, SUBSTRING_INDEX(client.c_add, ",", -1) as location, purchaseinv.item_name')
//                         ->join('client', 'purchaseinv2.cid = client.cid')
//                         ->join('purchaseinv', 'purchaseinv2.orderid = purchaseinv.orderid', 'right')  // Join based on common orderid
//                         ->where('client.u_type', 1);  // Always filter by u_type

//     // Apply year filter only if both startyear and endyear are provided
//     if ($startyear && $endyear) {
//         $builder->where('purchaseinv2.invdate >=', "$startyear-04-01")
//                 ->where('purchaseinv2.invdate <=', "$endyear-03-31");
//     }

//     // Apply client filter only if a client is selected
//     if ($client) {
//         $builder->where('client.cid', $client);
//     }

//     // Apply product filter only if a product (item_name) is selected
//     if ($product) {
//         $builder->where('purchaseinv.item_name', $product);
//     }

//     // Apply limit and offset for pagination
//     return $builder->limit($limit, $offset)
//                    ->orderBy('purchaseinv2.nid', 'DESC')  // Order by nid in purchaseinv2
//                    ->get()
//                    ->getResult();
// }

// public function getPurchaseInvoices($startyear = null, $endyear = null, $client = null, $product = null, $limit, $offset)
// {
//     $builder = $this->db->table('purchaseinv')
//                         ->select('purchaseinv.orderid, purchaseinv2.invid, purchaseinv.item_name, purchaseinv2.*, SUM(purchaseinv2.totalamount) as total_amount, client.c_name, GROUP_CONCAT(purchaseinv.item_name SEPARATOR ", ") AS item_names, SUBSTRING_INDEX(client.c_add, ",", -1) as location')
//                         ->join('purchaseinv2', 'purchaseinv.orderid = purchaseinv2.orderid', 'left')  // Use LEFT JOIN for purchaseinv2
//                         ->join('client', 'purchaseinv2.cid = client.cid', 'left')  // Use LEFT JOIN for client
//                         ->where('client.u_type', 1);
//                           // Always filter by u_type

//     // Apply year filter only if both startyear and endyear are provided
//     if ($startyear && $endyear) {
//         $builder->where('purchaseinv2.invdate >=', "$startyear-04-01") // Ensure invdate is from purchaseinv
//                 ->where('purchaseinv2.invdate <=', "$endyear-03-31");
//     }

//     // Apply client filter only if a client is selected
//     if ($client) {
//         $builder->where('purchaseinv2.cid', $client);
//     }

//     // Apply product filter only if a product (item_name) is selected
//     if ($product) {
//         $builder->where('purchaseinv.item_name', $product);
//     }

//     // Group by orderid and client id to avoid duplicate rows
//     $builder->groupBy('purchaseinv.orderid, purchaseinv2.cid');

//     // Apply limit and offset for pagination
//     return $builder->limit($limit, $offset)
//                    ->orderBy('purchaseinv.orderid', 'DESC')  // Order by orderid
//                    ->get()
//                    ->getResult();
// }

// public function getPurchaseInvoices($startyear = null, $endyear = null, $client = null, $product = null, $limit, $offset)
// {
//     $builder = $this->db->table('purchaseinv')
//                         ->select('purchaseinv.orderid, purchaseinv2.invid, purchaseinv.item_name, purchaseinv2.*, SUM(purchaseinv2.totalamount) as total_amount, client.c_name, GROUP_CONCAT(purchaseinv.item_name SEPARATOR ", ") AS item_names, SUBSTRING_INDEX(client.c_add, ",", -1) as location')
//                         ->join('purchaseinv2', 'purchaseinv.orderid = purchaseinv2.orderid', 'left')  // Use LEFT JOIN for purchaseinv2
//                         ->join('client', 'purchaseinv2.cid = client.cid', 'left')  // Use LEFT JOIN for client
//                         ->where('client.u_type', 1); // Always filter by u_type

//     // Check if year parameters are provided, otherwise set default year
//     if ($startyear && $endyear) {
//         $builder->where('purchaseinv2.invdate >=', "$startyear-04-01")
//                 ->where('purchaseinv2.invdate <=', "$endyear-03-31");
//     } else {
//         // Set default year (e.g., last financial year)
//          if (date('m') > 3) {
//         $defaultYear = date('Y') . "-" . (date('Y') + 1);
//     } else {
//         $defaultYear = (date('Y') - 1) . "-" . date('Y');
//     } // Adjust as necessary for your logic

//         $builder->where('purchaseinv2.invdate >=', "$defaultYear-04-01")
//                 ->where('purchaseinv2.invdate <=', "$defaultYear-03-31");
//     }

//     // Apply client filter only if a client is selected
//     if ($client) {
//         $builder->where('purchaseinv2.cid', $client);
//     }

//     // Apply product filter only if a product (item_name) is selected
//     if ($product) {
//         $builder->where('purchaseinv.item_name', $product);
//     }

//     // Group by orderid and client id to avoid duplicate rows
//     $builder->groupBy('purchaseinv.orderid, purchaseinv2.cid');

//     // Apply limit and offset for pagination
//     return $builder->limit($limit, $offset)
//                    ->orderBy('purchaseinv.orderid', 'DESC')  // Order by orderid
//                    ->get()
//                    ->getResult();
// }

// public function countAllInvoices($startyear = null, $endyear = null, $client = null, $product = null)
// {
//     $builder = $this->db->table('purchaseinv2')
//                         ->join('client', 'purchaseinv2.cid = client.cid')
//                         ->join('purchaseinv', 'purchaseinv2.orderid = purchaseinv.orderid', 'left')  // Join with purchaseinv
//                         ->where('client.u_type', 1);  // Always filter by u_type

//    // Check if year parameters are provided, otherwise set default year
//     if ($startyear && $endyear) {
//         $builder->where('purchaseinv2.invdate >=', "$startyear-04-01")
//                 ->where('purchaseinv2.invdate <=', "$endyear-03-31");
//     } else {
//         // Set default year (e.g., last financial year)
//          if (date('m') > 3) {
//         $defaultYear = date('Y') . "-" . (date('Y') + 1);
//     } else {
//         $defaultYear = (date('Y') - 1) . "-" . date('Y');
//     } // Adjust as necessary for your logic
    
//         $builder->where('purchaseinv2.invdate >=', "$defaultYear-04-01")
//                 ->where('purchaseinv2.invdate <=', "$defaultYear-03-31");
//     }


//     // Apply client filter only if a client is selected
//     if ($client) {
//         $builder->where('client.cid', $client);
//     }

//     // Apply product filter only if a product (item_name) is selected
//     if ($product) {
//         $builder->where('purchaseinv.item_name', $product);
//     }

//     return $builder->countAllResults();
// }
public function getPurchaseInvoices($startyear = null, $endyear = null, $client = null, $product = null, $limit, $offset)
{
    $builder = $this->db->table('purchaseinv')
                        ->select('purchaseinv.orderid, purchaseinv2.invid, purchaseinv.item_name, purchaseinv2.*, SUM(purchaseinv2.totalamount) as total_amount, client.c_name, GROUP_CONCAT(purchaseinv.item_name SEPARATOR ", ") AS item_names, SUBSTRING_INDEX(client.c_add, ",", -1) as location')
                        ->join('purchaseinv2', 'purchaseinv.orderid = purchaseinv2.orderid', 'left')
                        ->join('client', 'purchaseinv2.cid = client.cid', 'left')
                        ->whereIn('client.u_type', [1,2]);

    // Check if year parameters are provided, otherwise set default year
    if ($startyear && $endyear) {
        $builder->where('purchaseinv2.invdate >=', "$startyear-04-01")
                ->where('purchaseinv2.invdate <=', "$endyear-03-31");
   } elseif (!$client) { 
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

        $builder->where('purchaseinv2.invdate >=', "$defaultStartYear-04-01")
                ->where('purchaseinv2.invdate <=', "$defaultEndYear-03-31");
    }

    // Apply client filter only if a client is selected
    if ($client) {
        $builder->where('purchaseinv2.cid', $client);
    }

    // Apply product filter only if a product (item_name) is selected
    if ($product) {
        $builder->where('purchaseinv.item_name', $product);
    }

    // Group by orderid and client id to avoid duplicate rows
    $builder->groupBy('purchaseinv.orderid, purchaseinv2.cid');

    // Apply limit and offset for pagination
    return $builder->limit($limit, $offset)
                   ->orderBy('purchaseinv.orderid', 'DESC')
                   ->get()
                   ->getResult();
}

public function countAllInvoices($startyear = null, $endyear = null, $client = null, $product = null)
{
    $builder = $this->db->table('purchaseinv2')
                        ->join('client', 'purchaseinv2.cid = client.cid')
                        ->join('purchaseinv', 'purchaseinv2.orderid = purchaseinv.orderid', 'left')
                        ->whereIn('client.u_type', [1,2]);

    // Check if year parameters are provided, otherwise set default year
    if ($startyear && $endyear) {
        $builder->where('purchaseinv2.invdate >=', "$startyear-04-01")
                ->where('purchaseinv2.invdate <=', "$endyear-03-31");
    } else {
        // Set default year (last financial year)
        $currentYear = date('Y');
        $currentMonth = date('m');

        if ($currentMonth > 3) {
            $defaultStartYear = $currentYear; // Current year
            $defaultEndYear = $currentYear + 1; // Next year
        } else {
            $defaultStartYear = $currentYear - 1; // Previous year
            $defaultEndYear = $currentYear; // Current year
        }

        $builder->where('purchaseinv2.invdate >=', "$defaultStartYear-04-01")
                ->where('purchaseinv2.invdate <=', "$defaultEndYear-03-31");
    }

    // Apply client filter only if a client is selected
    if ($client) {
        $builder->where('client.cid', $client);
    }

    // Apply product filter only if a product (item_name) is selected
    if ($product) {
        $builder->where('purchaseinv.item_name', $product);
    }

    // Group by orderid and cid to get unique records
    $builder->groupBy('purchaseinv2.orderid, purchaseinv2.cid');

    // Count the unique results by retrieving the grouped data and using count()
    return count($builder->get()->getResult());

    //return $builder->countAllResults();
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




    public function updaterecord($orderid, array $updateData)
    {
        //return $this->update($id, $data); // Update data in the table
        $this->db->table('purchaseinv2')->where('orderid', $orderid)->update($updateData);

    }
    
//     public function deleterecord(int $id)
// {
//     // Use CodeIgniter's built-in delete method
//     return $this->db->table('client')->delete(['cid' => $id]);
// }

    public function deleterecord(string $id)
    {
    	 return $this->db->table('purchaseinv2')->delete(['orderid' => $id]); 
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

 public function getFinancialYears()
{
    return $this->db->table('purchaseinv2')  // Specify the table to query from
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

public function updateBatch(?array $set = null, ?string $index = null, int $batchSize = 100, bool $returnSQL = true)
{
    $index ='orderid';  // Default to the primary key if not provided

    if (empty($set)) {
        return false; // No data to update
    }

    try {
        // Use 'purchaseinv2' as the table name
        return $this->db->table('purchaseinv2')->updateBatch($set, $index, $batchSize);
    } catch (\Exception $e) {
        log_message('error', 'UpdateBatch failed: ' . $e->getMessage());
        return false;
    }
}


public function printpurchaseinvdata($orderid)
{
    if (!$orderid) {
        return false; // Return false or handle the case where order ID is missing
    }

    $builder = $this->db->table('purchaseinv2');
    $builder->select('client.*, purchaseinv2.*');
    $builder->join('client', 'purchaseinv2.cid = client.cid', 'inner');
    $builder->where('purchaseinv2.orderid', $orderid);

    $query = $builder->get();
    return $query->getResultArray(); // Return the fetched data as an array
}

public function getInvoices($startDate = null, $endDate = null, $item = null, $customer = null, $ctype=null)
{
    // Base SQL query
    $sql = "SELECT 
                ROW_NUMBER() OVER () AS id, 
                purchaseinv.item_name AS item, 
                purchaseinv2.invid AS `inv no`, 
                purchaseinv2.invdate AS `inv date`, 
                client.c_name AS client, 
                SUBSTRING_INDEX(client.c_add, ',', -1) AS location, 
                client.gst AS GST, 
                client.c_type AS c_type, 
                purchaseinv2.subtotal AS subtotal, 
                purchaseinv2.taxrate AS taxrate, 
                purchaseinv2.taxamount AS taxamount, 
                purchaseinv2.totalamount AS totalamount 
            FROM purchaseinv2 
            INNER JOIN purchaseinv ON purchaseinv.orderid = purchaseinv2.orderid 
            INNER JOIN client ON purchaseinv2.cid = client.cid";

    // Add conditions dynamically
    $conditions = [];
    $params = [];

    
    if (!empty($customer)) {
        $conditions[] = "client.cid = ?";
        $params[] = $customer;
    }

if (!empty($startDate) && !empty($endDate)) {
        $conditions[] = "purchaseinv2.invdate BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
    }


    //  if (!empty($ctype)) {
    //     $conditions[] = "client.u_type = ?";
    //     $params[] = $ctype;
    // }

    // Append conditions to SQL query
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // Add GROUP BY clause
    $sql .= " GROUP BY purchaseinv.orderid";

    //echo $sql;

    // Execute the query
    $query = $this->db->query($sql, $params);

    // Return the results
    return $query->getResult();
}


public function getItemreport($startDate = null, $endDate = null, $item = null)
{
    $sql = "
        SELECT 
            ROW_NUMBER() OVER () AS id,
            purchaseinv2.invdate, 
            purchaseinv.item_name AS item, 
            purchaseinv.item_desc AS description, 
            purchaseinv.hsn, 
            purchaseinv.price,
            purchaseinv.quantity, 
            purchaseinv.total AS subtotal, 
            purchaseinv2.taxrate, 
            purchaseinv2.taxamount,
            purchaseinv2.totalamount
 
        FROM 
            purchaseinv2 
        INNER JOIN 
            purchaseinv ON purchaseinv.orderid = purchaseinv2.orderid 
        INNER JOIN 
            products ON purchaseinv.item_name = products.name
    ";

    // Initialize conditions and parameters
    $conditions = [];
    $params = [];

    // Add date range condition
    if (!empty($startDate) && !empty($endDate)) {
        $conditions[] = "purchaseinv2.invdate BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
    }

    // Add item condition
    if (!empty($item)) {
        $conditions[] = "purchaseinv.item_name = ?";
        $params[] = $item;
    }

    // Ensure at least one condition is applied
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    } else {
        // No conditions provided; return an empty result
        return [];
    }

    // Execute the query
    $query = $this->db->query($sql, $params);

    // Return the results
    return $query->getResult();
}


}
?>