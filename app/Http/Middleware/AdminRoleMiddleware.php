<?php

namespace App\Http\Middleware;

use Closure; // ✅ Ensure Closure is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ensure the user is logged in and has an 'admin' role
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Access Denied: Admins only.');
        }

        // Redirect non-admin users to /dashboard
        return redirect('/dashboard')->with('error', 'Access Denied.');
    }
}
