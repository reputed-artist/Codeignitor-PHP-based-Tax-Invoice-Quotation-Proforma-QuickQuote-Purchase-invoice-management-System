<?php

namespace App\Controllers;

use App\Models\Product_model;
use App\Models\Supplier_model;
use App\Models\Client_model;
use App\Models\Techsps_model; // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

class Product extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Product_model(); // Load model
        helper('url');
        helper('navigation');

        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }



// In your get_next_id controller method
public function get_next_id()
{
    try {
        $crudModel=new Product_model();
        // Your logic to get the next ID
        $next_id = $this->crudModel->get_last_cid(); // Adjust this line based on your logic
        return $this->response->setJSON(['next_id' => $next_id]);
    } catch (Exception $e) {
        log_message('error', 'Failed to get next ID: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to fetch next ID.']);
    }
}



public function viewproductinfo($infoid) {

    $session = session(); 

    if ($session->has('user_id')) {
            //echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }
    
    $productModel = new Product_model();
    $clientModel = new Client_model();
    //$supplierModel = new Supplier_model();

    // Fetch product details
   $productDetails = $productModel->getProductDetails($infoid);


// Proceed with accessing product name if $productDetails is valid
    $donut = $productModel->getProductPie($productDetails['name']);


    // Fetch tax invoices (assuming it's a list of invoices related to this product)
    $taxinvoice = $productModel->getproductinv($productDetails['name']);


    $proinvoice = $productModel->getproductproinv($productDetails['name']);
    

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

    // Prepare the data array for passing to the view
    $data = [
        'donut' => $donut,
        'productDetails' => $productDetails,
        'taxInvoices' => json_encode($results),
        'proInvoices'=> json_encode($results2) // Pass JSON-encoded results
    ];

    // Optionally log or remove print_r in production
    //print_r($data); // Debugging output

    // Return the view with the data
    //return view('info layout/getproductinfo', compact('productDetails', 'donut', 'taxInvoices'));
    return view('info layout/getproductinfo', ['productDetails' => $productDetails, 'donut' => $donut, 'taxInvoices' => json_encode($results),
        'proInvoices'=> json_encode($results2)]);

}


public function manageproducts()
{
    $session = session(); 

    if ($session->has('user_id')) {
           // echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }

    // Get the last client ID and calculate the next one
    $last_cid = $this->crudModel->get_last_cid();
    $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;

    // Fetch all records
    //$records = $this->crudModel->findAll();

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
        'next_cid' => $next_cid,
        'results' => json_encode($results)
    ];

    return view('layout/manage-products', $data);
}

 
//  public function get_next_id()
// {
//     try {
//         $crudModel=new Product_model();
//         // Your logic to get the next ID
//         $next_id = $crudModel->get_last_cid(); // Adjust this line based on your logic
//         return $this->response->setJSON(['next_id' => $next_id]);
//     } catch (Exception $e) {
//         log_message('error', 'Failed to get next ID: ' . $e->getMessage());
//         return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to fetch next ID.']);
//     }
// }

public function insert() {
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {
        $response = ["success" => false, "message" => ""];

            $last_cid = $this->crudModel->get_last_cid();
            $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;
    
        $file=$this->request->getPost('imgname');

        // Prepare data for insertion
        $data = [
            'p_id' => $next_cid,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'hsn' => $this->request->getPost('hsn'),
            'p_type' => $this->request->getPost('ptype'),
            'cattype'=> $this->request->getPost('cattype'),
            'img_loc' => $file, // Store the relative file path
            'techs'=> $this->request->getPost('techs'),
            'created' => date('Y-m-d'), // Assuming created is the current date
        ];
        //print_r($data);

        // // Insert product data
        // $this->crudModel->insert($data);

                if ($this->crudModel->insert($data)) {
            $response = [
                "success" => true,
                "filename" => $file
            ];
        } else {
            $response["message"] = "Failed to insert product data.";
        }

        

        // Return JSON response
        // $response = [
        //     "success" => true,
        //     "filename" => $file
        // ];
        return $this->response->setJSON($response);
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

            $pid=$this->request->getPost('p_id');

            log_message('debug', 'CID: ' . $pid); // Log the cid value


           // $file = $this->request->getFile('file_input1');
            $fileName = session()->get('uploaded_file'); // Retrieve the file name from session

if (!$fileName) {
    $fileName = ''; // No image uploaded
}




            // Prepare data for insertion
         $data = [
            'p_id' => $this->request->getPost('p_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'hsn'   => $this->request->getPost('hsn'),
            'p_type' => $this->request->getPost('ptype'),
            'cattype'=> $this->request->getPost('cattype'),
            'img_loc'=> $fileName,
            'techs' =>  $this->request->getPost('techs1'),
            'created' => date('Y-m-d'), // Assuming created is the current date
        ];

        //print_r($data);


        //log_message('debug', 'Update Data: ' . print_r($data, true)); 

             //print_r($data);   
            // Attempt to save the record
            $response = $this->crudModel->updaterecord($pid, $data);

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


public function uploadProductImage()
{
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $response = [
        "success" => false,
        "message" => "",
        "filename" => "",
        "filepath" => "" // Include filepath in response
    ];

    // Check if a file has been uploaded
    if ($this->request->getFile('uploadimg')) {
    $file = $this->request->getFile('uploadimg');
    
    // Set the correct directory (absolute path to public directory)
    $targetDir = FCPATH . '/public/dist/img/';  // FCPATH points to the public folder directly
    $fileName = $file->getRandomName();  // To avoid overwriting files

    // Allowed file extensions
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = $file->getExtension();

    // Validate file type
    if (!in_array($fileExtension, $allowedFileTypes)) {
        $response["message"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
    // Validate file size (5MB limit)
    elseif ($file->getSize() > 5242880) {
        $response["message"] = "Sorry, your file is too large.";
    }
    // Validate if the file is an image
    elseif (!$file->isValid() || $file->getMimeType() === false) {
        $response["message"] = "File is not an image.";
    } else {
        // Move the file to the target directory
        if ($file->move($targetDir, $fileName)) {
            $response["success"] = true;
            $response["filename"] = $fileName;
            $response["filepath"] = base_url() . '/public/dist/img/' . $fileName;  // Return the URL path, not local path
            $response["message"] = "The file " . htmlspecialchars($fileName) . " has been uploaded.";
        } else {
            $response["message"] = "Sorry, there was an error uploading your file.";
        }
    }
} else {
    $response["message"] = "No file uploaded.";
}

// Return the response in JSON format
return $this->response->setJSON($response);
}


public function updateuploadProductImage()
{
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $response = [
        "success" => false,
        "message" => "",
        "filename" => "",
        "filepath" => "" // Include filepath in response
    ];

    // Check if a file has been uploaded
    if ($this->request->getFile('uploadimg1')) {
    $file = $this->request->getFile('uploadimg1');
    
    // Set the correct directory (absolute path to public directory)
    $targetDir = FCPATH . '/public/dist/img/';  // FCPATH points to the public folder directly
    $fileName = $file->getRandomName();  // To avoid overwriting files

    // Allowed file extensions
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = $file->getExtension();

    // Validate file type
    if (!in_array($fileExtension, $allowedFileTypes)) {
        $response["message"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
    // Validate file size (5MB limit)
    elseif ($file->getSize() > 5242880) {
        $response["message"] = "Sorry, your file is too large.";
    }
    // Validate if the file is an image
    elseif (!$file->isValid() || $file->getMimeType() === false) {
        $response["message"] = "File is not an image.";
    } else {
        // Move the file to the target directory
        if ($file->move($targetDir, $fileName)) {
            $response["success"] = true;
            $response["filename"] = $fileName;
            $response["filepath"] = base_url() . '/public/dist/img/' . $fileName;  // Return the URL path, not local path
            $response["message"] = "The file " . htmlspecialchars($fileName) . " has been uploaded.";
                    session()->set('uploaded_file', $fileName); 
        } else {
            $response["message"] = "Sorry, there was an error uploading your file.";
        }
    }
} else {
    $response["message"] = "No file uploaded.";
}

// Return the response in JSON format
return $this->response->setJSON($response);
}
}
?>