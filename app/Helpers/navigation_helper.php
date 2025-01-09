<?php
use CodeIgniter\HTTP\URI;

if (!function_exists('set_active')) {
    function set_active($path, $class = 'active') {
        return (current_url() == base_url($path)) ? $class : '';
    }
}
