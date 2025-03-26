<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegularUser;
use App\Models\Event;

class EventController extends Controller
{
    // Display all available events (separating upcoming and past events)
    public function index()
    {
        $today = now(); // Get the current date and time

        // Fetch upcoming events (start_date is today or in the future)
        $upcomingEvents = Event::with('venue')
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->paginate(50);

        // Fetch past events (start_date is before today)
        $pastEvents = Event::with('venue')
            ->whereDate('start_date', '<', $today)
            ->orderBy('start_date', 'desc')
            ->paginate(50);

        return view('events.index', compact('upcomingEvents', 'pastEvents'));
    }

    // Show event details
    public function show($id)
    {
        $event = Event::with('venue')->findOrFail($id);

        // Check if the event is past or upcoming
        $eventStart = \Carbon\Carbon::parse($event->start_date);
        $isPastEvent = $eventStart->lt(now()); // If the event date is less than the current time, it's a past event

        return view('events.show', compact('event', 'isPastEvent'));
    }

    // Book an event (AJAX version)
    public function bookEvent(Request $request, $eventId)
    {
        $user = Auth::guard('regular_user')->user(); // Ensure it fetches RegularUser
        
        // Check if the user is logged in
        if (!$user) {
            return response()->json(['message' => 'Please log in first.'], 400);
        }

        // Find the event or return error if not found
        $event = Event::findOrFail($eventId);

        // Check if the event exists
        if (!$event) {
            return response()->json(['message' => 'Event not found.'], 400);
        }

        $now = now(); // Get the current timestamp
        $eventStart = \Carbon\Carbon::parse($event->start_date);

        // Ensure the event is upcoming (future date and time)
        if ($eventStart->lte($now)) {
            return response()->json(['message' => 'You can only book upcoming events.'], 400);
        }

        // Check if user already booked the event
        if ($user->bookedEvents()->where('event_id', $eventId)->exists()) {
            return response()->json(['message' => 'You have already booked this event.'], 400);
        }

        // Book the event for the user
        $user->bookedEvents()->attach($eventId);

        // Return success message for AJAX
        return response()->json(['message' => 'Event booked successfully!'], 200);
    }

    // View user's booked events
    public function myBookings()
    {
        $user = Auth::guard('regular_user')->user();

        if (!$user) {
            return redirect()->route('user.login')->with('error', 'Please log in first.');
        }

        // Eager load the feedback relationship
        $bookedEvents = $user->bookedEvents()->with('feedback')->get();

        return view('mybookings', compact('bookedEvents'));
    }

    // Cancel a booking
    public function cancelBooking($eventId)
    {
        $user = Auth::guard('regular_user')->user();

        if (!$user) {
            return redirect()->route('user.login')->with('error', 'Please log in first.');
        }

        if (!$user->bookedEvents()->where('event_id', $eventId)->exists()) {
            return back()->with('error', 'You have not booked this event.');
        }

        $user->bookedEvents()->detach($eventId);

        return back()->with('success', 'Booking canceled successfully.');
    }
}
