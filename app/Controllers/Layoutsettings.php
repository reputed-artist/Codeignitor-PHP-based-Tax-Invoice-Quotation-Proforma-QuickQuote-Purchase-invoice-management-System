<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Stores layout options (from the AdminLTE control sidebar in
 * views/Include/settings.php) in the session so they persist
 * across every page of the project.
 */

class Layoutsettings extends Controller
{
    public function save()
    {
        helper('getState');

        if ($this->request->isAJAX() || $this->request->getMethod() === 'post') {
            $key   = $this->request->getPost('key');
            $value = $this->request->getPost('value');

            // Whitelist of allowed layout option keys
            $allowed = ['fixed-layout', 'boxed-layout', 'sidebar-collapse', 'control-sidebar-slide'];

            if ($key !== null && in_array($key, $allowed, true)) {
                // Normalise the incoming value. Note: never rely on truthiness of
                // the raw string - "0" is truthy in PHP - so cast explicitly.
                $intValue = ($value === '1' || $value === 1 || $value === true) ? 1 : 0;

                // Fixed and boxed layouts are mutually exclusive. Enforce it
                // server-side so a stale value can never hide the active layout.
                // Turning one on removes the other from the session.
                if ($key === 'fixed-layout' && $intValue) {
                    removeState('boxed-layout');
                } elseif ($key === 'boxed-layout' && $intValue) {
                    removeState('fixed-layout');
                }

                // Checked (1) => store in session. Unchecked (0) => delete the
                // session value entirely so getState() returns false.
                if ($intValue) {
                    setState($key, 1);
                } else {
                    removeState($key);
                }

                return $this->response->setJSON(['status' => 'ok', 'key' => $key, 'value' => $intValue]);
            }

            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid layout key']);
        }

        return $this->response->setStatusCode(405);
    }
}
