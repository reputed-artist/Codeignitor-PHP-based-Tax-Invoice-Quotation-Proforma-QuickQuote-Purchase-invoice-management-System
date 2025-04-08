<?php

namespace App\Controllers;

use App\Models\Client_model; // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

class Client extends Controller
{
    protected $crudModel;

    public function __construct()
    {

        $this->crudModel = new Client_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();

        $session = session();


    }


public function viewclientinfo($infoid)
{
    $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}

        // Validate the infoid
    // if (!$infoid || !is_numeric($infoid)) {
    //     return redirect()->to('client/manageclients')->with('error', 'Invalid Client ID.');
    // }

    // Load the model
    $clientModel = new Client_model();

    // Fetch client details
    $clientDetails = $clientModel->getClientDetails($infoid);

    // Fetch financial year totals
    $financialYears = $clientModel->getFinancialYearTotals($infoid);


    $taxinvoice = $clientModel-> getTaxinvoices($infoid);

    $proinvoice=$clientModel->getProinvoices($infoid);

     $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($taxinvoice),
        "iTotalDisplayRecords" => count($taxinvoice),
        "aaData" => $taxinvoice
    ];


     $results2 = [
        "sEcho" => 1,
        "iTotalRecords" => count($proinvoice),
        "iTotalDisplayRecords" => count($proinvoice),
        "aaData" => $proinvoice
    ];


    // Check if data is available
    // if (empty($clientDetails) || empty($financialYears)) {
    //     return redirect()->to('client/manageclients')->with('error', 'No data found for this Client ID.');
    // }

        // Prepare data for the view
    $data = [
        'clientDetails' => $clientDetails,
        'financialYears' => json_encode($financialYears), // JSON-encoded for JavaScript usage
        'taxInvoices' => json_encode($results),           // Pass results JSON
        'proInvoices' => json_encode($results2),          // Pass results2 JSON
    ];

    // Return the view with data
    return view('info layout/getclientinfo', $data);
}


public function get_next_id()
{
    try {
        $crudModel=new Client_model();
        // Your logic to get the next ID
        $next_id = $crudModel->get_last_cid(); // Adjust this line based on your logic
        return $this->response->setJSON(['next_id' => $next_id]);
    } catch (Exception $e) {
        log_message('error', 'Failed to get next ID: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to fetch next ID.']);
    }
}


public function manageclients()
{
    $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}
    //$this->checkSession(); 

    // Get the last client ID and calculate the next one
    $last_cid = $this->crudModel->get_last_cid();
    $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;

    // Fetch all records
    //$records = $this->crudModel->findAll();

    $records = $this->crudModel->whereIn('u_type',[0,2])->findAll();
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

    // Otherwise, return the view with JSON-encoded data
    $data = [
        'next_cid' => $next_cid,
        'results' => json_encode($results)
    ];

    return view('layout/manage-clients', $data);
}


public function getallclients()
{
    

    $records = $this->crudModel->findAll();
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

    // Otherwise, return the view with JSON-encoded data
    $data = [
    
        'results' => json_encode($results)
    ];

    return  $data;
}


   
// public function showdata()
// {
//      // Fetch all records from the model
//     $records = $this->crudModel->findAll();

//     // Format the data in the structure DataTables expects
//     $results = [
//         "sEcho" => 1,
//         "iTotalRecords" => count($records),
//         "iTotalDisplayRecords" => count($records),
//         "aaData" => $records
//     ];

//     // Return the JSON response
//     return $this->response->setJSON($results);    
// }

public function insert() {

    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

            $last_cid = $this->crudModel->get_last_cid();
            $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;

        
              //$this->crudModel->set_auto_increment();
        

            $created = $this->request->getPost('created');

            // Convert the input date to DateTime object
            $date = new \DateTime($created);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');

            // Prepare data for insertion
            $data = [
                'cid'      => $next_cid,
                'c_name'   => $this->request->getPost('c_name'),
                'c_add'    => $this->request->getPost('c_add'),
                'mob'      => $this->request->getPost('fullno'),
                'country'  => $this->request->getPost('fulldetails'),
                'gst'      => strtoupper($this->request->getPost('gst')),
                'email'    => $this->request->getPost('email'), // Ensure this is included
                'c_type'   => $this->request->getPost('ctype'),
                'u_type'   => $this->request->getPost('u_type'), // Ensure this is included
                'created'  => $formattedDate,
            ];
            //print_r($this->request->getPost());

            //print_r($data);   
            // Attempt to save the record
            $response = $this->crudModel->saverecords($data);

            //echo $this->crudModel->setQuery($response);


            //print_r($response);

            $lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query
            //echo $lastQuery;

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



public function delete($id)
{
    // Log the ID to confirm it's correct
    log_message('debug', 'Deleting record with ID: ' . $id);

    // Ensure the request is AJAX
    if ($this->request->isAJAX()) {
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

public function update() {

    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

            
            log_message('debug', 'Request data: ' . print_r($this->request->getGet(), true)); 

            $created = $this->request->getPost('created');

            // Convert the input date to DateTime object
            $date = new \DateTime($created);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');

            $cid=$this->request->getPost('cid');

            log_message('debug', 'CID: ' . $cid); // Log the cid value


            // Prepare data for insertion
            $data = [
               
                'c_name'   => $this->request->getPost('c_nameedit'),
                'c_add'    => $this->request->getPost('c_addedit'),
                'mob'      => $this->request->getPost('fullno2'),
                'country' => $this->request->getPost('fulldetails2'),    
                'gst'      => $this->request->getPost('gstedit'),
                'email'      => $this->request->getPost('email1'),
                'c_type'   => $this->request->getPost('ctypeedit'),
                'u_type'   => $this->request->getPost('u_type'),
                //'created'  => $formattedDate,
            ];

            //print_r($data);


        //log_message('debug', 'Update Data: ' . print_r($data, true)); 

             //print_r($data);   
            // Attempt to save the record
            $response = $this->crudModel->updaterecord($cid, $data);
            $lastQuery = $this->crudModel->getLastQuery();

             //print_r($response);

            if ($response) {
                //print_r($response);
                // Return success response in JSON format
                return $this->response->setJSON([
                    'res' => 'success',
                    'message' => 'Records updated successfully.',
                'query' => (string) $lastQuery, // Include the last query in the response
 
                ]);
                
            } else {
                //print_r($response);
                // Return error response if insertion fails
                return $this->response->setJSON([
                    'res' => 'error',
                    'message' => 'Insert failed.'
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




public function getclientinfo($cid)
{
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


    return view('info layout/getledger', [
    'u_type' => $ledgerDetails['u_type'],
    'ledgerDetails' => $ledgerDetails['ledger'],  // Pass only the ledger array
    'accountInfo' => $accountInfo
]);

}
    
}
?>