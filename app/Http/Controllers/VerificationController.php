<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegularUser;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    /**
     * Show the verification form.
     */
    public function showVerificationForm()
    {
        return view('auth.verify-email');
    }

    /**
     * Verify the user's email using the verification code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|min:6|max:8',
        ]);

        // Find the user by the verification code
        $user = RegularUser::where('verification_code', $request->verification_code)->first();

        if (!$user) {
            // Return back with an error if no user is found with the verification code
            return back()->withErrors(['verification_code' => 'Invalid verification code.']);
        }

        // Mark the user as verified and remove the verification code
        $user->is_verified = true;
        $user->verification_code = null; // Remove the verification code after verification

        // Save the updated user object
        $user->save();

        // Log the user in after verification
        Auth::guard('regular_user')->login($user);

        // Redirect the user to their profile page with a success message
        return redirect()->route('user.profile')->with('success', 'Your email has been verified successfully.');
    }

    /**
     * Resend the verification code to the user's email.
     */
    public function resendVerificationCode(Request $request)
{
    // Validate the email
    $request->validate([
        'email' => 'required|email|exists:regular_users,email',
    ]);

    // Find the user by email
    $user = RegularUser::where('email', $request->email)->first();

    // Optional check (might not be necessary)
    if (!$user) {
        return back()->withErrors(['email' => 'No user found with this email.']);
    }

    // Optionally check if already verified
    if ($user->is_verified) {
        return back()->withErrors(['email' => 'This account is already verified.']);
    }

    // Generate a new verification code
    $verificationCode = strtoupper(Str::random(6));

    // Save the new verification code
    $user->verification_code = $verificationCode;
    $user->save();

    // Send the verification code email
    $user->notify(new VerifyEmailNotification($verificationCode));

    return back()->with('status', 'A new verification code has been sent to your email.');
}


    /**
     * Log out the regular user and redirect to the user login page.
     */
    public function logout(Request $request)
    {
        Auth::guard('regular_user')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login')->with('status', 'You have been logged out!');
    }
}
