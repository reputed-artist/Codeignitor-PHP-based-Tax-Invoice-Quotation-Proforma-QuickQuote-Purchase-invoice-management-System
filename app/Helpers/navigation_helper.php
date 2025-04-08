<?php
use CodeIgniter\HTTP\URI;

if (!function_exists('set_active')) {
    function set_active($path, $class = 'active') {
        $current_url = current_url();

        // Ensure "getledger" also activates "manageaccounts"
        if ($path == '/account/manageaccounts') {
            return (strpos($current_url, base_url('/account/manageaccounts')) !== false || 
                    strpos($current_url, base_url('/account/getledger')) !== false) ? $class : '';
        }

        return ($current_url == base_url($path)) ? $class : '';
    }
}
