<?php

if (!function_exists('getState')) {
    function getState($key)
    {
        $session = session();
        return $session->get($key) ?? false; // Return session value or false if not set
    }
}

if (!function_exists('setState')) {
    function setState($key, $value)
    {
        $session = session();
        $session->set($key, $value);
    }
}

if (!function_exists('removeState')) {
    function removeState($key)
    {
        $session = session();
        $session->remove($key);
    }
}
