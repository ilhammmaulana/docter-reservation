<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getDataUser')) {
    function getDataUser()
    {
        // Check the "web" guard first.
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }
        // If "web" guard is not authenticated, check the "docter" guard.
        elseif (Auth::guard('docter')->check()) {
            return Auth::guard('docter')->user();
        }

        // Handle other cases or return null as needed.
        return null;
    }
}
