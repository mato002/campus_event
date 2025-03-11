<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegularUser;

use App\Models\Event;

class EventController extends Controller
{
    // Display all available events
    public function index()
    {
        $events = Event::with('venue')->orderBy('start_date', 'asc')->paginate(6);
        return view('events.index', compact('events'));
    }

    // Show event details
    public function show($id)
    {
        $event = Event::with('venue')->findOrFail($id);
        return view('events.show', compact('event'));
    }





    public function bookEvent($eventId)
    {
        $user = Auth::guard('regular_user')->user(); // Ensure it fetches RegularUser
        
        if(!$user) {
            return redirect()->route('user/login')->with('error', 'Please log in first.');
        }

        $event = Event::findOrFail($eventId);

        if (!$event) {
            return back()->with('error', 'Event not found.');
        }

        // Check if user already booked the event
        if (!$user->bookedEvents()->where('event_id', $eventId)->exists()) {
            $user->bookedEvents()->attach($eventId);
            return back()->with('success', 'Event booked successfully!');
        }

        return back()->with('error', 'You have already booked this event.');
    }




    public function myBookings()
{
    $user = Auth::guard('regular_user')->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }


    $bookedEvents = $user->bookedEvents;

    return view('mybookings', compact('bookedEvents'));
}

public function cancelBooking($eventId)
{
    $user = Auth::guard('regular_user')->user();

    if (!$user) {
        return redirect()->route('user/login')->with('error', 'Please log in first.');
    }

    if (!$user->bookedEvents()->where('event_id', $eventId)->exists()) {
        return back()->with('error', 'You have not booked this event.');
    }

    $user->bookedEvents()->detach($eventId);

    return back()->with('success', 'Booking canceled successfully.');
}



}
