<?php

namespace App\Controllers;

use App\Models\Purchaseinv_model;

use App\Models\Bank_model;
use App\Models\Quote_model;
use App\Models\Quote_model2;

use App\Models\Invtest_model2;

use App\Models\Client_model;

use App\Models\Product_model;
 // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

use CodeIgniter\Database\Database;


class Quote extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Quote_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function genquote()
  {
    $db = \Config\Database::connect();
   
     $session = session(); 
         
     if ($session->has('user_id')) {
           // echo "User ID: " . $session->get('user_id');
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

        //echo $date;

        // SQL query to get the next invoice ID
        $datalogger = "
            SELECT CONCAT_WS('/', '$year', COALESCE(LPAD(
                CASE 
                    WHEN '$date' >= DATE_FORMAT('$date','%Y-04-01') 
                    THEN SUM(created >= DATE_FORMAT('$date','%Y-04-01')) 
                    ELSE SUM(created BETWEEN DATE_FORMAT('$date','%Y-04-01') - INTERVAL 1 YEAR AND DATE_FORMAT('$date','%Y-04-01'))
                END + 1, 4, 0)
            , LPAD(1, 4, 0))) AS invid 
            FROM Quote2";

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
            $value2 = "\n  QT/" . $year . "/" . sprintf('%04s', $value2);
            $value = $value2;
        } else {
            // No records found, start from 0001
            $value = "QT/" . $year . "/0001";
        }

        // Return the generated invoice ID (you can return it as JSON or any format you prefer)
        //return $this->response->setJSON(['invoice_id' => $value]);
    
    // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {
        //return $this->response->setJSON(['invoice_id' => $value]);
    }

    // Otherwise, return the view with JSON-encoded data
    // $data = [
    //     //'next_cid' => $next_cid,
    //     'results' => json_encode($results)
    // ];

    return view('layout/genquote',['invoice_id' => $value]);      
    //return view('layout/genpurchaseinvoice.php');
}



public function editquote()
{
    if ($this->request->getMethod() === 'get' || $this->request->isAJAX()) {


        $session = session(); 
        if ($session->has('user_id')) {
            //echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }

        $edit_id = $this->request->getGet('orderid');

        // Load Quote_model3
        $this->crudModel3 = new Quote_model();
        $records = $this->crudModel3->where('orderid', $edit_id)->findAll();

        // Load Quote_model4 with join to include c_name
        $this->crudModel4 = new Quote_model2();
        $builder = $this->crudModel4->db->table('quote2'); // Assuming 'quote2' is your table
        $builder->select('quote2.*, client.c_name,client.c_add'); // Select all columns from quote2 and c_name from client
        $builder->join('client', 'quote2.cid = client.cid', 'inner'); // Perform inner join
        $builder->where('quote2.orderid', $edit_id); // Add where 
        $records2 = $builder->get()->getResultArray(); // Fetch the result as an array

        // If it's an AJAX request, return JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'records' => $records,
                'records2' => $records2,
            ]);
        }

        // Otherwise, return the view with JSON-encoded data
        $data = [
            'records' => json_encode($records),
            'records2' => json_encode($records2),
        ];

        return view('edit layout/editquote', $data);
    }
}

public function updatequote()
{
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

        $session = session(); 
        
          if ($session->has('user_id')) {
            //echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }

        $this->crudModel4 = new Quote_model2(); // Load model
        $this->crudModel = new Quote_model(); // Load model

        $orderid = $this->request->getPost('orderid');

        $invid = $this->request->getPost('invid');
        $supplier = $this->request->getPost('supplier');
        $datepicker = $this->request->getPost('datepicker');
        $subtotal = $this->request->getPost('subTotal');
        $taxrate = $this->request->getPost('taxRate');
        $taxamount = $this->request->getPost('taxAmount');
        $totalaftertax = $this->request->getPost('totalAftertax');

        $itemNames = $this->request->getPost('item_name'); // Array
       // $itemDescs = $this->request->getPost('item_desc'); // Array
       // $hsn = $this->request->getPost('hsn'); // Array
        $quantities = $this->request->getPost('item_quantity'); // Array
        $prices = $this->request->getPost('price'); // Array
        $totals = $this->request->getPost('total'); // Array

       
        //$formattedDate = (new DateTime($datepicker))->format('Y-m-d');

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
        
        $updateItemsData = [];
        $newItemsData = [];

        if (!empty($itemNames) && is_array($itemNames)) {
            for ($i = 0; $i < count($itemNames); $i++) {
                if (!empty($itemNames[$i])) {

                    $itemData[] = [
                        'orderno'=> null,
                        'orderid' => $orderid,
                      
                            'item_name' => $itemNames[$i],
                            //'item_desc' => !empty($itemDescs[$i]) ? $itemDescs[$i] : null, // Handle empty descriptions
                            //'hsn' => !empty($hsn[$i]) ? $hsn[$i] : null, // Handle empty hsn
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
                            'message' => 'Quotation Data Inserted!',
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


public function quotereport(){

        return view('report/quote_report');
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
    $this->crudModel = new Quote_model2();

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
    $this->crudModel = new Quote_model2();

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


     public function quoteitemreport(){
        return view('report/quoteitem_report');
    }


public function getclient()
{
    $this->crudModel2 = new Client_model();
      $records = $this->crudModel2->findAll();
    


     //$this->crudModel2 = new Client_model();
    $categoryName = $this->request->getGet('category_name');
    $results = [];

    if ($categoryName) {
        // Use a LIKE query with wildcards for partial matching
        $clients = $this->crudModel2
                        ->like('c_name', $categoryName, 'both')
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


    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }
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


public function showquotedata()
{
    $session = session(); 

      if ($session->has('user_id')) {
        //echo "User ID: " . $session->get('user_id');
    } else {
        return redirect()->to(base_url().'/login');
    }


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
    if ($selectedYear !== null && $selectedYear !== '') {
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
    $quote_model2 = new Quote_model2();

    // Fetch filtered data
    $invoices = $quote_model2->getquote(
        $startyear, 
        $endyear, 
        $selectedClient, 
        $selectedProduct, 
        $results_per_page, 
        $offset
    );

    // Count total number of records for pagination
    $total_records = count($invoices);

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
    return view('list layout/quotelist', $data);
}


public function getyear()
{
    
    $this->crudModel5 = new Quote_model2();
      
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


        $session = session(); 

        if ($session->has('user_id')) {
            //echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }


        $this->crudModel4 = new Quote_model2(); // Load model



            $created = $this->request->getPost('created');

            // Convert the input date to DateTime object
            $date = new \DateTime($created);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');

            $invid = trim($this->request->getPost('invid'));
            $supplier = $this->request->getPost('supplier');
            $datepicker = $this->request->getPost('datepicker');

             $date = new \DateTime($datepicker);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');
         

            //$c_add = $this->request->getPost('c_add');
            $itemNames = $this->request->getPost('item_name'); // This will be an array
            //$itemDescs = $this->request->getPost('item_desc'); // This will also be an array
            //$hsn = $this->request->getPost('hsn'); // Array
            $quantities = $this->request->getPost('item_quantity'); // Array
            $prices = $this->request->getPost('price'); // Array
            $totals = $this->request->getPost('total'); // Array


            $subtotal=$this->request->getPost('subTotal');
            $taxrate=$this->request->getPost('taxRate');
            $taxamount=$this->request->getPost('taxAmount');
            $totalaftertax=$this->request->getPost('totalAftertax');

            $insertData = [];
            $insertData2 = []; // Initialize the array

            

            $orderid = uniqid(); // Generates a unique ID without decimals

            //$orderid = md5(uniqid(mt_rand(), true)); //long digit values


             if (!empty($itemNames) && is_array($itemNames)) {
                for ($i = 0; $i < count($itemNames); $i++) {
                    // Only insert if item_name is not empty
                    if (!empty($itemNames[$i])) {
                        $insertData[] = [
                            'orderid' => $orderid, // Generates a unique ID with a prefix
                            
                            'item_name' => $itemNames[$i],
                            //'item_desc' => !empty($itemDescs[$i]) ? $itemDescs[$i] : null, // Handle empty descriptions
                            //'hsn' => !empty($hsn[$i]) ? $hsn[$i] : null, // Handle empty hsn
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

                    if (empty($insertData) && empty($insertData2)) {
                        return $this->response->setJSON(['success' => false, 'message' => 'No valid data to insert.']);
                    }

                    // Insert the data
                    if ($this->crudModel->insertItems($insertData) && $this->crudModel4->insertItems($insertData2)) {
                         //$lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query
                           // echo $lastQuery;


            return $this->response->setJSON([
                'success' => true,
                'message' => 'Quotation Data Inserted!',
                'orderid' => $orderid, // or $lastInsertedID2 depending on which ID you want to return
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to insert Quotation Data.',
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
        $this->crudModel = new Quote_model();   // Assuming you have a model for purchaseinv
        $this->crudModel4 = new Quote_model2(); // Model for purchaseinv2

        // Delete the record from both models
        $deleteFromFirstModel = $this->crudModel->deleterecord($id);

        // $lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query
        //     echo $lastQuery;


        $deleteFromSecondModel = $this->crudModel4->deleterecord($id);

        // $lastQuery2 = $this->crudModel4->getLastQuery(); // Ensure this retrieves the last executed query
        //                     echo $lastQuery2;



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

public function update() {

    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

            $session = session(); 
            
            if ($session->has('user_id')) {
                //echo "User ID: " . $session->get('user_id');
            } else {
                return redirect()->to(base_url().'/login');
            }

            
            //log_message('debug', 'Request data: ' . print_r($this->request->getGet(), true)); 

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



// public function printquote($orderid){


// //$records =$this->request->getGet('orderid');

//       //$quoteModel = new Quote_model2();
//     $this->quoteModel = new Quote_model2();

//     $did = urldecode($orderid); // Decode the parameter
//     // Fetch quote details from the database using the $did value
//     $data = $this->quoteModel->fetchquotedata($did);

//         // Fetch quote details
//        // $data['quoteDetails'] = $quoteModel->fetchquotedata($records);



//     return view('print/print quote', ['quoteDetails' => $data]);

// //return view('print/print quote',$data);

// }
public function printquote()
{
    $orderid = $this->request->getGet('orderid');

    if (!$orderid) {
        return view('errors/custom_error', ['message' => 'Order ID is missing.']);
    }

    $this->crudModel = new Quote_model();
    $this->crudModel2 = new Quote_model2();
    $this->crudModel3 = new Bank_model();
    

     $invDetails =$this->crudModel2-> printquotedata($orderid);

        //$invid = $invDetails[0]['invid'];

    //$deliveryDetails = $this ->crudModel4-> getdeliverydata($invid);


    $itemDetails = $this->crudModel->fetchitemdata($orderid);

    $cattype = $itemDetails[0]['cattype'];

    $bankDetails = $this->crudModel3->findAll();


    //$quoteData = $this->quoteModel->fetchquotedata($orderid);


    // if (empty($quoteData)) {
    //     return view('errors/custom_error', ['message' => 'No data found for the given Order ID.']);
    // }

    //print_r($invDetails);
    //print_r($itemDetails);
    //print_r($bankDetails);

    return view('print/print quote', [     'invDetails' => $invDetails,
                                           'itemDetails' =>$itemDetails,
                                            'bankDetails'=> $bankDetails,
                                             'cattype'=> $cattype]);

}




    
}
?>