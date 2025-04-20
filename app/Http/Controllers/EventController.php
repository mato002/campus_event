<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegularUser;
use App\Models\Event;
use App\Models\Category;

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
// Book an event (Standard form submission)
public function bookEvent(Request $request, $eventId)
{
    $user = Auth::guard('regular_user')->user();

    if (!$user) {
        return redirect()->back()->with('error', 'Please log in first.');
    }

    $event = Event::findOrFail($eventId);

    if (!$event) {
        return redirect()->back()->with('error', 'Event not found.');
    }

    $now = now();
    $eventStart = \Carbon\Carbon::parse($event->start_date);

    if ($eventStart->lte($now)) {
        return redirect()->back()->with('error', 'You can only book upcoming events.');
    }

    if ($user->bookedEvents()->where('event_id', $eventId)->exists()) {
        return redirect()->back()->with('error', 'You have already booked this event.');
    }

    $user->bookedEvents()->attach($eventId);

    return redirect()->back()->with('status', 'Event booked successfully!');
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

    public function eventsByCategory($categoryId)
    {
        // Fetch the selected category
        $category = Category::findOrFail($categoryId);

        // Fetch events related to the category
        $events = Event::where('category_id', $categoryId)->with(['venue', 'category'])->paginate(5);

        return view('events.category', compact('events', 'category'));
    }
}
