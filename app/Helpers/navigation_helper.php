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

        if ($path == '/client/manageclients') {
            return (strpos($current_url, base_url('/client/manageclients')) !== false || 
                    strpos($current_url, base_url('/client/viewclientinfo/')) !== false) ? $class : '';
        }

         if ($path == '/product/manageproducts') {
            return (strpos($current_url, base_url('/product/manageproducts')) !== false || 
                    strpos($current_url, base_url('/product/viewproductinfo/')) !== false) ? $class : '';
        }


        if ($path == '/supplier/managesupplier') {
            return (strpos($current_url, base_url('/supplier/managesupplier')) !== false || 
                    strpos($current_url, base_url('/supplier/viewsupplierinfo/')) !== false) ? $class : '';
        }

        return ($current_url == base_url($path)) ? $class : '';
    }
}
