<?php

namespace App\Http\Controllers\WEB\Docter;

use App\Http\Controllers\DocterController;
use App\Models\Docter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends DocterController
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('docter.auth.login');
    }

    /**
     * Login for docter
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('docter')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('docter')->user(); // Get the authenticated user using the 'docter' guard
            if ($user->hasRole('docter')) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            } else {
                Auth::guard('docter')->logout();
                return redirect()->route('login')->with('failed', 'You do not have access to the dashboard.');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}