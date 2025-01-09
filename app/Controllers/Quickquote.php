<?php


namespace App\Controllers;

use CodeIgniter\Controller;


use App\Models\Product_model;
use App\Models\Quickquote_model;



class Quickquote extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Quickquote_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {

        $session = session(); 
        
        if ($session->has('user_id')) {
            //echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }

        $crudModel2= new Product_model();

         // $records = $this->crudModel->findAll();
       $records = $crudModel2
        ->select('img_loc, name, p_id')
        ->where('p_type !=', 'freight') // Exclude 'freight'
        ->groupBy('img_loc')
        ->orderBy('p_id', 'ASC') // Sort by p_id in ascending order
        ->findAll();


        $response = [
        'status' => 'success',
        'data' => array_map(function ($product) {
            return [
                'p_id' => $product['p_id'],
                'name' => $product['name'],
                'img_loc' => base_url("public/dist/img/" . $product['img_loc']), // Adjust image path
            ];
        }, $records),
    ];

        if ($this->request->isAJAX()) {
        return $this->response->setJSON($response);
    }

    // Otherwise, pass data to the view
    $data['products'] = $records;
        return view('layout/genquickquotation', $data); // Make sure 'test.php' is in app/Views/
    }


public function insertquickquote()
{
    if ($this->request->getMethod() === 'POST' || $this->request->isAJAX()) {
        $db = \Config\Database::connect();

        // Determine the financial year
        $currentYear = date('y');
        $nextYear = date('y') + 1;
        $prevYear = date('y') - 1;
        $financialYear = (date('m') > 3) ? "$currentYear-$nextYear" : "$prevYear-$currentYear";

        $date = date('Y-m-d');

        // Generate the next q_id
        $query = "SELECT COUNT(*) + 1 AS next_id FROM quickquote";
        $stmt = $db->query($query);
        $row = $stmt->getRow();
        $nextId = $row ? sprintf('%04s', $row->next_id) : '0001';

        $q_id = "QUICKT/$financialYear/$nextId";

        // Prepare data for insertion
        $data = [
            'sr_no'=>Null, 
            'q_id' => $q_id,
            'p_id' => $this->request->getPost('productId'),
            'mob' => $this->request->getPost('mobileNumber'),
            'quantity' => $this->request->getPost('quantity'),
            'price' => $this->request->getPost('price'),
            'subtotal' => $this->request->getPost('subtotal'),
            'gst' => $this->request->getPost('gst'),
            'total' => $this->request->getPost('total'),
            'created' => $date,
        ];

        // Save record
        $crudModel = new Quickquote_model();
        if ($crudModel->saverecords($data)) {
            return $this->response->setJSON([
                "success" => true,
                "message" => 'quote saved',
                "q_id"=>$q_id
            ]);
        } else {
            return $this->response->setJSON([
                "success" => false,
                "message" => "Failed to insert product data."
            ]);
        }
    }
}


public function printquickquote(){
    $q_id = $this->request->getGet('qid'); // Get qid from URL parameter

    if (!$q_id) {
        return $this->response->setJSON(['error' => 'Q_ID is required']);
    }

    $cdx = new Quickquote_model();
    $dv = $cdx->fulldata($q_id); // Fetch data for q_id

    // Debugging output
    if (empty($dv)) {
        return $this->response->setJSON(['error' => 'No data found for Q_ID: ' . $q_id]);
    }

    if ($this->request->isAJAX()) {
    return $this->response->setHeader('Content-Type', 'application/json')
                          ->setJSON($dv);
}
 else {
        return view('print/printquickq', ['dv' => json_encode($dv)]);
    }
}


}
