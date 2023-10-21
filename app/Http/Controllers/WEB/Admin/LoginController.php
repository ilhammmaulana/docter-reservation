<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('admin.auth.login');
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

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('web')->user(); // Get the authenticated user using the 'admin' guard
            if ($user->hasRole('admin')) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            } else {
                Auth::guard('web')->logout();
                return redirect()->route('admin.login-form')->with('failed', 'You do not have access to the dashboard.');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('docter')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
