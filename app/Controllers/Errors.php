<?php
// app/Controllers/Errors.php

namespace App\Controllers;

use CodeIgniter\Controller;

class Errors extends Controller
{
    public function show404()
    {
        $this->response->setStatusCode(404);

        // CI 4.1 gathers the output buffer for a 404 override, so the view
        // must be written to that buffer instead of only returned as a Response.
        echo view('errors/404');
    }
}
