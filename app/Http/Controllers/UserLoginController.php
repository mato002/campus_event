<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegularUser; // Import RegularUser model

class UserLoginController extends Controller
{
    /**
     * Show the user login form.
     */
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    /**
     * Handle the user login request.
     */
    public function login(Request $request)
    {
        // Validate form input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in using 'regular_user' guard
        if (Auth::guard('regular_user')->attempt($credentials)) {
            return redirect()->route('user.profile')->with('success', 'Login successful!');
        }

        // If login fails, return error message
        return redirect()->back()->with('error', 'Invalid email or password');
    }

    /**
     * Log the user out.
     */
    public function logout()
    {
        Auth::guard('regular_user')->logout();
        return redirect()->route('user.login')->with('success', 'You have been logged out.');

    }

    protected function authenticated(Request $request, $RegularUser)
{
    return redirect()->route('user.profile');
}

}
