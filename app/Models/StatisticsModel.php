<?php

namespace App\Models;

use CodeIgniter\Model;

class StatisticsModel extends Model
{
    protected $tableClients = 'client';
    protected $tableInvoices = 'invtest2';

    public function getClientCountForCurrentMonth()
    {
        $currentMonth = date('Y-m');
        return $this->db->table($this->tableClients)
            ->where('DATE_FORMAT(created, "%Y-%m")', $currentMonth)
            ->countAllResults();
    }

    public function getInvoiceTotalForCurrentMonth()
    {
        $currentMonth = date('Y-m');
        return $this->db->table($this->tableInvoices)
            ->selectSum('totalamount', 'invoice_total')
            ->where('DATE_FORMAT(created, "%Y-%m")', $currentMonth)
            ->get()
            ->getRow()
            ->invoice_total ?? 0;
    }

    public function getInvCountForCurrentMonth()
    {
        $currentMonth = date('Y-m');
        return $this->db->table($this->tableInvoices)
            ->selectCount('invid', 'invcount')
            ->where('DATE_FORMAT(created, "%Y-%m")', $currentMonth)
            ->get()
            ->getRow()
            ->invcount ?? 0;
    }

public function getBounceRate()
{
    // Get current and previous month in 'Y-m' format
    $currentMonth = date('Y-m');
    $previousMonth = date('Y-m', strtotime('-1 month'));

    // Get current month turnover
    $currentTurnover = $this->db->table($this->tableInvoices)
        ->selectSum('totalamount', 'invoice_total')
        ->where('DATE_FORMAT(created, "%Y-%m")', $currentMonth)
        ->get()
        ->getRow()
        ->invoice_total ?? 0;

    // Get previous month turnover
    $previousTurnover = $this->db->table($this->tableInvoices)
        ->selectSum('totalamount', 'invoice_total')
        ->where('DATE_FORMAT(created, "%Y-%m")', $previousMonth)
        ->get()
        ->getRow()
        ->invoice_total ?? 0;

    // Avoid division by zero
    if ($previousTurnover == 0) {
        return 0; // No previous data, bounce rate is 0%
    }

    // Calculate bounce rate
    $bounceRate = (($currentTurnover - $previousTurnover) / $previousTurnover) * 100;

    return round($bounceRate, 2); // Return bounce rate with 2 decimal places
}



    public function gettreechart()
    {
        $query = "
            SELECT 
               DISTINCT  SUBSTRING_INDEX(client.c_add, ',', -1) AS location, 
                COUNT(*) AS count 
            FROM 
                invtest 
            INNER JOIN 
                invtest2 ON invtest.orderid = invtest2.orderid 
            INNER JOIN 
                client ON invtest2.cid = client.cid 
            GROUP BY 
                location
            ORDER BY 
                count DESC limit 25

        ";

        $result=$this->db->query($query)->getResultArray();
                foreach ($result as &$stat) {
            $stat['location'] = str_replace("\n", '', $stat['location']);
        }

        return $result;

    }
    public function consumablesSold($startyear, $endyear)
{
    // Your query is fine, assuming you pass start and end year as parameters
    $query = "
        SELECT item_name, SUM(quantity) AS item_sold, invtest2.created 
        FROM invtest 
        INNER JOIN invtest2 ON invtest.orderid = invtest2.orderid 
        INNER JOIN products ON invtest.item_name = products.name 
        WHERE products.p_type = 'Consumables' 
        AND invtest2.created BETWEEN '$startyear-04-01' AND '$endyear-03-31' 
        GROUP BY item_name 
        ORDER BY SUM(quantity) DESC 
        LIMIT 6
    ";

    // Execute the query and get the result as an associative array
    $result = $this->db->query($query)->getResultArray();

    // Prepare the data to return
    $data7 = array();

    // Loop through the result and prepare the data array
    foreach ($result as $row) {
        $data7[] = array("label" => $row['item_name'], "value" => $row['item_sold']);
    }

    // Return the processed data
    return $data7;
}

 public function productcategorycount()
{
    // Your query is fine, assuming you pass start and end year as parameters
    $query = "
        SELECT p_type AS Category, COUNT(*) AS CategoryCount FROM products GROUP BY p_type";

    // Execute the query and get the result as an associative array
    $result = $this->db->query($query)->getResultArray();

    // Prepare the data to return
    $data8 = array();

    // Loop through the result and prepare the data array
    foreach ($result as $row) {
        $data8[] = array('label' => $row['Category'], 'value' => $row['CategoryCount']);
    }

    // Return the processed data
    return $data8;
}

public function productcategorycount2($startYear,$endYear)
{
    // Your query is fine, assuming you pass start and end year as parameters
    //$query = "SELECT p_type AS Category, COUNT(*) AS CategoryCount FROM products GROUP BY p_type";

    $query= "SELECT item_name,COUNT(item_name) 'item_sold' FROM invtest INNER JOIN invtest2 on invtest.orderid = invtest2.orderid INNER join products on invtest.item_name = products.name where products.p_type = 'Machine' and invtest2.created BETWEEN '$startYear-04-01' and '$endYear-03-31' GROUP BY item_name ORDER BY COUNT(item_name) DESC LIMIT 5";

    // Execute the query and get the result as an associative array
    $result = $this->db->query($query)->getResultArray();

    // Prepare the data to return
    $data6 = array();

    // Loop through the result and prepare the data array
    foreach ($result as $row) {
        $data6[] = array('label' => $row['item_name'], 'value' => $row['item_sold']);
    }

    // Return the processed data
    return $data6;
}

public function usercategoryCount(){


    $query = "SELECT CASE WHEN CHAR_LENGTH(gst) = 15 THEN 'GST' WHEN CHAR_LENGTH(gst) IN (10, 9) THEN 'PAN' WHEN CHAR_LENGTH(gst) = 12 THEN 'Adhaar' ELSE 'TIN' END AS category, COUNT(*) AS count FROM client GROUP BY category";

    $result = $this->db->query($query)->getResultArray();

    // Prepare the data to return
    $data9 = array();

    // Loop through the result and prepare the data array
    foreach ($result as $row) {
        $data9[] = array('label' => $row['category'], 'value' => $row['count']);
    }
     return $data9;
}

public function clientcountryCount(){
    // Query 2: Count of clients by country
$query = "SELECT country, COUNT(*) AS country_count FROM client GROUP BY country";
$result = $this->db->query($query)->getResultArray();

    // Prepare the data to return
    $data10 = array();

    // Loop through the result and prepare the data array
    foreach ($result as $row) {
        $data10[] = array('label' => $row['country'], 'value' => $row['country_count']);
    } 
    return $data10;
}

public function docCount(){
    // Query 2: Count of clients by country
$query = "SELECT CASE WHEN t2.cid IS NULL THEN 'Non-Billed Clients' ELSE 'Billed Clients' END AS client_category, COUNT(*) AS client_count FROM client t1 LEFT JOIN invtest2 t2 ON t1.cid = t2.cid GROUP BY client_category";

$result = $this->db->query($query)->getResultArray();

    // Prepare the data to return
    $data11 = array();

    // Loop through the result and prepare the data array
    foreach ($result as $row) {
        $data11[] = array('label' => $row['client_category'], 'value' => $row['client_count']);
    } 
    return $data11;
}

   
public function doczCount($startyear,$endyear){
    // Query 2: Count of clients by country
$query = "SELECT 'Proforma Invoice' AS PI, COUNT(invid) AS Count FROM protest2 UNION ALL SELECT 'Tax Invoice' AS TaxInv, COUNT(invid) AS Count FROM invtest2 UNION ALL SELECT 'Quotation' AS Quote, COUNT(quote2.invid) AS Count FROM quote2 UNION ALL SELECT 'Quick Quotation' AS qquote, COUNT(quickquote.q_id) AS Count FROM quickquote WHERE created BETWEEN '$startyear-04-01' AND '$endyear-03-31' ORDER BY Count DESC";

$result = $this->db->query($query)->getResultArray();

    // Prepare the data to return
    $data12 = array();

    // Loop through the result and prepare the data array
    foreach ($result as $row) {
        $data12[] = array('label' => $row['PI'], 'value' => $row['Count']);
    } 
    return $data12;
}



public function allyeardata(){
    $query = "WITH ItemData AS ( SELECT CONCAT( YEAR(inv2.created) - IF(MONTH(inv2.created) < 4, 1, 0), '-', 
            YEAR(inv2.created) - IF(MONTH(inv2.created) < 4, 0, -1)) AS financial_year, inv.item_name, SUM(inv.quantity) AS total_quantity, 
        ROW_NUMBER() OVER(
            PARTITION BY CONCAT(
                YEAR(inv2.created) - IF(MONTH(inv2.created) < 4, 1, 0), 
                '-', 
                YEAR(inv2.created) - IF(MONTH(inv2.created) < 4, 0, -1)
            ) 
            ORDER BY SUM(inv.quantity) DESC, SUM(inv.quantity * inv.price) DESC) AS row_num FROM invtest inv 
        INNER JOIN products ON products.name = inv.item_name AND products.p_type = 'Machine' 
        JOIN invtest2 inv2 ON inv.orderid = inv2.orderid GROUP BY 
        CONCAT(
            YEAR(inv2.created) - IF(MONTH(inv2.created) < 4, 1, 0), 
            '-', 
            YEAR(inv2.created) - IF(MONTH(inv2.created) < 4, 0, -1)
        ), 
        inv.item_name), FinancialYearData AS (
    SELECT CONCAT( YEAR(created) - IF(MONTH(created) < 4, 1, 0), 
            '-', 
            YEAR(created) - IF(MONTH(created) < 4, 0, -1)) AS financial_year, SUM(taxamount) AS GST, SUM(totalamount) AS Turnover FROM invtest2 GROUP BY financial_year) SELECT i.item_name,  i.total_quantity,  i.financial_year,  f.GST,  f.Turnover FROM ItemData i JOIN FinancialYearData f ON i.financial_year = f.financial_year WHERE i.row_num = 1  ORDER BY  i.financial_year DESC,i.item_name";

            

    $result = $this->db->query($query)->getResultArray();
    $data13=array();

    foreach ($result as $row) {
        $data13[] = array("y" => $row['financial_year'] , "a" =>($row['Turnover']), 
          "b" =>($row['GST']), "c" =>($row['total_quantity']),"label" =>($row['item_name']));
    } 
    return $data13;
}


public function allyearsalesdata($startyear, $endyear){
    $query = "SELECT query1.Months, query1.Turnover, query1.Tax, query2.item_name, query2.item_sold FROM ( select date_format(created,'%b') 'Months',sum(totalamount) 'Turnover',sum(taxamount) 'Tax' from invtest2 WHERE created between '$startyear-04-01' AND '$endyear-03-31' group by year(created),month(created) ) query1 JOIN ( SELECT DATE_FORMAT(invtest2.created, '%b') AS Months, item_name, COUNT(item_name) AS item_sold, invtest2.created, RANK() OVER (PARTITION BY DATE_FORMAT(invtest2.created, '%Y-%m') ORDER BY COUNT(item_name) DESC, SUM(total) DESC) AS item_rank FROM invtest INNER JOIN invtest2 ON invtest.orderid = invtest2.orderid INNER JOIN products ON invtest.item_name = products.name WHERE products.p_type = 'Machine' AND invtest2.created BETWEEN '$startyear-04-01' AND '$endyear-03-31' GROUP BY item_name, DATE_FORMAT(invtest2.created, '%Y-%m') ) query2 ON query1.Months = query2.Months WHERE query2.item_rank = 1";

    $result = $this->db->query($query)->getResultArray();
    $data14=array();

    foreach ($result as $row) {
        $data14[] = array("y" => $row['Months'] , "a" =>($row['Turnover']), 
          "b" =>($row['Tax']), "c" =>($row['item_sold']),"label" =>($row['item_name']));
    } 
    return $data14;
}

public function getInvoiceStatsForFinancialYear($startYear, $endYear)
{
    // Define the financial year range
    $startDate = "$startYear-04-01";
    $endDate = "$endYear-03-30";

    return $this->db->table('invtest2')
        ->select('COUNT(invid) as total_invoices, SUM(totalitems) as total_items, SUM(totalamount) as total_amount, SUM(taxamount) as total_tax')
        ->where('created >=', $startDate)
        ->where('created <=', $endDate)
        ->get()
        ->getRow();
        
}



public function clientreminder(){
    $query="SELECT 
    protest2.invid, 
    client.c_name, 
    client.mob, 
    GROUP_CONCAT(protest.item_name SEPARATOR ', ') AS item_name
FROM 
    protest2 
INNER JOIN 
    protest ON protest2.orderid = protest.orderid 
INNER JOIN 
    client ON protest2.cid = client.cid 
GROUP BY 
    protest2.invid, client.c_name, client.mob
ORDER BY 
    protest2.invid DESC 
LIMIT 7";

  
    return $this->db->query($query)->getResultArray();

}

public function getFinancialYears()
    {
        $query = $this->db->query("
            SELECT CASE 
                WHEN MONTH(created) >= 4 
                THEN CONCAT(YEAR(created), '-', YEAR(created) + 1) 
                ELSE CONCAT(YEAR(created) - 1, '-', YEAR(created)) 
            END AS financial_year 
            FROM invtest2 
            GROUP BY financial_year 
            ORDER BY financial_year DESC limit 5
        ");

        return $query->getResultArray();
    }


public function getclienttypecount()
{
    $query = "SELECT 
        CASE 
            WHEN client.u_type = 0 THEN 'Client' 
            WHEN client.u_type = 1 THEN 'Supplier' 
            WHEN client.u_type = 2 THEN 'Dual (Cust/Sup)' 
            ELSE 'Unknown' 
        END AS user_type, 
        COUNT(client.u_type) AS count 
    FROM client 
    GROUP BY client.u_type";

    // Execute the query properly
    $result = $this->db->query($query)->getResultArray();

    // Prepare the data to return
    $data15 = [];

    // Loop through the result and prepare the data array
    foreach ($result as $row) {
        $data15[] = [
            'label' => $row['user_type'], 
            'value' => $row['count']
        ];
    } 
    return $data15;
}

public function Quickquotereminder(){
    $query = "SELECT quickquote.q_id, products.name, quickquote.mob, quickquote.quantity, quickquote.subtotal, quickquote.gst, quickquote.total 
              FROM quickquote 
              INNER JOIN products ON products.p_id = quickquote.p_id 
              ORDER BY quickquote.q_id DESC 
              LIMIT 7";

    return $this->db->query($query)->getResultArray();
}


}
?>