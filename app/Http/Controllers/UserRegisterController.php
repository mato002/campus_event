<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegularUser; // Use RegularUser instead of User
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserRegisterController extends Controller
{
    /**
     * Show the user registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.user-register');
    }

    /**
     * Handle the user registration request.
     */
    public function register(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:regular_users', // Change table name
            'password' => 'required|string|min:6|confirmed',
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new regular user
        $regularUser = RegularUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Automatically log in the regular user after registration
        Auth::guard('regular_user')->login($regularUser);

        // Redirect to the user dashboard or home page
        return redirect()->route('user.profile')->with('success', 'Registration successful! You are now logged in.');
    }
}
