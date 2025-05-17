<?php

namespace App\Controllers;

use App\Models\Supplier_model; // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

class Supplier extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Supplier_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }



// In your get_next_id controller method
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


public function viewsupplierinfo($infoid) {
   
   $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
} else {
    return redirect()->to(base_url().'/login');
}

    //$productModel = new Product_model();
    $supplierModel = new Supplier_model();

    // Fetch product details
   $supplierDetails = $supplierModel->getSupplierDetails($infoid);

   $financialYears = $supplierModel->getFinancialYearTotals($infoid);


    // Fetch tax invoices (assuming it's a list of invoices related to this product)
    $taxinvoice = $supplierModel->getsupplierinv($infoid);


    $saleinvoice= $supplierModel->getsuppliersalesinv($infoid);

    // if($supplierModel['u_type']==2)
    // {
    //     $saleinvoice== $supplierModel->getsupplierinv($infoid);
    // }
    
   $proinvoice = $supplierModel-> getsupplierproinv($infoid);


    // Format the data for the DataTable
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

    
      $results3 = [
        "sEcho" => 1,
        "iTotalRecords" => count($saleinvoice),
        "iTotalDisplayRecords" => count($saleinvoice),
        "aaData" => $saleinvoice
    ];


    // Prepare the data array for passing to the view
    $data = [
        'financialYears' => $financialYears,
        'supplierDetails' => $supplierDetails,
        'taxInvoices' => json_encode($results), 
        'proInvoices' => json_encode($results2),
        'saleInvoice'=> json_encode($results3)// Pass JSON-encoded results
    ];


    return view('info layout/getsupplierinfo', ['supplierDetails' => $supplierDetails, 
        'financialYears' => $financialYears, 
        'taxInvoices'=> json_encode($results),
        'proInvoices'=> json_encode($results2),
        'saleInvoices'=> json_encode($results3),
        'infoid'=> $infoid,
        
        ]);

}



public function managesupplier()
{
    $session = session(); 
      if ($session->has('user_id')) {
        //echo "User ID: " . $session->get('user_id');
    } else {
        return redirect()->to(base_url().'/login');
    }

    // Get the last client ID and calculate the next one
    $last_cid = $this->crudModel->get_last_cid();
    $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;

    // Fetch all records
      //$records = $this->crudModel->where('u_type', 1)->findAll();
    $records = $this->crudModel->whereIn('u_type', [1, 2])->findAll();

    // Debugging: Log the SQL query to see what's happening
    log_message('debug', $this->crudModel->getLastQuery());



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

    return view('layout/manage-suppliers', $data);
}



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

            //$u_type1 = $this->request->getPost('utype1');


            $u_type1 = $this->request->getPost('utype');
            // if($u_type1)
            // {
            //     echo $u_type1;
            // }
            // else {
            //     echo "not found";
            // }
            $u_type = (int)$u_type1;
            //print_r($u_type);  // Check if this is now an integer (0, 1, 2, etc.)


           // print_r("print in contoller code".$u_type1);
            // Prepare data for insertion
            $data = [
               
                'c_name'   => $this->request->getPost('c_nameedit'),
                'c_add'    => $this->request->getPost('c_addedit'),
                'mob'      => $this->request->getPost('fullno'),
                'country' => $this->request->getPost('fulldetails2'),    
                'gst'      => strtoupper($this->request->getPost('gstedit')),
                'email'      => $this->request->getPost('email1'),
                'c_type'   => $this->request->getPost('ctypeedit'),
                'u_type'   => $u_type,
                //'created'  => $formattedDate,
            ];

            //print_r($data);
            
            $response = $this->crudModel->updaterecord($cid, $data);
             $lastQuery = $this->crudModel->getLastQuery();

             print_r($response);

            if ($response) {
                
                print_r($response);
                
                return $this->response->setJSON([
                    'res' => 'success',
                    'message' => 'Records updated successfully.',
                'query' => (string) $lastQuery,
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

    
}
?>