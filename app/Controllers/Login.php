<?php

namespace App\Controllers;

use App\Models\Account_model;
use App\Models\Client_model;
use App\Models\Admin_model; // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

class Login extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        //$this->crudModel = new Account_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
           
    return view('login');
    }

public function userlogin()
{
    if ($this->request->isAJAX()) {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Debug: Check if data is received
        if (!$username || !$password) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username or password missing!']);
        }

        $loginModel = new Admin_model();
        $user = $loginModel->where('username', $username)->first();

        // Debug: Print fetched user data
        if (!$user) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not found!']);
        }

        // Debug: Check received password
        if ($password !== $user['password']) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid password!']);
        }

        // Set session
        $session = session();
        $session->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'name' => $user['name'],
            'user_image' => base_url('public/dist/img/uploads/' . $user['picture']),
            'company_logo' => base_url('public/dist/img/uploads/' . $user['picturelogo']),
            'logged_in' => true
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Login successful!']);
    }
}

public function logout() {
    $session = session();
    
    // Destroy the session to log the user out
    $session->destroy();
    
    // Redirect to the login page after logout
    return redirect()->to(base_url('/login')); // Corrected here
}


}
?>