<?php

if (!function_exists('getState')) {
    function getState($key)
    {
        $session = session();
        return $session->get($key) ?? false; // Return session value or false if not set
    }
}
