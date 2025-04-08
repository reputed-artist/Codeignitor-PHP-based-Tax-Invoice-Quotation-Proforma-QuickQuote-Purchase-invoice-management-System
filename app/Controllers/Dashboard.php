<?php

namespace App\Controllers;

use App\Models\Client_model;
use App\Models\Product_model; 
use App\Models\Invtest_model;
use App\Models\Invtest_model2;
use App\Models\Protest_model;
use App\Models\Protest_model2;
use App\Models\Quote_model; 
use App\Models\Quote_model2;
use App\Models\StatisticsModel;
  // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;


class Dashboard extends Controller
{
    protected $crudModel;

    public function __construct()
    {
    
        
        $this->statisticsModel = new StatisticsModel();
        //$this->crudModel = new Client_model(); // Load model

        helper(['url', 'navigation', 'getProfileImage', 'money_format']); 

        helper('getState');


        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function Dashboard2()
    {


        return view('layout/dashboard-layout2');
    }

    public function index()
   {

    $session = session(); 
    if ($session->has('user_id')) {
            //echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }

        

    $crudModel = new Client_model();
    $crudModel2 = new Invtest_model2();

    $fy=$this->statisticsModel->getFinancialYears();

    $clientcount=$this->statisticsModel->getClientCountForCurrentMonth();

    $monthturn=$this->statisticsModel->getInvoiceTotalForCurrentMonth();

    $invcount=$this->statisticsModel->getInvCountForCurrentMonth();

    $bounceRate = $this->statisticsModel->getBounceRate(); // Fetch bounce rate

    $currentDate = date('Y-m-d');  // Get the current date

        $month = date('m');  // Get the current month
        $year = date('Y'); 

                if ($month >= 4) {
            // For months from April to December, the current financial year is the current year and next year
            $startYear = $year;
            $endYear = $year + 1;
        } else {
            // For months from January to March, the financial year is the previous year and the current year
            $startYear = $year - 1;
            $endYear = $year;
        } 

     $mainchart=$this->statisticsModel->getInvoiceStatsForFinancialYear($startYear, $endYear);

     $productcategorycount2=$this->statisticsModel->productcategorycount2($startYear, $endYear);


         
         $data = [
        'fy' => $fy,  //fy for chart
        'clientcount'=>$clientcount,  
        'monthturn'=>$monthturn,
        'invcount'=>$invcount,
         'bounceRate' => $bounceRate, // Add bounce rate to data
        'mainchart'=>$mainchart,
        'productcategorycount2'=>$productcategorycount2,
        'startYear'=> $startYear,
        'endYear'=>$endYear
        ];

        //print_r($data);

        if ($this->request->isAJAX()) {
        return $this->response->setJSON($data); // Return JSON data
    }

    
    return view('layout/dashboard-layout', $data);
    }

    public function getCurrentMonthStatistics()
    {
        $clientCount = $this->statisticsModel->getClientCountForCurrentMonth();
        $invoiceTotal = $this->statisticsModel->getInvoiceTotalForCurrentMonth();
        //$turnover = $this->statisticsModel->getTurnoverForCurrentMonth();

        $treechart=$this->statisticsModel->gettreechart();


        $currentDate = date('Y-m-d');  // Get the current date

        $month = date('m');  // Get the current month
        $year = date('Y'); 

                if ($month >= 4) {
            // For months from April to December, the current financial year is the current year and next year
            $startYear = $year;
            $endYear = $year + 1;
        } else {
            // For months from January to March, the financial year is the previous year and the current year
            $startYear = $year - 1;
            $endYear = $year;
        }

    $consumables=$this->statisticsModel->consumablesSold($startYear, $endYear);

    $productcategorycount=$this->statisticsModel->productcategorycount();

    $usercategory=$this->statisticsModel->usercategoryCount();

    $countrycount = $this->statisticsModel->clientcountryCount();

    $doccount = $this->statisticsModel->docCount();

    $doczcount=$this->statisticsModel->doczCount($startYear, $endYear);


    $allyeardata= $this->statisticsModel->allyeardata();

    $clientcategorycount=$this->statisticsModel->getclienttypecount();


    $allyearsalesdata=$this->statisticsModel->allyearsalesdata($startYear, $endYear);

    
 $data = [
        'clientCount' => $clientCount,
         'invoiceTotal' => $invoiceTotal, // JSON-encoded for JavaScript usage
        // 'turnover' => $turnover,  
        'treechart'=> $treechart,
        'consumables'=> $consumables,
        'productcategorycount'=>$productcategorycount,
        'usercategory' => $usercategory,
        'countrycount'=> $countrycount,
        'doccount'=> $doccount,
        'doczcount'=>$doczcount,
        'allyeardata'=> $allyeardata,
        'allyearsalesdata'=>$allyearsalesdata,
        'clientcategorycount'=> $clientcategorycount


                // Pass results JSON
             // Pass results2 JSON
    ];
  
    //print_r($data);
    return $this->response->setJSON($data);

}


public function clientreminder() {
    // Initialize the model
    $crudModel = new StatisticsModel();

    // Fetch records from the model
    $records = $crudModel->clientreminder();

    $records2=$crudModel-> Quickquotereminder();

    // Format the data for DataTables
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($records),
        "iTotalDisplayRecords" => count($records),
        "aaData" => $records
    ];


    $results2 = [
        "sEcho" => 1,
        "iTotalRecords" => count($records2),
        "iTotalDisplayRecords" => count($records2),
        "aaData" => $records2
    ];


   if ($this->request->isAJAX()) {
    return $this->response->setJSON([
        "client_data" => $results,
        "quickquote_data" => $results2
    ]);
}


    // For non-AJAX requests, pass data to the view
    $data = [
        'results' => json_encode($results),
        'results2' => json_encode($results2)
    ];

    return view('layout/dashboard-layout', $data);
}




public function loadData()
    {
        $db = \Config\Database::connect();

        $brand_id = $this->request->getGet('brand_id');
        if (!empty($brand_id)) {
            $startyear = substr($brand_id, 0, 4);
            $endyear = substr($brand_id, 5, 10);
        } else {
            // Default to the current financial year
            if (date('m') >= 4) {
                $financial_year = date('Y') . '-' . (date('Y') + 1);
            } else {
                $financial_year = (date('Y') - 1) . '-' . date('Y');
            }
            $startyear = substr($financial_year, 0, 4);
            $endyear = substr($financial_year, 5, 10);
        }

        // First query - Monthly Turnover & Tax
        $sql = "SELECT query1.Months, query1.Turnover, query1.Tax, query2.item_name, query2.item_sold 
                FROM (
                    SELECT DATE_FORMAT(created,'%b') AS Months, SUM(totalamount) AS Turnover, SUM(taxamount) AS Tax
                    FROM invtest2 
                    WHERE created BETWEEN '$startyear-04-01' AND '$endyear-03-31' 
                    GROUP BY YEAR(created), MONTH(created)
                ) query1 
                JOIN (
                    SELECT DATE_FORMAT(invtest2.created, '%b') AS Months, item_name, COUNT(item_name) AS item_sold, invtest2.created, 
                    RANK() OVER (PARTITION BY DATE_FORMAT(invtest2.created, '%Y-%m') ORDER BY COUNT(item_name) DESC, SUM(total) DESC) AS item_rank
                    FROM invtest 
                    INNER JOIN invtest2 ON invtest.orderid = invtest2.orderid 
                    INNER JOIN products ON invtest.item_name = products.name 
                    WHERE products.p_type = 'Machine' 
                    AND invtest2.created BETWEEN '$startyear-04-01' AND '$endyear-03-31' 
                    GROUP BY item_name, DATE_FORMAT(invtest2.created, '%Y-%m')
                ) query2 
                ON query1.Months = query2.Months 
                WHERE query2.item_rank = 1";

        // Second query - Top 5 Sold Items
        $sql2 = "SELECT item_name, COUNT(item_name) AS item_sold 
                FROM invtest 
                INNER JOIN invtest2 ON invtest.orderid = invtest2.orderid 
                INNER JOIN products ON invtest.item_name = products.name 
                WHERE products.p_type = 'Machine' 
                AND invtest2.created BETWEEN '$startyear-04-01' AND '$endyear-03-31' 
                GROUP BY item_name 
                ORDER BY COUNT(item_name) DESC 
                LIMIT 5";

        $query = $db->query($sql);
        $query2 = $db->query($sql2);

        $data_points = [];
        $data_pro = [];

        foreach ($query->getResultArray() as $row) {
            $data_points[] = [
                'y'     => $row['Months'],
                'a'     => $row['Turnover'],
                'b'     => $row['Tax'],
                'c'     => $row['item_sold'],
                'label' => $row['item_name'],
            ];
        }

        foreach ($query2->getResultArray() as $rw) {
            $data_pro[] = [
                'item_name' => $rw['item_name'],
                'item_sold' => $rw['item_sold'],
            ];
        }

        return $this->response->setJSON([
            'arr1' => $data_points,
            'arr2' => $data_pro
        ]);
    }

        private function indian_number_format($num) {
        $num = "".$num;
        if( strlen($num) < 4) return $num;
        $tail = substr($num, -3);
        $head = substr($num, 0, -3);
        $head = preg_replace("/\B(?=(?:\d{2})+(?!\d))/", ",", $head);
        return $head . "," . $tail;
    }

    // Function to load data based on the 'brand_y' parameter
    public function load_turn()
    {
        $con = \Config\Database::connect();  // Connect to the database

        // Output variable initialization
        $output = '';  

        // Check if brand_y is passed
        if ($this->request->getVar("brand_y")) {
            $brand_y = $this->request->getVar("brand_y");

            if ($brand_y != '') {
                $startyear = substr($brand_y, 0, 4); // Extract start year
                $endyear = substr($brand_y, 5, 10);  // Extract end year

                // Query to get invoice count
                $invtotal = $con->query("SELECT count(invid) FROM `invtest2` WHERE created BETWEEN '$startyear-04-01' AND '$endyear-03-30'");
                $invval = $invtotal->getRowArray();

                // Query to get total items count
                $totalitems = $con->query("SELECT sum(totalitems) FROM `invtest2` WHERE created BETWEEN '$startyear-04-01' AND '$endyear-03-30'");
                $totalitemval = $totalitems->getRowArray();

                // Query to get total amount (turnover)
                $yeartotal = $con->query("SELECT sum(totalamount) FROM `invtest2` WHERE created BETWEEN '$startyear-04-01' AND '$endyear-03-30'");
                $yeartotalval = $yeartotal->getRowArray();

                // Query to get total tax amount
                $taxtotal = $con->query("SELECT sum(taxamount) FROM `invtest2` WHERE created BETWEEN '$startyear-04-01' AND '$endyear-03-30'");
                $taxtotalval = $taxtotal->getRowArray();

                // Return the results in JSON format
                return $this->response->setJSON([
                    "invoices" => $invval['count(invid)'],
                    "totalitems" => $totalitemval['sum(totalitems)'],
                    "turnovery" => $this->indian_number_format($yeartotalval['sum(totalamount)']),
                    "taxy" => $this->indian_number_format($taxtotalval['sum(taxamount)'])
                ]);
            }
        }
    }
}
