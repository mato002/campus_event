<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegularUser; // Ensure you use the correct model
use Illuminate\Support\Facades\Storage; // Import Storage

class UserProfileController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }

    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Process Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('regular_user')->attempt($credentials)) {
            return redirect()->route('user.profile'); // Redirect to profile
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Show Register Form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Process Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:regular_users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:15',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $user = RegularUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'location' => $request->location,
            'bio' => $request->bio,
        ]);

        Auth::guard('regular_user')->login($user);
        return redirect()->route('user.profile');
    }

    // Show User Profile
    public function profile()
    {
        return view('user.profile');
    }

    // Process Logout
    public function logout(Request $request)
    {
        Auth::guard('regular_user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function edit()
    {
        $user = Auth::guard('regular_user')->user();
        return view('user.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('regular_user')->user();

        // Validate inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:regular_users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:15',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete('public/profile_pictures/' . $user->profile_picture);
            }
            $filename = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->storeAs('public/profile_pictures', $filename);
            $user->profile_picture = $filename;
        }

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'profile_picture' => $user->profile_picture,
            'phone' => $request->phone,
            'location' => $request->location,
            'bio' => $request->bio,
        ]);

        return redirect()->route('user.edit_profile')->with('success', 'Profile updated successfully!');
    }
}
