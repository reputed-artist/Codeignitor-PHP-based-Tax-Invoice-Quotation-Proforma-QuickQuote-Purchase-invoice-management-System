<?php
// app/Controllers/Errors.php

namespace App\Controllers;

use CodeIgniter\Controller;

class Errors extends Controller
{
    public function show404()
    {
        return view('errors/404');  // Load your custom 404 page
    }
}
?>