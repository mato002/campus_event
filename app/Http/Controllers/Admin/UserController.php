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
        // Automatically update status based on is_verified column
        $users = RegularUser::paginate(7);

        foreach ($users as $user) {
            if ($user->is_verified == 1) {
                $user->status = 1; // Active if verified
            } else {
                $user->status = 0; // Inactive if not verified
            }
            $user->save();
        }

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

    /**
     * Manually activate a user (if verified).
     */
    public function activate($id)
    {
        $user = RegularUser::findOrFail($id);

        if ($user->is_verified == 1) {
            $user->status = 1; // Active
            $user->save();

            return redirect()->back()->with('success', 'User activated successfully.');
        }

        return redirect()->back()->with('error', 'User cannot be activated because they are not verified.');
    }

    /**
     * Manually deactivate a user.
     */
    public function deactivate($id)
    {
        $user = RegularUser::findOrFail($id);
        $user->status = 0; // Inactive
        $user->save();

        return redirect()->back()->with('success', 'User deactivated successfully.');
    }
}
