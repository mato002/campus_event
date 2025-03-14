<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\RegularUser;
use Illuminate\Support\Facades\Auth;

class userDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('regular_user')->user(); // Get the logged-in user

        $totalEvents = Event::count();
        $totalRegularUsers = RegularUser::count(); // If user management exists


        $bookedEvents = 0;
        $upcomingEvents = 0;

        if ($user) {
            $bookedEvents = $user->bookedEvents()->count();
        }

        $upcomingEvents = Event::where('start_date', '>=', now())->count();

        return view('home', compact('totalEvents', 'bookedEvents', 'upcomingEvents' ,'totalRegularUsers'));
    }
}
