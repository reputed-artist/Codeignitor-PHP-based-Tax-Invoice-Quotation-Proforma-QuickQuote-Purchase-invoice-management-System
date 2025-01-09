<?php

namespace App\Controllers;

use App\Models\Purchaseinv_model;


use App\Models\Purchaseinv_model2;

use App\Models\Protest_model2;
use App\Models\Protest_model;

use App\Models\Client_model;

use App\Models\Product_model;
 // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

use CodeIgniter\Database\Database;
use App\Models\Admin_model;
use App\Models\Bank_model;

class Proinv extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Protest_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function genproinv()
  {


    $db = \Config\Database::connect();

    $session = session(); 

    if ($session->has('user_id')) {
            //echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }

            
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
            FROM Protest2";

        //echo $datalogger;    

        // Execute the query
        $stmt = $db->query($datalogger);
        $row = $stmt->getRow();

        // Determine the invoice number
        if ($row) {
            $value2 = $row->invid;

            // Separate numeric part
            $value2 = substr($value2, 6, 4);

            // Concatenate incremented value
            $value2 = "\n PI/" . $year . "/" . sprintf('%04s', $value2);
            $value = $value2;
        } else {
            // No records found, start from 0001
            $value = "PI/" . $year . "/0001";
        }

        // Return the generated invoice ID (you can return it as JSON or any format you prefer)
        //return $this->response->setJSON(['invoice_id' => $value]);
    
    // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {
        //return $this->response->setJSON(['invoice_id' => $value]);
    }

    
    return view('layout/genproinv',['invoice_id' => $value]);      
    //return view('layout/genpurchaseinvoice.php');
}




public function editproinv()
    {
        if ($this->request->getMethod() === 'get' || $this->request->isAJAX()) {  // Corrected to use $this->request->isAJAX()

          
            
        $edit_id = $this->request->getGet('orderid');  // Corrected to use $this->request->getGet()

        $this->crudModel3 = new Protest_model();
     
       $records = $this->crudModel3-> where ('orderid',$edit_id)->findAll();


       $this->crudModel4 = new Protest_model2();
     
        $builder = $this->crudModel4->db->table('protest2'); // Assuming 'quote2' is your table
        $builder->select('protest2.*, client.c_name,client.c_add'); // Select all columns from quote2 and c_name from client
        $builder->join('client', 'protest2.cid = client.cid', 'inner'); // Perform inner join
        $builder->where('protest2.orderid', $edit_id); // Add where 
        $records2 = $builder->get()->getResultArray(); // Fetch the result as an array

          
          // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {

           return $this->response->setJSON([
        'records' => $records,
        'records2' => $records2,
    ]);
}
    

    $data = [
        'records' => json_encode($records),
        'records2' => json_encode($records2),
    ];

    return view('edit layout/editproinv', $data);
    }
}



public function updateproinv()
{
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

        $this->crudModel4 = new Protest_model2(); // Load model
        $this->crudModel = new Protest_model(); // Load model

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

        // $formattedDate = (new \DateTime($datepicker))->format('Y-m-d');


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
            'created' => $formattedDate
        ];

        //print_r($updateData);
        
        $updateItemsData = [];
        $newItemsData = [];

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
                    
                    //print_r($itemData);


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
                        ]);


  
} else {
      return $this->response->setJSON(['success' => false, 'message' => 'Failed to update main invoice data.']);
}


   
}
 return $this->response->setJSON(['success' => true, 'message' => 'Items updated successfully!']);

    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
}
    
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

    
    // Debugging: Log the SQL query to see what's happening
    log_message('debug', $this->crudModel3->getLastQuery());


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
public function getproducthsn()
{
    $this->crudModel3 = new Product_model();
    
    // Get the product ID from the request
    $productId = $this->request->getGet('q'); // Adjust to match your AJAX request parameter name
    
    $results = [];

    if ($productId) {
        // Query to fetch the HSN code for the specific product by its ID
        $product = $this->crudModel3->where('name', $productId)->first();

        if ($product) {
            // Return the HSN code if the product is found
            $results['hsn'] = $product['hsn'];
        } else {
            $results['hsn'] = ''; // If no product is found, return an empty value
        }
    } else {
        $results['hsn'] = ''; // No product ID provided, return an empty value
    }

    // Log the SQL query for debugging (optional)
    //log_message('debug', $this->crudModel3->getLastQuery());

    // Return the response as JSON
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }

    // Fallback: empty response if not an AJAX request
    return $this->response->setJSON($results);
}

public function showprodata()
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
    $protest_model2 = new Protest_model2();

    // Fetch filtered data
    $invoices = $protest_model2->getprotest(
        $startyear, 
        $endyear, 
        $selectedClient, 
        $selectedProduct, 
        $results_per_page, 
        $offset
    );

    // Log the query for debugging
    log_message('debug', $protest_model2->db->getLastQuery()->getQuery());

    // Count total number of records for pagination
    $total_records = $protest_model2->countAllInvoices(
        $startyear, 
        $endyear, 
        $selectedClient, 
        $selectedProduct
    );

    // Log the total record count query for debugging
    log_message('debug', $protest_model2->db->getLastQuery()->getQuery());

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
    return view('list layout/proinvlist', $data);
}



public function getyear()
{
    // Load the model
    $this->crudModel5 = new Protest_model2();

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

        $this->crudModel4 = new Protest_model2(); // Load model
        

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
            $itemNames = $this->request->getPost('item_name');
            $itemDescs = $this->request->getPost('item_desc'); 
            $hsn = $this->request->getPost('hsn'); // Array
            $quantities = $this->request->getPost('item_quantity'); 
            $prices = $this->request->getPost('price'); 
            $totals = $this->request->getPost('total'); 


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
                    'invid' => $invid, 
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
            

                //print_r($insertData);
                //print_r($insertData2);
                //print_r($this->request->getPost());


                              // Debugging: Check the content of insertData
                    if (empty($insertData) && empty($insertData2)) {
                        return $this->response->setJSON(['success' => false, 'message' => 'No valid data to insert.']);
                    }

                    // Insert the data
                    if ($this->crudModel->insertBatch($insertData) && $this->crudModel4->insertBatch($insertData2)) {
                         $lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query
                            //echo $lastQuery;


                        return $this->response->setJSON([
                            'success' => true,
                            'message' => 'Proforma Invoice Data Inserted!',
                            'orderid' => $orderid,
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
        $this->crudModel = new Protest_model();   // Assuming you have a model for purchaseinv
        $this->crudModel4 = new Protest_model2(); // Model for purchaseinv2

        // Delete the record from both models
        $deleteFromFirstModel = $this->crudModel->deleterecord($id);

        // $lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query
        //     echo $lastQuery;




        $deleteFromSecondModel = $this->crudModel4->deleterecord($id);

        // $lastQuery2 = $this->crudModel4->getLastQuery(); // Ensure this retrieves the last executed query
        //                     echo $lastQuery2;

        // Log or output the results to ensure they are as expected
//error_log("Delete from first model: " . var_export($deleteFromFirstModel, true));
//error_log("Delete from second model: " . var_export($deleteFromSecondModel, true));
//var_dump($deleteFromSecondModel);
//var_dump($deleteFromSecondModel); 

          // Verify the deletion results
    if ($deleteFromFirstModel && $deleteFromSecondModel) {
        return $this->response->setJSON([
            'res' => 'success',
            'message' => 'Record deleted successfully from both models.'
        ]);
    } else {
        return $this->response->setJSON([
            'res' => 'error',
            'message' => 'Failed to delete the record in both models.'
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


            // Prepare data for insertion
            $data = [
               
                'c_name'   => $this->request->getPost('c_nameedit'),
                'c_add'    => $this->request->getPost('c_addedit'),
                'mob'      => $this->request->getPost('fullno2'),
                'country' => $this->request->getPost('fulldetails2'),    
                'gst'      => $this->request->getPost('gstedit'),
                'email'      => $this->request->getPost('email1'),
                'c_type'   => $this->request->getPost('ctypeedit'),
                //'created'  => $formattedDate,
            ];

            //print_r($data);


        //log_message('debug', 'Update Data: ' . print_r($data, true)); 

             //print_r($data);   
            // Attempt to save the record
            $response = $this->crudModel->updaterecord($cid, $data);

             //print_r($response);

            if ($response) {
                //print_r($response);
                // Return success response in JSON format
                return $this->response->setJSON([
                    'res' => 'success',
                    'message' => 'Records updated successfully.',
                //'redirect' => base_url('/client/manageclients'), 
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

public function printproinv(){
         $orderid = $this->request->getGet('orderid');
         helper('number_to_words_helper');

    if (!$orderid) {
        return view('errors/custom_error', ['message' => 'Order ID is missing.']);
    }

    $this->adminModel = new Admin_model();
    
    $companyDetails = $this->adminModel->first();


    $this->crudModel = new Protest_model();
    $this->crudModel2 = new Protest_model2();
    $this->crudModel3 = new Bank_model();
    //$this->crudModel4 = new Delivery_model();


    $invDetails =$this->crudModel2-> printprodata($orderid);

        //$invid = $invDetails[0]['invid'];

     //$deliveryDetails = $this ->crudModel4-> getdeliverydata($invid);


    $itemDetails = $this->crudModel->fetchitemdata($orderid);

    $bankDetails = $this->crudModel3->findAll();

    // if (empty($taxinvData)) {
    //     return view('errors/custom_error', ['message' => 'No data found for the given Order ID.']);
    // }

    //print_r($companyDetails);
    //print_r($invid);
    //print_r($deliveryDetails);
    //print_r($invDetails);
    //print_r($itemDetails);
    //print_r($bankDetails);
    //return view('print/print quote', ['quoteDetails' => $quoteData]);
        return view('print/print proinv',['companyDetails' => $companyDetails,
                                           'invDetails' => $invDetails,
                                           'itemDetails' =>$itemDetails,
                                            'bankDetails'=> $bankDetails]);
    }
    
}
?>