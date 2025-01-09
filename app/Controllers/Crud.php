<?php

namespace App\Controllers;

use App\Models\Crud_model; // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

class Crud extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Crud_model(); // Load model
        helper('url');
        $this->session = \Config\Services::session();
    }

    public function index()
{
    return view('show_data_view');
}

public function getMp3Files()
{
    $folderPath = FCPATH . 'F:\music'; // Replace with your folder path
    $files = [];
    
    if (is_dir($folderPath)) {
        $dir = opendir($folderPath);
        while (($file = readdir($dir)) !== false) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'mp3') {
                $files[] = base_url('F:\music' . $file); // Generate URL for frontend
            }
        }
        closedir($dir);
    }

    echo json_encode($files);
}


    public function savedata()
    {
        // Check if form is submitted
        if ($this->request->getPost('save')) {
            $data = [
                'name'  => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'city'  => $this->request->getPost('city')
            ];

            $response = $this->crudModel->saverecords($data); // Use the model method
            if ($response) {
                $this->session->setFlashdata('success', 'Records Saved Successfully');
                return redirect()->to('/crud/showdata'); // Redirect to avoid form re-submission
            } else {
                $this->session->setFlashdata('error', 'Insert error!');
            }
        }

        return view('Insert'); // Load view
    }

    public function edit($id = null)
    {
        // Fetch the record by ID
        $data['record'] = $this->crudModel->find($id);

        if (!$data['record']) {
            // Record not found
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Record with ID ' . $id . ' not found');
        }

        // Load the edit view
        return view('edit_form', $data);
    }

    public function update()
    {
        // Get the POST data
        $id = $this->request->getPost('id');
        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'city'  => $this->request->getPost('city')
        ];

        if ($this->crudModel->updaterecord($id, $data)) {
            // Redirect or show success message
            $this->session->setFlashdata('success', 'Record updated successfully');
            return redirect()->to('/crud/showdata');
        } else {
            // Handle errors
            $this->session->setFlashdata('error', 'Failed to update record');
            return redirect()->back()->withInput();
        }
    }
     public function showdata()
{
    // Fetch all records from the model
    $records = $this->crudModel->findAll();

    // Format the data in the structure DataTables expects
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($records),
        "iTotalDisplayRecords" => count($records),
        "aaData" => $records
    ];

    // Return the JSON response
    return $this->response->setJSON($results);
}


    public function delete($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Record ID is required for deletion.');
        }

        if ($this->crudModel->deleterecord($id)) {
            $this->session->setFlashdata('success', 'Record deleted successfully');
        } else {
            $this->session->setFlashdata('error', 'Failed to delete record');
        }

        // Redirect to the list of records
        return redirect()->to('/crud/showdata');
    }

}
