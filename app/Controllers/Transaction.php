<?php

namespace App\Controllers;

use App\Models\Transaction_model;
use App\Models\Client_model; // Ensure you have the correct namespace for your model
use App\Models\Bank_model;
use CodeIgniter\Controller;

class Transaction extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Transaction_model(); // Load model
        //helper('url');
        //helper('navigation');
        helper(['url', 'navigation', 'getProfileImage', 'money_format']);

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


    public function checkDuplicateRecord()
    {
        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method not allowed']);
        }

        $postData = $this->request->getPost();

        // Extract fields for duplicate check - match your database field names
        $cid = $postData['co'] ?? ''; // 'co' in frontend maps to 'cid' in database
        $purpose = $postData['purpose'] ?? '';
        $dateofpayment = $postData['dateofpayment'] ?? '';
        $amount = $postData['amount'] ?? '';
        $bank = $postData['ctype'] ?? ''; // 'ctype' in frontend maps to 'bank' in database

        // Log received data for debugging
        log_message('debug', 'Duplicate check data: ' . print_r([
            'cid' => $cid,
            'purpose' => $purpose,
            'dateofpayment' => $dateofpayment,
            'amount' => $amount,
            'bank' => $bank
        ], true));

        try {
            $transactionModel = new \App\Models\Transaction_model();
            
            // Build query to find similar records
            $builder = $transactionModel;

            // Add conditions for each field (only if value is provided)
            // Using exact database field names
            if (!empty($cid)) {
                $builder->where('cid', $cid);
            }
            if (!empty($purpose)) {
                $builder->where('purpose', $purpose);
            }
            if (!empty($dateofpayment)) {
                $builder->where('dateofpayment', $dateofpayment);
            }
            if (!empty($amount)) {
                $builder->where('amount', $amount);
            }
            if (!empty($bank)) {
                $builder->where('bank', $bank);
            }

            // Get matching records
            $duplicateRecords = $builder->findAll();
            // Get matching records
// Debug: Check the actual structure
 //print_r($duplicateRecords);
//print_r(gettype($duplicateRecords[0]));
 //print_r(array_keys($duplicateRecords[0]), true));


           //print_r($duplicateRecords);

            // Log query results
            log_message('debug', 'Found ' . count($duplicateRecords) . ' duplicate records');

if (!empty($duplicateRecords)) {
    $duplicateRecord = $duplicateRecords[0];
    
    $displayDate = '';
    if (!empty($duplicateRecord['dateofpayment'])) {
        $displayDate = date('d-m-Y', strtotime($duplicateRecord['dateofpayment']));
    }
    
    return $this->response->setJSON([
        'exists' => true,
        'message' => 'Similar transaction record found',
        'duplicate_record' => [
            'cid' => $duplicateRecord['cid'] ?? '',
            'purpose' => $duplicateRecord['purpose'] ?? '',
            'dateofpayment' => $displayDate,
            'amount' => $duplicateRecord['amount'] ?? '',
            'bank' => $duplicateRecord['bank'] ?? ''
        ],
        'total_duplicates' => count($duplicateRecords)
    ]);
} else {
                return $this->response->setJSON([
                    'exists' => false,
                    'message' => 'No similar records found'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Duplicate check error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            return $this->response->setStatusCode(500)->setJSON([
                'exists' => false,
                'message' => 'Server error occurred while checking duplicates',
                'debug' => $e->getMessage() // Remove this in production
            ]);
        }
    }
public function managetransaction()
{
    $session = session(); 
    
    if ($session->has('user_id')) {
        //echo "User ID: " . $session->get('user_id');
    } else {
        return redirect()->to(base_url().'/login');
    }

    $transactionModel = new Transaction_model();

    // Fetch filters from GET request
    $startDate = $this->request->getGet('startDate');
    $endDate = $this->request->getGet('endDate');
    $customer = $this->request->getGet('customer');
    $supplier = $this->request->getGet('supplier');
    $type = $this->request->getGet('ctype');

    // Fetch the transactions based on filters
    $transactions = $transactionModel->getTransactions($startDate, $endDate, $customer, $supplier, $type);

    // Prepare data for DataTables
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($transactions),
        "iTotalDisplayRecords" => count($transactions),
        "aaData" => $transactions
    ];

    // Check for AJAX request to return JSON
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }

    // Fetch next client ID for the view
    //$next_cid = $transactionModel->getLastClientId() + 1;

     // $db = \Config\Database::connect();

     //         // Determine the financial year based on the current month
     //    if (date('m') > 3) {
     //        $year = date('y') . "-" . (date('y') + 1);
     //    } else {
     //        $year = (date('y') - 1) . "-" . date('y');
     //    }

     //    $date = date('Y-m-d');

     //    // SQL query to get the next invoice ID
     //    $datalogger = "
     //        SELECT CONCAT_WS('/', '$year', COALESCE(LPAD(
     //            CASE
     //                WHEN '$date' >= DATE_FORMAT('$date','%Y-04-01')
     //                THEN SUM(created >= DATE_FORMAT('$date','%Y-04-01'))
     //                ELSE SUM(created BETWEEN DATE_FORMAT('$date','%Y-04-01') - INTERVAL 1 YEAR AND DATE_FORMAT('$date','%Y-04-01'))
     //            END + 1, 4, 0)
     //        , LPAD(1, 4, 0))) AS pay_id
     //        FROM paidhistory";

     //     //echo $datalogger;   

     $db = \Config\Database::connect();

     
     $year = date('m') > 3
    ? date('y') . "-" . (date('y') + 1)
    : (date('y') - 1) . "-" . date('y');

// Get last used transaction number
$stmt = $db->query("
    SELECT pay_id
    FROM paidhistory
    WHERE pay_id LIKE 'T/$year/%'
    ORDER BY pay_id DESC
    LIMIT 1
");

$row = $stmt->getRow();

if ($row) {
    // Extract the last 4 digits
    $parts = explode('/', $row->pay_id);
    $lastNumber = intval(end($parts));
    $nextNumber = $lastNumber + 1;
} else {
    $nextNumber = 1;
}

// Final Pay ID
$pay_id = "T/$year/" . sprintf('%04d', $nextNumber);


    // Prepare data for view
    $data = [
        'pay_id' => $pay_id,
        'results' => json_encode($results)
    ];

    //print_r($data);

    return view('layout/manage-transaction', $data);
}


public function getBankDetails()
{
    $model = new Bank_model();
    $bankDetails = $model->getBankDetails(); // Fetch data from the database

    // Convert data into Select2 format
    $results = [];
    foreach ($bankDetails as $bank) {
        $results[] = [
            'id' => $bank['bname'],  // Select2 requires 'id'
            'text' => $bank['bname'] // Select2 requires 'text'
        ];
    }

    return $this->response->setJSON($results); // Return JSON response
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
public function insert() {
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {
        
        // Get all POST data
        $postData = $this->request->getPost();
        log_message('debug', '=== INSERT METHOD START ===');
        log_message('debug', 'Raw POST data: ' . print_r($postData, true));

        // Validate required fields
        $requiredFields = ['co', 'purpose', 'amount', 'ctype', 'dateofpayment'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            if (empty($postData[$field])) {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            log_message('error', 'Missing required fields: ' . implode(', ', $missingFields));
            return $this->response->setJSON([
                'res' => 'error',
                'message' => 'Missing required fields: ' . implode(', ', $missingFields)
            ]);
        }

        // Generate pay_id
        $db = \Config\Database::connect();
        
        if (date('m') > 3) {
            $year = date('y') . "-" . (date('y') + 1);
        } else {
            $year = (date('y') - 1) . "-" . date('y');
        }

        $datalogger = "SELECT pay_id FROM paidhistory WHERE pay_id LIKE 'T/$year/%' ORDER BY pay_id DESC LIMIT 1";
        $stmt = $db->query($datalogger);
        $row = $stmt->getRow();

        if ($row) {
            $parts = explode('/', $row->pay_id);
            $lastNumber = intval(end($parts));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $pay_id = "T/$year/" . sprintf('%04d', $nextNumber);

        // Handle dateofpayment
        $dateofpayment = $postData['dateofpayment'];
        $mysqlPaymentDate = '';
        
        if (!empty($dateofpayment)) {
            // Check if date is already in YYYY-MM-DD format
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateofpayment)) {
                $mysqlPaymentDate = $dateofpayment . ' ' . date('H:i:s');
            } else {
                // Try to convert from DD-MM-YYYY to YYYY-MM-DD
                $dateParts = explode('-', $dateofpayment);
                if (count($dateParts) === 3) {
                    // If format is DD-MM-YYYY
                    if (strlen($dateParts[0]) === 2 && strlen($dateParts[1]) === 2 && strlen($dateParts[2]) === 4) {
                        $mysqlPaymentDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0] . ' ' . date('H:i:s');
                    } else {
                        // Use current date as fallback
                        $mysqlPaymentDate = date('Y-m-d H:i:s');
                    }
                } else {
                    $mysqlPaymentDate = date('Y-m-d H:i:s');
                }
            }
        } else {
            $mysqlPaymentDate = date('Y-m-d H:i:s');
        }

        // Handle created date - ALWAYS use current server timestamp
        $created = date('Y-m-d H:i:s');

        log_message('debug', 'Date conversion:');
        log_message('debug', ' - Input dateofpayment: ' . $dateofpayment);
        log_message('debug', ' - MySQL dateofpayment: ' . $mysqlPaymentDate);
        log_message('debug', ' - Created: ' . $created);

        // Prepare data for insertion
        $data = [
            'pay_id' => $pay_id,
            'cid' => $postData['co'],
            'purpose' => $postData['purpose'],
            'amount' => $postData['amount'],
            'bank' => $postData['ctype'],
            'dateofpayment' => $mysqlPaymentDate,
            'created' => $created, // Server-generated timestamp
        ];

        log_message('debug', 'Final data for insertion: ' . print_r($data, true));

        // Check if created field is properly set
        if (empty($data['created'])) {
            log_message('error', 'Created field is empty before insertion');
            return $this->response->setJSON([
                'res' => 'error',
                'message' => 'Created date is required'
            ]);
        }

        // Try direct database insertion
        try {
            $builder = $db->table('paidhistory');
            $result = $builder->insert($data);
            
            if ($result) {
                $insertID = $db->insertID();
                log_message('debug', 'Direct insert successful. Insert ID: ' . $insertID);
                
                return $this->response->setJSON([
                    'res' => 'success',
                    'message' => 'Transaction inserted successfully!',
                    'insert_id' => $insertID,
                    'pay_id' => $pay_id,
                    'debug_data' => $data // Remove this in production
                ]);
            } else {
                $error = $db->error();
                log_message('error', 'Direct insert failed. Error: ' . print_r($error, true));
                
                return $this->response->setJSON([
                    'res' => 'error',
                    'message' => 'Database error: ' . ($error['message'] ?? 'Unknown error'),
                    'code' => $error['code'] ?? 0
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Insert exception: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'res' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
        
    } else {
        return $this->response->setJSON([
            'res' => 'error',
            'message' => 'Invalid request method'
        ]);
    }
}

// public function insert() {

//     if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

//            // $transactionModel = new Transaction_model();



//            //  $last_cid = $this->crudModel->get_last_cid();
//            //  $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;

        
//               //$this->crudModel->set_auto_increment();
        

//             $created = $this->request->getPost('created');

//             // Convert the input date to DateTime object
//             $date = new \DateTime($created);

//             // Format the date to Y-m-d (MySQL compatible format)
//             $formattedDate = $date->format('Y-m-d'). ' ' . date('H:i:s');

//             $dateofpayment = $this->request->getPost('dateofpayment');
//             $date2 = new \DateTime($dateofpayment);

//             // Format the date to Y-m-d H:i:s (MySQL compatible format, includes current time)
//             $formattedDate2 = $date2->format('Y-m-d') . ' ' . date('H:i:s');


//      $db = \Config\Database::connect();

     
//      if (date('m') > 3) {
//             $year = date('y') . "-" . (date('y') + 1);
//         } else {
//             $year = (date('y') - 1) . "-" . date('y');
//         }

//         $date = date('Y-m-d');



//         // SQL query to get the next invoice ID
//         // $datalogger = "
//         //     SELECT CONCAT_WS('/', '$year', COALESCE(LPAD(
//         //         CASE 
//         //             WHEN '$date' >= DATE_FORMAT('$date','%Y-04-01') 
//         //             THEN SUM(created >= DATE_FORMAT('$date','%Y-04-01')) 
//         //             ELSE SUM(created BETWEEN DATE_FORMAT('$date','%Y-04-01') - INTERVAL 1 YEAR AND DATE_FORMAT('$date','%Y-04-01'))
//         //         END + 1, 4, 0)
//         //     , LPAD(1, 4, 0))) AS pay_id 
//         //     FROM paidhistory";


//          //echo $datalogger;   

//         $datalogger="SELECT pay_id
//     FROM paidhistory
//     WHERE pay_id LIKE 'T/$year/%'
//     ORDER BY pay_id DESC
//     LIMIT 1";

//         // Execute the query
//         $stmt = $db->query($datalogger);
//         $row = $stmt->getRow();

//         // Determine the invoice number
//         if ($row) {
//     $parts = explode('/', $row->pay_id);
//     $lastNumber = intval(end($parts));
//     $nextNumber = $lastNumber + 1;
// } else {
//     $nextNumber = 1;
// }

// // Final Pay ID
// $pay_id = "T/$year/" . sprintf('%04d', $nextNumber);






//             // Prepare data for insertion
//             $data = [
//                 'pay_id'  => trim($pay_id),
//                 'cid'   => $this->request->getPost('co'),
//                 'purpose' => $this->request->getPost('purpose'),
//                 'amount' => $this->request->getPost('amount'),
//                 'bank'  => $this->request->getPost('ctype'),
//                 'dateofpayment' => $formattedDate2,
//                 //'created'    => $this->request->getPost('email'), // Ensure this is included
                
//                 'created'  => $formattedDate,
//             ];
//             //print_r($this->request->getPost());

//             //print_r($data);   
//             // Attempt to save the record
//             $response = $this->crudModel->saverecords($data);

//             //echo $this->crudModel->setQuery($response);


//             //print_r($response);

//            // $lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query


//             if ($response) {

                
            
//                 // Return success response in JSON format
//                 return $this->response->setJSON([
//                     'res' => 'success',
//                     'message' => 'Records saved successfully.',
//                     //'query' => (string) $lastQuery, // Include the last query in the response

//                 //'redirect' => base_url('/client/manageclients'), 
//                 ]);
                
//             } else {
//                $error = $this->crudModel->error();

//                 // Return error response if insertion fails
//                 return $this->response->setJSON([
//                     'res' => 'error',
//                     //'message' => 'Insert failed.',
//                     'message' => $error['message'],
//             'code' => $error['code'],
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



public function delete()
{
    $del_id = $this->request->getGet('del_id');  // Get `del_id` from query string
    
    if (!$del_id) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid ID'])->setStatusCode(400);
    }

    log_message('debug', 'Delete function called with ID: ' . $del_id);

    // Continue with your deletion logic
    $transactionModel = new Transaction_model();
    $record = $transactionModel->where('pay_id', $del_id)->first();

    if (!$record) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Record not found'])->setStatusCode(404);
    }

    $transactionModel->where('pay_id', $del_id)->delete();
    return $this->response->setJSON(['status' => 'success', 'message' => 'Transaction deleted successfully']);
}




public function edit()
{
    $edit_id = $this->request->getGet('edit_id'); // Get the `edit_id`
    
    // Fetch the main transaction record
    $transaction = $this->crudModel->single_entry($edit_id);

    if ($transaction) {
        // Fetch the `c_name` using `cid` from the transaction
        $clientDetails = $this->crudModel->getClientDetails($transaction['cid']);

        // Add `c_name` to the response
        $transaction['c_name'] = $clientDetails['c_name'] ?? 'Unknown';
                $transaction['location']  = $clientDetails['location'] ?? 'Unknown';


        return $this->response->setJSON([
            'status' => 'success',
            'post' => $transaction
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Transaction not found'
        ]);
    }
}


public function update() {

    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

            
            log_message('debug', 'Request data: ' . print_r($this->request->getGet(), true)); 

        

             $cid=$this->request->getPost('payidedit');

             log_message('debug', 'CID: ' . $cid); // Log the cid value

            $created = $this->request->getPost('editcreated');

            // Convert the input date to DateTime object
            $date = new \DateTime($created);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d'). ' ' . date('H:i:s');

            $dateofpayment = $this->request->getPost('editdateofpayment');
            $date2 = new \DateTime($dateofpayment);

            // Format the date to Y-m-d H:i:s (MySQL compatible format, includes current time)
            $formattedDate2 = $date2->format('Y-m-d');


            // Prepare data for insertion
            $data = [
               // 'pay_id'  => $this->request->getPost('payidedit'),
                'cid'   => $this->request->getPost('coedit'),
                'purpose' => $this->request->getPost('editpurpose'),
                'amount' => $this->request->getPost('editamount'),
                'bank'  => $this->request->getPost('editctype'),
                'dateofpayment' => $formattedDate2,
                //'created'    => $this->request->getPost('email'), // Ensure this is included
                
                'created'  => $formattedDate,
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


public function loadTransactions()
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

     $ctype=is_numeric($this->request->getGet('clienttype')) ? $this->request->getGet('clienttype') : null;  
        //$ctype = $this->request->getPost('ctype') ?? 'null';

    // Call the model function
    $this->crudModel = new Transaction_model();

    $invoices = $this->crudModel->getTransactions($startDate, $endDate,$customer, $ctype);

    
    $totalAmount = 0;

    // Loop through each invoice and calculate totals
    foreach ($invoices as $invoice) {
        
        $totalAmount += $invoice['amount'];
    }

    // Create the result array with totals
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($invoices),
        "iTotalDisplayRecords" => count($invoices),
        "aaData" => $invoices,
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
           return $this->response->setJSON([
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => [],
        "totalAmount" => 0
    ]);
    }


    // Return the response as JSON
    return $this->response->setJSON($results);
}


    
}
?>