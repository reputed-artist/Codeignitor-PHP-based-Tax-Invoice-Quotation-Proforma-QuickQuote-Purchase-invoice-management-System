<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return view('login'); // Ensure your login view file exists in app/Views/login.php
    }
}
