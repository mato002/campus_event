<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    /**
     * Show the admin's profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // Get the authenticated user (admin)
        $admin = Auth::user();

        // Return the profile view with the admin's details
        return view('admin.profile', compact('admin'));
    }
}
