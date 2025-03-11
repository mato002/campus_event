<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegularUser; // Import RegularUser Model

class UserController extends Controller
{
    /**
     * Display a listing of the regular users.
     */
    public function index()
    {
        $users = RegularUser::paginate(10); // Fetch users with pagination
        return view('admin.manage-users', compact('users'));
    }

    /**
     * Remove a user from the system.
     */
    public function destroy($id)
    {
        $user = RegularUser::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.manage-users')->with('success', 'User deleted successfully.');
    }
}
