<?php

namespace App\Controllers;

use App\Models\Invtest_model;


//use App\Models\Purchaseinv_model2;
use App\Models\Admin_model;

use App\Models\Invtest_model2;

use App\Models\Client_model;

use App\Models\Product_model;

use App\Models\Bank_model;

use App\Models\Delivery_model;

 // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

use CodeIgniter\Database\Database;


class Taxinv extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Invtest_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function gentaxinv()
  {
    $db = \Config\Database::connect();

    $session = session(); 
    
    if ($session->has('user_id')) {
        //echo "User ID: " . $session->get('user_id');
    } else {
        return redirect()->to(base_url().'/login');
    }

             // Determine the financial year based on the current month
        if (date('m') > 3) {
            $year = date('y') . "-" . (date('y') + 1);
        } else {
            $year = (date('y') - 1) . "-" . date('y');
        }

        $date = date('Y-m-d');

        // SQL query to get the next invoice ID
        $datalogger = "
            SELECT CONCAT_WS('/', '$year', COALESCE(LPAD(
                CASE 
                    WHEN '$date' >= DATE_FORMAT('$date','%Y-04-01') 
                    THEN SUM(created >= DATE_FORMAT('$date','%Y-04-01')) 
                    ELSE SUM(created BETWEEN DATE_FORMAT('$date','%Y-04-01') - INTERVAL 1 YEAR AND DATE_FORMAT('$date','%Y-04-01'))
                END + 1, 4, 0)
            , LPAD(1, 4, 0))) AS invid 
            FROM invtest2";

        // Execute the query
        $stmt = $db->query($datalogger);
        $row = $stmt->getRow();

        // Determine the invoice number
        if ($row) {
            $value2 = $row->invid;

            // Separate numeric part
            $value2 = substr($value2, 6, 4);

            // Concatenate incremented value
            $value2 = "\n INV/" . $year . "/" . sprintf('%04s', $value2);
            $value = $value2;
        } else {
            // No records found, start from 0001
            $value = "INV/" . $year . "/0001";
        }

        // Return the generated invoice ID (you can return it as JSON or any format you prefer)
        //return $this->response->setJSON(['invoice_id' => $value]);
    
    // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {
        return $this->response->setJSON(['invoice_id' => $value]);
    }



    return view('layout/gentaxinvoice',['invoice_id' => $value]);      
    //return view('layout/genpurchaseinvoice.php');
}



public function edittaxinv()
    {
        if ($this->request->getMethod() === 'get' || $this->request->isAJAX()) {  // Corrected to use $this->request->isAJAX()

          //echo "enters if";  
            $session = session();

              if ($session->has('user_id')) {
                //echo "User ID: " . $session->get('user_id');
            } else {
                return redirect()->to(base_url().'/login');
            }
            
        $edit_id = $this->request->getGet('orderid');  // Corrected to use $this->request->getGet()

        $this->crudModel3 = new Invtest_model();
     
       $records = $this->crudModel3-> where ('orderid',$edit_id)->findAll();


       $this->crudModel4 = new Invtest_model2();
     
      $builder = $this->crudModel4->db->table('invtest2'); // Assuming 'quote2' is your table
        $builder->select('invtest2.*, client.c_name,client.c_add'); // Select all columns from quote2 and c_name from client
        $builder->join('client', 'invtest2.cid = client.cid', 'inner'); // Perform inner join
        $builder->where('invtest2.orderid', $edit_id); // Add where 
        $records2 = $builder->get()->getResultArray(); // Fetch the result as an array

          
          // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {

           return $this->response->setJSON([
        'records' => $records,
        'records2' => $records2,
    ]);
}
    
       // return $this->response->setJSON($results);
    

    // Otherwise, return the view with JSON-encoded data
    $data = [
        'records' => json_encode($records),
        'records2' => json_encode($records2),
    ];

    return view('edit layout/edittaxinv', $data);



        //return view('edit layout/editpurchasein
    }
}


public function updatetaxinv()
{
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

        $session = session(); 

          if ($session->has('user_id')) {
            //echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }

        $this->crudModel4 = new Invtest_model2(); // Load model
        $this->crudModel = new Invtest_model(); // Load model

        $orderid = $this->request->getPost('orderid');

        $invid = $this->request->getPost('invid');
        $supplier = $this->request->getPost('supplier');
        $datepicker = $this->request->getPost('datepicker');
        $subtotal = $this->request->getPost('subTotal');
        $taxrate = $this->request->getPost('taxRate');
        $taxamount = $this->request->getPost('taxAmount');
        $totalaftertax = $this->request->getPost('totalAftertax');

        $itemNames = $this->request->getPost('item_name'); // Array
        $itemDescs = $this->request->getPost('item_desc'); // Array
        $hsn = $this->request->getPost('hsn'); // Array
        $quantities = $this->request->getPost('item_quantity'); // Array
        $prices = $this->request->getPost('price'); // Array
        $totals = $this->request->getPost('total'); // Array

        //$formattedDate = (new \DateTime($datepicker))->format('Y-m-d');

        $dateParts = explode('-', $datepicker);
    if (count($dateParts) === 3) {
        $formattedDate = (new \DateTime("{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}"))->format('Y-m-d');
    } else {
        throw new \Exception('Invalid date format');
    }

        //print_r($itemNames);

        // Prepare data for updating main invoice
        $updateData = [
            'invid' => $invid,
            'cid' => $supplier,
            //'invdate' => $formattedDate,
            'totalitems' => count($itemNames),
            'subtotal' => $subtotal,
            'taxrate' => $taxrate,
            'taxamount' => $taxamount,
            'totalamount' => $totalaftertax,
            'created' => $formattedDate,
        ];

        //print_r($updateData);
    

        if (!empty($itemNames) && is_array($itemNames)) {
            for ($i = 0; $i < count($itemNames); $i++) {
                if (!empty($itemNames[$i])) {

                    $itemData[] = [
                        'orderno'=> null,
                        'orderid' => $orderid,
                      
                            'item_name' => $itemNames[$i],
                            'item_desc' => !empty($itemDescs[$i]) ? $itemDescs[$i] : null, // Handle empty descriptions
                            'hsn' => !empty($hsn[$i]) ? $hsn[$i] : null, // Handle empty hsn
                            'quantity' => !empty($quantities[$i]) ? $quantities[$i] : null, // Handle empty quantity
                            'price' => !empty($prices[$i]) ? $prices[$i] : null, // Handle empty price
                            'total' => !empty($totals[$i]) ? $totals[$i] : null, // Handle empty total
                    ];
                    
                   // print_r($itemData);


                }
            }
        }


// Update the main invoice
if (!$this->crudModel4->updaterecord(['orderid' => $orderid], $updateData)) {
    //echo $this->crudModel4->getLastQuery();

    $this->crudModel->deleterecord($orderid);
//echo $this->crudModel->getLastQuery();

    if ($this->crudModel->insertBatch($itemData)) {
                         $lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query
                            //echo $lastQuery;


                        return $this->response->setJSON([
                            'success' => true,
                            'message' => 'Supplier Invoice Data Inserted!',
                            'orderid' => $orderid,
                            'invid'=> $invid
                        ]);


  
} else {
      return $this->response->setJSON(['success' => false, 'message' => 'Failed to update main invoice data.']);
}


   
}
 return $this->response->setJSON(['success' => true, 'message' => 'Items updated successfully!']);

    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
}
    
}
// public function get_next_id() {
//     $nextId = $this->crudModel->get_last_cid(); // Assuming this returns the last CID
//     $nextId = $nextId ? $nextId + 1 : 1; // Increment by 1 or set to 1 if no records
//     echo json_encode(['next_id' => $nextId]); // Return the next ID in JSON format
// }

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



public function getclient()
{
    
    $this->crudModel2 = new Client_model();
    $categoryName = $this->request->getGet('category_name');
    $results = [];

    if ($categoryName) {
        // Use a LIKE query with wildcards for partial matching
        $clients = $this->crudModel2
                        ->like('c_name', $categoryName, 'both') // 'both' allows matches from any part of the string
                        ->findAll();
    } else {
        // If no specific category name is provided, retrieve all clients
        $clients = $this->crudModel2->findAll();
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


public function savedeliveryaddress()
{
    
    $this->crudModel4 = new Delivery_model();

       $data = [
        'invid'   => trim($this->request->getPost('invid')), // Ensure this matches the front-end key
        'name'    => $this->request->getPost('name'),
        'address' => $this->request->getPost('address'),
        'mob'  => $this->request->getPost('mobile')
    ];

    if ($this->crudModel4->saverecords($data)) {
        return $this->response->setJSON(['success' => true, 'message' => 'Delivery address saved!']);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to save address.']);
    }

}

public function getdeliveryaddress(){

    $this->crudModel4 = new Delivery_model();

    $invid = trim($this->request->getGet('invid'));

    if (!$invid) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invoice ID is missing.']);
    }


    $dta=$this->crudModel4->where('invid', $invid)->findAll();
   
    if (!$dta) {
        return $this->response->setJSON(['success' => false, 'message' => 'No delivery address found for this Invoice ID.']);
    }

    return $this->response->setJSON(['success' => true, 'data' => $dta]);
}



public function updatedeliveryaddress()
{
    $invid = $this->request->getPost('invid');

    if (!$invid) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invoice ID is required.']);
    }

    $data = [
        'name' => trim($this->request->getPost('name')),
        'address' => trim($this->request->getPost('address')),
        'mob' => trim($this->request->getPost('mobile'))
    ];

    log_message('debug', 'Received Data: ' . print_r($data, true));

    $db = \Config\Database::connect();
    $builder = $db->table('delivery_addresses'); // Replace with your actual table name
    $builder->where('invid', $invid);
    $update = $builder->update($data);

    if ($update) {
        log_message('debug', 'Update Query Executed Successfully');
        return $this->response->setJSON(['success' => true, 'message' => 'Delivery address updated successfully.']);
    } else {
        log_message('error', 'Update Query Failed');
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update delivery address.']);
    }
}

public function checkinv()
{
    $this->crudModel4 = new Delivery_model();

    $invid = $this->request->getPost('invid');

    if (!$invid) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invoice ID is required.']);
    }

    $dta=$this->crudModel4->where('invid', $invid)->findAll();
   
    if (!$dta) {
        return $this->response->setJSON(['success' => false, 'message' => 'No deliver add found for this Invoice ID.']);
    }

    return $this->response->setJSON(['success' => true, 'data' => $dta]);
}


public function printcover()
{
    
    $this->crudModel4 = new Delivery_model();

    // Retrieve 'invid' from the request
    $invid = trim($this->request->getGet('invid'));

    if (!$invid) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invoice ID is missing.']);
    }


    $dta=$this->crudModel4->where('invid', $invid)->findAll();

    if (empty($dta)) {

        $this->crudModel = new Invtest_model(); // Load model
        $db = \Config\Database::connect();
    $query = $db->query("SELECT invtest2.invid, invtest2.orderid, client.c_name as name, client.c_add as address, client.mob 
    as mob FROM invtest2 JOIN client ON invtest2.cid = client.cid WHERE invtest2.invid = ?", [$invid]);

        $dta = $query->getResultArray();
         //dd($dta);

        //print_r($dta);

        return view('print/print cover', ['dta' => $dta]); // Ensure view loads even if empty
    }

        return view('print/print cover', ['dta' => $dta]);

}


public function getproducts()
{
    
    $this->crudModel3 = new Product_model();
      $records = $this->crudModel3->findAll();
    
    //$this->crudModel2 = new Client_model();
    $categoryName = $this->request->getGet('category_name');
    $results = [];

    if ($categoryName) {
        // Use a LIKE query with wildcards for partial matching
        $clients = $this->crudModel3
                        ->like('name', $categoryName, 'both')
                        ->findAll();
    } else {
        // If no specific category name is provided, retrieve all clients
        $clients = $this->crudModel3->findAll();
    }



   foreach ($clients as $row) {
        $results[] = [
            'p_id' => $row['p_id'], // Assuming 'id' is a unique identifier for each supplier
            'name' => $row['name'], // This is used for the Select2 display
            'hsn' => $row['hsn'] // Assuming 'address' is the field in the DB
        ];
    }

    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }

    // Otherwise, return the view with JSON-encoded data
    
}

public function showtaxdata()
{
    // Default start and end year based on the current fiscal year
    if (date('m') > 3) {
        $defaultYear = date('Y') . "-" . (date('Y') + 1);
    } else {
        $defaultYear = (date('Y') - 1) . "-" . date('Y');
    }

    // Variables for start and end years
    $startyear = substr($defaultYear, 0, 4);
    $endyear = substr($defaultYear, 5, 8);
    $selectedClient = $this->request->getVar('client');
    $selectedProduct = $this->request->getVar('product');
    $selectedYear = $this->request->getVar('year');

    // If year is selected, override default fiscal year
    if ($selectedYear !== null) {
        $startyear = substr($selectedYear, 0, 4);
        $endyear = substr($selectedYear, 5, 8);
    }

    // Initialize filters array
    $filters = [];

    // Build the filters for client and product
    if ($selectedClient !== null) {
        $filters['client'] = $selectedClient;
    }

    if ($selectedProduct !== null) {
        $filters['product'] = $selectedProduct;
    }

    // Pagination logic
    $results_per_page = 20; // Number of results per page
    $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1; // Current page
    $offset = ($page - 1) * $results_per_page;

    // Load the model
    $invtest_model2 = new Invtest_model2();

    // Fetch filtered data
    $invoices = $invtest_model2->getinvtest(
        $startyear, 
        $endyear, 
        $selectedClient, 
        $selectedProduct, 
        $results_per_page, 
        $offset
    );

    // Log the query for debugging
    log_message('debug', $invtest_model2->db->getLastQuery()->getQuery());

    // Count total number of records for pagination
    $total_records = $invtest_model2->countAllInvoices(
        $startyear, 
        $endyear, 
        $selectedClient, 
        $selectedProduct
    );

    // Log the total record count query for debugging
    log_message('debug', $invtest_model2->db->getLastQuery()->getQuery());

    // Prepare data to return
    $data = [
        'invoices' => $invoices,
        'total_records' => $total_records,
        'results_per_page' => $results_per_page,
        'current_page' => $page
    ];

    // Return data as JSON if it's an AJAX request
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($data);
    }

    // Load the view for non-AJAX requests
    return view('list layout/taxinvlist', $data);
}



public function getyear()
{
    // Load the model
    $this->crudModel5 = new Invtest_model2();

    // Retrieve all dynamically generated financial years
    $records = $this->crudModel5->getFinancialYears();

    // Initialize an array to store results in the format Select2 expects
    $results = [];

    foreach ($records as $row) {
        $results[] = [
            'id' => $row->financial_year, // Unique identifier
            'text' => $row->financial_year // Display text for Select2
        ];
    }

    // Return JSON response for AJAX
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }
}

public function insert() {

    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

        $this->crudModel4 = new Invtest_model2(); // Load model



            $created = $this->request->getPost('created');

            // Convert the input date to DateTime object
            $date = new \DateTime($created);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');

            $invid = $this->request->getPost('invid');
            $supplier = $this->request->getPost('supplier');
            $datepicker = $this->request->getPost('datepicker');

             $date = new \DateTime($datepicker);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');
         

            //$c_add = $this->request->getPost('c_add');
            $itemNames = $this->request->getPost('item_name'); // This will be an array
            $itemDescs = $this->request->getPost('item_desc'); // This will also be an array
            $hsn = $this->request->getPost('hsn'); // Array
            $quantities = $this->request->getPost('item_quantity'); // Array
            $prices = $this->request->getPost('price'); // Array
            $totals = $this->request->getPost('total'); // Array


            $subtotal=$this->request->getPost('subTotal');
            $taxrate=$this->request->getPost('taxRate');
            $taxamount=$this->request->getPost('taxAmount');
            $totalaftertax=$this->request->getPost('totalAftertax');

            $insertData = [];
            $insertData2 = []; // Initialize the array

            //$orderid=uniqid('order_', true); // with certain prefix

            //$orderid=uniqid('', true); // with decimals

            $orderid = uniqid(); // Generates a unique ID without decimals

            //$orderid = md5(uniqid(mt_rand(), true)); //long digit values


             if (!empty($itemNames) && is_array($itemNames)) {
                for ($i = 0; $i < count($itemNames); $i++) {
                    // Only insert if item_name is not empty
                    if (!empty($itemNames[$i])) {
                        $insertData[] = [
                            'orderid' => $orderid, // Generates a unique ID with a prefix
                            
                            'item_name' => $itemNames[$i],
                            'item_desc' => !empty($itemDescs[$i]) ? $itemDescs[$i] : null, // Handle empty descriptions
                            'hsn' => !empty($hsn[$i]) ? $hsn[$i] : null, // Handle empty hsn
                            'quantity' => !empty($quantities[$i]) ? $quantities[$i] : null, // Handle empty quantity
                            'price' => !empty($prices[$i]) ? $prices[$i] : null, // Handle empty price
                            'total' => !empty($totals[$i]) ? $totals[$i] : null, // Handle empty total
                            //'created_at' => date('Y-m-d H:i:s'), // Example for created_at field
                        ];
                    }
                }
            }


            
                $insertData2[] = [
                    //'nid'-> null,
                    'invid' => trim($invid), 
                    'cid' => $supplier,  
                    //'invdate' => $formattedDate,
                    'orderid' => $orderid, // Generates a unique ID with a prefix
                    'totalitems'=> count($itemNames),
                    'subtotal'=> $subtotal,
                    'taxrate'=> $taxrate,
                    'taxamount'=> $taxamount,
                    'totalamount' => $totalaftertax, 
                    
                    
                'created' => date('Y-m-d H:i:s'), // Example for created_at field
                ];
            


                    if (empty($insertData) && empty($insertData2)) {
                        return $this->response->setJSON(['success' => false, 'message' => 'No valid data to insert.']);
                    }

                    // Insert the data 
                    if ($this->crudModel->insertBatch($insertData) && $this->crudModel4->insertBatch($insertData2)) {
                         //$lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query
                           // echo $lastQuery;


                        return $this->response->setJSON([
                            'success' => true,
                            'message' => 'Supplier Invoice Data Inserted!',
                            'orderid' => $orderid,
                            'invid'=> trim($invid)
                        ]);
                    } else {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Failed to insert data.',
                        ]);
                    }
                 }
}       
    

public function delete($id)
{
    // Log the ID to confirm it's correct
    log_message('debug', 'Deleting record with ID: ' . $id);

    // Ensure the request is AJAX
    if ($this->request->isAJAX()) {
        // Load both models
        $this->crudModel = new Invtest_model();   // Assuming you have a model for purchaseinv
        $this->crudModel4 = new Invtest_model2(); // Model for purchaseinv2

        // Delete the record from both models
        $deleteFromFirstModel = $this->crudModel->deleterecord($id);

        //$lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query
          //  echo $lastQuery;




        $deleteFromSecondModel = $this->crudModel4->deleterecordfromsecond($id);

      // $lastQuery2 = $this->crudModel4->getLastQuery(); // Ensure this retrieves the last executed query
                         // echo $lastQuery2;



        // Check if both deletions were successful
        if ($deleteFromFirstModel && $deleteFromSecondModel) {
            return $this->response->setJSON([
                'res' => 'success',
                'message' => 'Record deleted successfully from both models.'
            ]);
        } else {
            return $this->response->setJSON([
                'res' => 'error',
                'message' => 'Failed to delete the record both models.'
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


// public function update() {

//     if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

            
//             log_message('debug', 'Request data: ' . print_r($this->request->getGet(), true)); 

//             $created = $this->request->getPost('created');

//             // Convert the input date to DateTime object
//             $date = new \DateTime($created);

//             // Format the date to Y-m-d (MySQL compatible format)
//             $formattedDate = $date->format('Y-m-d');

//             $cid=$this->request->getPost('cid');

//             log_message('debug', 'CID: ' . $cid); // Log the cid value


//             // Prepare data for insertion
//             $data = [
               
//                 'c_name'   => $this->request->getPost('c_nameedit'),
//                 'c_add'    => $this->request->getPost('c_addedit'),
//                 'mob'      => $this->request->getPost('fullno2'),
//                 'country' => $this->request->getPost('fulldetails2'),    
//                 'gst'      => $this->request->getPost('gstedit'),
//                 'email'      => $this->request->getPost('email1'),
//                 'c_type'   => $this->request->getPost('ctypeedit'),
//                 //'created'  => $formattedDate,
//             ];

//             //print_r($data);


//         //log_message('debug', 'Update Data: ' . print_r($data, true)); 

//              //print_r($data);   
//             // Attempt to save the record
//             $response = $this->crudModel->updaterecord($cid, $data);

//              //print_r($response);

//             if ($response) {
//                 //print_r($response);
//                 // Return success response in JSON format
//                 return $this->response->setJSON([
//                     'res' => 'success',
//                     'message' => 'Records updated successfully.',
//                 //'redirect' => base_url('/client/manageclients'), 
//                 ]);
                
//             } else {
//                 //print_r($response);
//                 // Return error response if insertion fails
//                 return $this->response->setJSON([
//                     'res' => 'error',
//                     'message' => 'Insert failed.'
//                 ]);
//             }
       
//     } else {

//         // If not a valid request, return an error
//         return $this->response->setJSON([
//             'res' => 'error',
//             'message' => 'Invalid Request'
//         ]);
//     }
// }




public function printtaxinv(){
  
  $session = session(); 
  if ($session->has('user_id')) {
    //echo "User ID: " . $session->get('user_id');
    } else {
        return redirect()->to(base_url().'/login');
    }

    
         $orderid = $this->request->getGet('orderid');
         helper('number_to_words_helper');

    if (!$orderid) {
        return view('errors/custom_error', ['message' => 'Order ID is missing.']);
    }

    $this->adminModel = new Admin_model();
    
    $companyDetails = $this->adminModel->first();


    $this->crudModel = new Invtest_model();
    $this->crudModel2 = new Invtest_model2();
    $this->crudModel3 = new Bank_model();
    $this->crudModel4 = new Delivery_model();


    $invDetails =$this->crudModel2-> printinvdata($orderid);

        $invid = $invDetails[0]['invid'];

    $deliveryDetails = $this ->crudModel4-> getdeliverydata($invid);


    $itemDetails = $this->crudModel->fetchitemdata($orderid);

    $bankDetails = $this->crudModel3->findAll();

    //print_r($companyDetails);
    //print_r($invid);
    //print_r($deliveryDetails);
    //print_r($invDetails);
    //print_r($itemDetails);
    //print_r($bankDetails);
    //return view('print/print quote', ['quoteDetails' => $quoteData]);
        return view('print/print taxinv',['companyDetails' => $companyDetails,
                                           'invDetails' => $invDetails,
                                           'itemDetails' =>$itemDetails,
                                            'bankDetails'=> $bankDetails,
                                            'deliveryDetails'=> $deliveryDetails]);
    }

    public function salereport(){



        return view('report/sale_report');
    }



   public function loadInvoices()
  {
    // Retrieve GET parameters

    $daterange= $this->request->getGet('date')?? '';

             // Split the date range using the '-' separator
    $dates = explode(' - ', $daterange);

    // Check if two dates are present
    if (count($dates) == 2) {
        $startDate = date('Y-m-d', strtotime(trim($dates[0]))); // Convert to Y-m-d format
        $endDate = date('Y-m-d', strtotime(trim($dates[1])));   // Convert to Y-m-d format
    } else {
        $startDate = $endDate = null; // If date range is invalid, set both to null
    }
      

    //$item = $this->request->getGet('item_name');
    //$customer = $this->request->getGet('client');
     $customer = is_numeric($this->request->getGet('client')) ? $this->request->getGet('client') : null;

     //$ctype-$this->request->getGet('ctype');   
        $ctype = $this->request->getPost('ctype') ?? 'null';

    // Call the model function
    $this->crudModel = new Invtest_model2();

    $invoices = $this->crudModel->getInvoices($startDate, $endDate,null, $customer,$ctype);

    $totalSubtotal = 0;
    $totalTaxAmount = 0;
    $totalAmount = 0;

    // Loop through each invoice and calculate totals
    foreach ($invoices as $invoice) {
        $totalSubtotal += $invoice->subtotal;
        $totalTaxAmount += $invoice->taxamount;
        $totalAmount += $invoice->totalamount;
    }

    // Create the result array with totals
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($invoices),
        "iTotalDisplayRecords" => count($invoices),
        "aaData" => $invoices,
        "totalSubtotal" => $totalSubtotal,
        "totalTaxAmount" => $totalTaxAmount,
        "totalAmount" => $totalAmount
    ];



    //print_r($invoices);

    // Check if data exists
    if (!empty($invoices)) {
        $response = [
            'success' => true,
            'data' => $results,
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No invoices found for the selected filters.',
        ];
    }

    // Return the response as JSON
    return $this->response->setJSON($results);
}


   public function loaditems()
  {

    $daterange = $this->request->getGet('date') ?? '';

    // Initialize date variables
    $startDate = $endDate = null;

    // Split and process the date range
    if (!empty($daterange)) {
        $dates = explode(' - ', $daterange);
        if (count($dates) == 2) {
            $startDate = date('Y-m-d', strtotime(trim($dates[0])));
            $endDate = date('Y-m-d', strtotime(trim($dates[1])));
        }
    }

    // Get the item name from GET request
    $item = $this->request->getGet('item') ?? null;
    

    // Call the model function
    $this->crudModel = new Invtest_model2();

    $invoices = $this->crudModel->getItemreport($startDate, $endDate,$item);



    // Initialize totals
    $totalSubtotal = 0;
    $totalTaxAmount = 0;
    $totalAmount = 0;
    $totalQuantity = 0;
    $totalPrice = 0;
    // Loop through each invoice and calculate totals
    foreach ($invoices as $invoice) {
        $totalPrice += $invoice->price;
        $totalQuantity += $invoice->quantity;
        $totalSubtotal += $invoice->subtotal;
         $totalTaxAmount += $invoice->taxamount;
        $totalAmount += $invoice->totalamount;
    }


    // Create the result array with totals
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($invoices),
        "iTotalDisplayRecords" => count($invoices),
        "aaData" => $invoices,
        "totalPrice" => $totalPrice,
        "totalQuantity" => $totalQuantity,
        "totalSubtotal" => $totalSubtotal,
        "totalTaxAmount" => $totalTaxAmount,
        "totalAmount" => $totalAmount
    ];



    //print_r($invoices);

    // Check if data exists
    if (!empty($invoices)) {
        $response = [
            'success' => true,
            'data' => $results,
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No invoices found for the selected filters.',
        ];
    }

    // Return the response as JSON
    return $this->response->setJSON($results);
}


     public function saleitemreport(){
        return view('report/sitem_report');
    }
    
}
?>