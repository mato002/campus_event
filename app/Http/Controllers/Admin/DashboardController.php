<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Venue;
use App\Models\User;
use App\Models\RegularUser;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch statistics for the dashboard
        $totalEvents = Event::count();
        $totalVenues = Venue::count();
        $totalUsers = User::count(); // If user management exists
        $totalRegularUser = RegularUser::count(); // If user management exists

        $eventCountByMonth = Event::selectRaw('MONTH(start_date) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $upcomingEvents = Event::where('start_date', '>=', now())
                                ->orderBy('start_date')
                                ->take(5)
                                ->get();
                                $eventCountByMonth = Event::selectRaw('MONTH(start_date) as month, COUNT(*) as count')
                                ->groupBy('month')
                                ->orderBy('month')
                                ->get();
  
      // Pass the data to the view
      return view('admin.dashboard', compact('totalEvents', 'totalVenues', 'totalUsers','totalRegularUser', 'upcomingEvents', 'eventCountByMonth'));
  } 


}
