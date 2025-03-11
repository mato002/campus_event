<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    /**
     * Show the password reset request form.
     */
    public function showResetForm()
    {
        return view('auth.password-reset');
    }

    /**
     * Handle sending the reset link.
     */
    public function sendResetLink(Request $request)
    {
        // Validate email
        $request->validate([
            'email' => 'required|email|exists:regular_users,email',
        ]);

        // Send reset link
        $status = Password::broker('regular_users')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Password reset link sent to your email.')
            : back()->withErrors(['email' => 'Unable to send reset link.']);
    }
}
