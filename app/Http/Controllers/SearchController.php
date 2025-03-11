<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\RegularUser;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search in Events
        $events = Event::where('name', 'LIKE', "%{$query}%")
            ->get();

        // Search in Users
        $users = RegularUser::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        return view('search.results', compact('events', 'users', 'query'));
    }
}
