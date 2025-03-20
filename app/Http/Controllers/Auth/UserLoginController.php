<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash; // <-- Add this line!
use App\Models\RegularUser;

class UserLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find the user by email
        $user = RegularUser::where('email', $request->email)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return Redirect::back()->withErrors(['email' => 'Invalid credentials.']);
        }

        // Check if user has verified their email
        if (!$user->is_verified) {
            return redirect()->route('verification.notice')
                ->withErrors(['email' => 'Please verify your email before logging in.']);
        }

        // Log in the user using the regular_user guard
        Auth::guard('regular_user')->login($user);

        return redirect()->route('user.profile')->with('success', 'Logged in successfully!');
    }
}
