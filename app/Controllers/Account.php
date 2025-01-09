<?php

namespace App\Controllers;

use App\Models\Account_model;
use App\Models\Client_model; // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;
use App\Models\Acctype_model;

class Account extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Account_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function home()
{
     $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}      
    return view('layout/manage-account');
}



public function getledger($cid)
{
    $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}
    // Load the Account model
    $accountModel = new Account_model();

    // Set the default financial year range
    if (date('m') > 3) {
        $defaultYear = date('Y') . "-" . (date('Y') + 1);
    } else {
        $defaultYear = (date('Y') - 1) . "-" . date('Y');
    }
    $startyear = substr($defaultYear, 0, 4);
    $endyear = substr($defaultYear, 5, 8);

    // Fetch ledger details based on cid and the financial year range
    $ledgerDetails = $accountModel->getLedgerDetails($cid, $startyear, $endyear);

    // Fetch additional account and client details
    $accountInfo = $accountModel->getAccountInfo($cid); // Assuming this fetches u_type, opening balance, client name, and address

    // Check if accountInfo was successfully retrieved
    if (!$accountInfo) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Account or client information not found");
    }


    if (date('m') > 3) {
            $year = date('y') . "-" . (date('y') + 1);
        } else {
            $year = (date('y') - 1) . "-" . date('y');
        }

    $date = date('Y-m-d');
    $db = \Config\Database::connect();


        // SQL query to get the next invoice ID
        $datalogger = "
            SELECT CONCAT_WS('/', '$year', COALESCE(LPAD(
                CASE 
                    WHEN '$date' >= DATE_FORMAT('$date','%Y-04-01') 
                    THEN SUM(created >= DATE_FORMAT('$date','%Y-04-01')) 
                    ELSE SUM(created BETWEEN DATE_FORMAT('$date','%Y-04-01') - INTERVAL 1 YEAR AND DATE_FORMAT('$date','%Y-04-01'))
                END + 1, 4, 0)
            , LPAD(1, 4, 0))) AS pay_id 
            FROM paidhistory";

         //echo $datalogger;   


        // Execute the query
        $stmt = $db->query($datalogger);
        $row = $stmt->getRow();

        // Determine the invoice number
        if ($row) {
            $value2 = $row->pay_id;

            // Separate numeric part
            $value2 = substr($value2, 6, 4);

            // Concatenate incremented value
            $value2 = "\n T/" . $year . "/" . sprintf('%04s', $value2);
            $value = $value2;
        } else {
            // No records found, start from 0001
            $value = "T/" . $year . "/0001";
        }


    return view('info layout/getledger', [
     'cid'=> $cid,   
    'u_type' => $ledgerDetails['u_type'],
    'ledgerDetails' => $ledgerDetails['ledger'],  // Pass only the ledger array
    'accountInfo' => $accountInfo,
    'pay_id'=> $value
]);

}


// public function reportdrcr()
// {
//     return view('report/report_dcrcr');
// }

public function demo(){
    $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}

    $cddata=new Acctype_model();

    $cz=$cddata->getAccountTypeDetails();

     $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($cz),
        "iTotalDisplayRecords" => count($cz),
        "aaData" => $cz
    ];

    // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }

    // Prepare data for view
    $data = [
        'results' => json_encode($results)
    ];


    return view('layout/addview',$data);
}


public function get_next_id()
{
    try {
        // Your logic to get the next ID
        $next_id = $this->crudModel->get_last_cid(); // Adjust this line based on your logic
        return $this->response->setJSON(['next_id' => $next_id]);
    } catch (Exception $e) {
        log_message('error', 'Failed to get next ID: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to fetch next ID.']);
    }
}


public function manageaccounts()
{
    $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}

    $accountModel = new \App\Models\Account_Model();

    // Fetch all records using the custom method
    $records = $accountModel->getAccountDetails();


    $last_cid = $this->crudModel->get_last_cid();
    $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;

    // Format the data for DataTables
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($records),
        "iTotalDisplayRecords" => count($records),
        "aaData" => $records
    ];

    // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }

    // Prepare data for view
    $data = [
        'next_cid' => $next_cid,
        'results' => json_encode($results)
    ];

    return view('layout/manage-account', $data);
}


public function getclient()
{
    $this->crudModel2 = new Client_model();
    $categoryName = $this->request->getGet('category_name');
    $results = [];

    // Get cids from the account table
    $accountedClientIds = $this->crudModel->select('cid')->get()->getResultArray();
    $excludedIds = array_column($accountedClientIds, 'cid');

    // Build query
    if ($categoryName) {
        // Use LIKE query with wildcards and exclude `cid` in the `account` table
        $clients = $this->crudModel2
                        ->whereNotIn('cid', $excludedIds)
                        ->like('c_name', $categoryName, 'both') // Match partial strings in `c_name`
                        ->findAll();
    } else {
        // If no category name is provided, retrieve all clients excluding those in `account`
        $clients = $this->crudModel2
                        ->whereNotIn('cid', $excludedIds)
                        ->findAll();
    }

    // Format the results for Select2
    foreach ($clients as $client) {
        $results[] = [
            'id' => $client['cid'],
            'text' => $client['c_name'],
            'c_add' => $client['c_add']
        ];
    }

    return $this->response->setJSON($results);
}


   


public function insert() {

    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

            $last_cid = $this->crudModel->get_last_cid();
            $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;

        
              //$this->crudModel->set_auto_increment();
                    
            $this->crudModel2 = new Client_model();

            $cid=$this->request->getPost('ctype');

            $client = $this->crudModel2->where('cid', $cid)->first(); // Assuming `cid` is the column name

            // Check if the client record was found and retrieve `u_type`
        if ($client) {
            $utype = $client['u_type']; // Extract `u_type` value
        } 

        $created = $this->request->getPost('created');

            // Convert the input date to DateTime object
            $date = new \DateTime($created);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');

            // Prepare data for insertion
            $data = [
                'aid'      => $this->request->getPost('aid'),
                'cid'   => $this->request->getPost('ctype'),
                'opening_bal'   => $this->request->getPost('opbal'),
                                
                'acc_type'   => $utype, // Ensure this is included
                'created'  => $formattedDate,
            ];
            //print_r($this->request->getPost());

            //print_r($data);   
            // Attempt to save the record
            $response = $this->crudModel->saverecords($data);

            //echo $this->crudModel->setQuery($response);


            //print_r($response);

            $lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query


            if ($response) {

                
            
                // Return success response in JSON format
                return $this->response->setJSON([
                    'res' => 'success',
                    'message' => 'Records saved successfully.',
                    'query' => (string) $lastQuery, // Include the last query in the response

                //'redirect' => base_url('/client/manageclients'), 
                ]);
                
            } else {
                $error = $this->db->error();

                // Return error response if insertion fails
                return $this->response->setJSON([
                    'res' => 'error',
                    //'message' => 'Insert failed.',
                    'message' => $error['message'],
            'code' => $error['code'],
                ]);
            }
       
    } else {
        // If not a valid request, return an error
        return $this->response->setJSON([
            'res' => 'error',
            'message' => 'Invalid Request'
        ]);
    }
}



public function delete(int $id)
{
    // Log the ID to confirm it's correct
    log_message('debug', 'Deleting record with ID: ' . $id);

    // Ensure the request is AJAX
    if ($this->request->isAJAX()) {

          // Check if deleterecord method exists in the model
        if (!method_exists($this->crudModel, 'deleterecord')) {
            return $this->response->setJSON([
                'res' => 'error',
                'message' => 'Delete method not found.'
            ]);
        }
        // Delete the record from the database
        $delete = $this->crudModel->deleterecord($id);

        if ($delete) {
            return $this->response->setJSON([
                'res' => 'success',
                'message' => 'Record deleted successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'res' => 'error',
                'message' => 'Failed to delete the record.'
            ]);
        }
    }

    return $this->response->setStatusCode(400)->setJSON([
        'res' => 'error',
        'message' => 'Invalid request.'
    ]);
}


// public function delete() {
//     $del_id = $this->request->getGet('del_id');
    
//     if ($this->crudModel->deleteRecord($del_id)) {
//         return $this->response->setJSON(['res' => 'success']);
//     } else {
//         return $this->response->setJSON(['res' => 'error']);
//     }
// }



    public function edit()
   {
        if ($this->request->getMethod() === 'get' || $this->request->isAJAX()) {  // Corrected to use $this->request->isAJAX()

        $edit_id = $this->request->getGet('edit_id');  // Corrected to use $this->request->getGet()

        if ($post = $this->crudModel->single_entry($edit_id)) {
            $data = array('res' => "success", 'post' => $post);
        } else {
            $data = array('res' => "error", 'message' => "Failed to fetch data");
        }

        return $this->response->setJSON($data);  // Return JSON response
    } else {
        return $this->response->setJSON([
            'res' => 'error',
            'message' => 'No direct script access allowed'
        ]);
    }
}


    // Example controller method (updaterecord)
public function update()
{
    $openingBal = $this->request->getPost('opening_bal');
    $cid = $this->request->getPost('cid');
    $aid = $this->request->getPost('aid');

        // echo "\n".$openingBal;
        // echo "\n".$cid;
        // echo "\n".$aid;

  // Load the model
    $accountModel = new Account_model();

    // Data to update
    $data = [
        'opening_bal' => $openingBal,
        'cid' => $cid,
    ];

    // Call the model's updaterecord method
    $update = $accountModel->updaterecord($data, $aid);

    if ($update) {
        return $this->response->setJSON(['res' => 'success', 'message' => 'Record updated successfully!']);
    } else {
        return $this->response->setJSON(['res' => 'error', 'message' => 'Failed to update record.']);
    }
}



}
?>