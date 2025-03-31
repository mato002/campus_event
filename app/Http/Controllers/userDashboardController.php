<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\RegularUser;
use App\Models\EventFeedback;
use Illuminate\Support\Facades\Auth;

class userDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('regular_user')->user(); // Get the logged-in user
        $latestEvents = Event::latest()->take(4)->get(); // Fetch the 4 latest events
        $latestFeedbacks = EventFeedback::latest()->take(5)->with('regularUser')->get();
        $totalEvents = Event::count();
        $totalRegularUsers = RegularUser::count(); // If user management exists
        $totalFeedbacks = EventFeedback::count();



        $bookedEvents = 0;
        $upcomingEvents = 0;

        if ($user) {
            $bookedEvents = $user->bookedEvents()->count();
        }

        $upcomingEvents = Event::where('start_date', '>=', now())->count();

        return view('home', compact('totalEvents','totalFeedbacks','latestFeedbacks', 'bookedEvents', 'upcomingEvents' ,'totalRegularUsers','latestEvents'));
    }
}
