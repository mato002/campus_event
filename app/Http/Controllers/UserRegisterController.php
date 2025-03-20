<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegularUser;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        // Validate form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:regular_users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate alphanumeric verification code
        $verificationCode = strtoupper(Str::random(8));  // Random 8-character code (mix of letters and numbers)

        // Create a new regular user
        $regularUser = RegularUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode,
            'is_verified' => false, // Initially false
        ]);

        // Send verification email notification
        $regularUser->notify(new VerifyEmailNotification($verificationCode));

        // Redirect to the email verification notice page
        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email and verify your account using the verification code.');
    }
}
