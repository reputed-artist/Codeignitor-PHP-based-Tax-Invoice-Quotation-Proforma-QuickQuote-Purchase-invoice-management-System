<?php

namespace App\Controllers;

use App\Models\Transaction_model;
use App\Models\Client_model; // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;
use App\Models\Admin_model;
use App\Models\Bank_model;

class Profile extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Transaction_model(); // Load model
        
        helper(['url', 'navigation', 'getProfileImage', 'money_format']); 

        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect(); 
    }

    // public function settings()
    // {
    //   //echo "hello users";      
    // return view('layout/profile');
    // }
    public function updateData(){
        $admodel=new Admin_model();

                    $data = [
               
                'c_name'   => $this->request->getPost('cname'),
                'c_add'    => $this->request->getPost('cadd'),
                'mob'      => $this->request->getPost('cmob'),
                'pan' => $this->request->getPost('cpan'),    
                'gst'      => $this->request->getPost('cgst'),
                'email'      => $this->request->getPost('cemail'),
                
            ];


        $cddata=$admodel->updatez(1,$data);
        print_r($cddata);
    }

    public function updateData2(){
        $admodel=new Admin_model();

                    $data = [
               
                'name'   => $this->request->getPost('name'),
                'email'    => $this->request->getPost('email'),
                'qualification'      => $this->request->getPost('qualification'),
                'profession' => $this->request->getPost('profession'),    
                'location'      => $this->request->getPost('location'),
                
            ];


        $cddata=$admodel->updatez(1,$data);
        print_r($cddata);
    }

public function updateData3(){
        $admodel=new Admin_model();

                    $data = [
               
                'username'   => $this->request->getPost('name'),
                'password'    => $this->request->getPost('email'),
                
                
            ];


        $cddata=$admodel->updatez(1,$data);
        print_r($cddata);
    }


    public function settings()
    {

        $session = session(); 
        
        if ($session->has('user_id')) {
           // echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }

        $codetails=new Admin_model();

         $cozDetails = $codetails->coinfo();

        $bankdetails=new Bank_model(); 

        $bz=$bankdetails->getAllBankDetails();

       $sm=$bankdetails->stat();

         

    // Otherwise, return the view with JSON-encoded data
    $data = [
        'cozDetails' => $cozDetails,
        'bz' => $bz,
        'sm'=> $sm,
    ];


      if ($this->request->isAJAX()) {
        return $this->response->setJSON($data);
    }



      //echo "hello users";      

    return view('info layout/profileinfo',$data);
    }

public function updateBankDetails()
{
    // Retrieve bank details arrays from the form
    $bnames    = $this->request->getPost('bname');   // Array of bank names
    $acNumbers = $this->request->getPost('ac');        // Array of account numbers
    $ifscCodes = $this->request->getPost('ifsc');      // Array of IFSC codes
    $branches  = $this->request->getPost('branch');    // Array of branch names

    // Build an array of new bank records
    $newData = [];
    if (!empty($bnames) && is_array($bnames)) {
        foreach ($bnames as $i => $bname) {
            if (!empty($bname)) { // Only include rows with a bank name
                $newData[] = [
                    'bname'  => $bname,
                    'ac'     => $acNumbers[$i] ?? '',
                    'ifsc'   => $ifscCodes[$i] ?? '',
                    'branch' => $branches[$i] ?? ''
                ];
            }
        }
    }

    // Load your Admin_model
    $admodel = new Bank_model();

    // Call the model method to update bank details using TRUNCATE and batch insert
    $result = $admodel->updateBankDetailsUsingTruncate($newData);

    if ($result) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Bank details updated successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update bank details.'
        ]);
    }
}



public function uploadProductImage() {
    helper(['form', 'url']);

    if ($this->request->getMethod() === 'post') {
        $file = $this->request->getFile('picture'); // Ensure this matches the front-end field name 'picture'

        if (!$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => $file->getErrorString()]);
        }

        // Generate a new unique filename
        $newName = $file->getRandomName();
        $productId = 1;

        // Move file to the target directory
        if ($file->move(FCPATH . 'public/dist/img/uploads/', $newName)) {
            // Save filename to database
            $this->db->table('admin')->where('id', $productId)->update(['picture' => $newName]);

            $session = session();

            $session->set([
            'user_image' => base_url('public/dist/img/uploads/' . $newName),
            'logged_in' => true
        ]);

            return $this->response->setJSON([
                'success' => true,
                'filename' => $newName,
                'filepath' => base_url() . '/public/dist/img/uploads/' . $newName // Return full file path


            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to move uploaded file.'
            ]);
        }
    }

    return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
}
public function uploadProductImage2() {
    helper(['form', 'url']);

    if ($this->request->getMethod() === 'post') {
        $file = $this->request->getFile('picturelogo'); // Ensure this matches the front-end field name 'picture'

        if (!$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => $file->getErrorString()]);
        }

        // Generate a new unique filename
        $newName = $file->getRandomName();
        $productId = 1;

        // Move file to the target directory
        if ($file->move(FCPATH . 'public/dist/img/uploads/', $newName)) {
            // Save filename to database
            $this->db->table('admin')->where('id', $productId)->update(['picturelogo' => $newName]);

            //session()->set('pic', base_url() . '/public/dist/img/uploads/' . $newName);

              $session = session();

            $session->set([
            'company_logo' => base_url('public/dist/img/uploads/' . $newName),
            'logged_in' => true
        ]);

            return $this->response->setJSON([
                'success' => true,
                'filename' => $newName,
                'filepath' => base_url() . '/public/dist/img/uploads/' . $newName // Return full file path
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to move uploaded file.'
            ]);
        }
    }

    return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
}


public function dbbackup()
{
    helper('filesystem'); // Load File Helper

    // Get DB connection
    $db = \Config\Database::connect();
    $tables = $db->listTables(); // Get all table names

    if (empty($tables)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'No tables found in the database.']);
    }

    $backupSql = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
    $backupSql .= "SET time_zone = \"+00:00\";\n\n";
    $backupSql .= "/*!40101 SET NAMES utf8 */;\n\n";
    $backupSql .= "-- Database Backup: `" . $db->database . "`\n\n";

    // Loop through tables
    foreach ($tables as $table) {
        $query = $db->query("SHOW CREATE TABLE `$table`");
        $result = $query->getRowArray();

        if (!isset($result['Create Table'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => "Error fetching structure for table `$table`"]);
        }

        // Add table structure to backup
        $backupSql .= "\n\n" . $result['Create Table'] . ";\n\n";

        // Fetch Table Data
        $query = $db->query("SELECT * FROM `$table`");
        $rows = $query->getResultArray();

        if (!empty($rows)) {
            $backupSql .= "INSERT INTO `$table` VALUES \n";
            $values = [];

            foreach ($rows as $row) {
                $escapedRow = array_map(fn($value) => $db->escape($value), $row);
                $values[] = "(" . implode(",", $escapedRow) . ")";
            }

            $backupSql .= implode(",\n", $values) . ";\n\n";
        }
    }

    // File Name and Path
    $backupFileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $backupFilePath = WRITEPATH . 'backups/' . $backupFileName;

    // Attempt to write the backup file
    if (!write_file($backupFilePath, $backupSql)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Backup failed: Unable to write the file.']);
    }

    // Successful backup
    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Backup completed successfully!',
        'file' => base_url('backups/' . $backupFileName) ,// Provide the path to the backup file
    ]);
}


public function restoreDB()
{
    // Check if file is uploaded
    if (!empty($_FILES["backup_file"]["name"])) {
        // Validate file extension
        $fileExt = strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION));
        
        if ($fileExt != 'sql') {
            $response = array(
                "type" => "error",
                "message" => "Invalid File Type"
            );
            echo json_encode($response);
            return;
        }

        // Directory to store the uploaded backup file
        $uploadPath = WRITEPATH . 'uploads/'; // Adjust if needed
        $filePath = $uploadPath . $_FILES["backup_file"]["name"];

        if (move_uploaded_file($_FILES["backup_file"]["tmp_name"], $filePath)) {
            // Using the database connection available in CodeIgniter 4
            $conn = $this->db->initialize(); // Ensure the connection is initialized
            $conn = $this->db->connID; // Use `connID` instead of `conn_id`

            
            // Perform the restore operation
            $response = $this->restoreMysqlDB($filePath, $conn);
        } else {
            $response = array(
                "type" => "error",
                "message" => "Error uploading the file."
            );
        }
    } else {
        $response = array(
            "type" => "error",
            "message" => "No file selected."
        );
    }

    // Return the response in JSON format
    echo json_encode($response);
}

// Change from private to protected or public
protected function restoreMysqlDB($filePath, $conn)
{
    $sql = '';
    $error = '';

    if (file_exists($filePath)) {
        $lines = file($filePath);

        foreach ($lines as $line) {
            // Ignore comments from the SQL script
            if (substr($line, 0, 2) == '--' || trim($line) == '') {
                continue;
            }

            $sql .= $line;

            // If the line ends with a semicolon, execute the SQL query
            if (substr(trim($line), -1, 1) == ';') {
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    $error .= mysqli_error($conn) . "\n";
                }

                $sql = ''; // Reset the query string
            }
        }

        if ($error) {
            $response = array(
                "type" => "error",
                "message" => "Error during restore: " . $error
            );
        } else {
            $response = array(
                "type" => "success",
                "message" => "Database Restore Completed Successfully."
            );
        }

        // Optionally, remove the backup file after restoring
        unlink($filePath);
    } else {
        $response = array(
            "type" => "error",
            "message" => "Backup file not found."
        );
    }

    return $response;
}

// Check if the table exists
private function tableExists($conn, $tableName)
{
    $query = "SHOW TABLES LIKE '$tableName'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}



}
?>