<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Make sure to import Auth

class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Ensure that the user is logged in and has been verified
        if (Auth::guard('regular_user')->check() && !Auth::guard('regular_user')->user()->is_verified) {
            Auth::guard('regular_user')->logout();

            // Redirect to the verification notice page
            return redirect()->route('verification.notice')->withErrors(['You must verify your account first.']);
        }

        // Proceed with the request if the user is verified
        return $next($request);
    }
}
