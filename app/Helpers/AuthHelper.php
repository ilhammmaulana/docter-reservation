<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getDataUser')) {
    function getDataUser()
    {
        // Check the "web" guard first.
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }
        elseif (Auth::guard('docter')->check()) {
            return Auth::guard('docter')->user();
        }

        return null;
    }
}

if (!function_exists('isDocter')) {
    function isDocter()
    {
        return Auth::guard('docter')->check();
    }
}
