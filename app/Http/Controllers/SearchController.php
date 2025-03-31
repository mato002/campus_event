<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Venue;
use App\Models\RegularUser;
use App\Models\Category;
use App\Models\Booking;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search in Events
        $events = Event::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('category_id', 'LIKE', "%{$query}%")
            ->orWhere('venue_id', 'LIKE', "%{$query}%")
            ->get();

        // Search in Venues
        $venues = Venue::where('name', 'LIKE', "%{$query}%")
            ->orWhere('capacity', 'LIKE', "%{$query}%")
            ->get();

        // Search in Users
        $users = RegularUser::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        // Search in Categories
        $categories = Category::where('name', 'LIKE', "%{$query}%")->get();

        // Search in Bookings
        $bookings = Booking::where('user_id', 'LIKE', "%{$query}%")
        ->orWhere('event_id', 'LIKE', "%{$query}%")
        ->orWhere('booking_date', 'LIKE', "%{$query}%")
        ->get();
    
        return view('search.results', compact('events', 'venues', 'users', 'categories', 'bookings', 'query'));
    }
}
