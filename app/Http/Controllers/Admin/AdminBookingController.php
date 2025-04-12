<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\RegularUser;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bookings = Event::with(['regularUsers' => function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            }
        }])
        ->whereHas('regularUsers', function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            }
        })
        ->orWhere('name' ,'like', "%{$search}%")
        ->paginate(5); // Pagination remains at 5 bookings per page

        return view('admin.bookings', compact('bookings'));
    }

    public function cancelBooking($eventId, $userId)
    {
        $event = Event::findOrFail($eventId);
        $user = RegularUser::findOrFail($userId);

        // Ensure the user is actually booked for the event
        if ($user->bookedEvents()->where('event_id', $eventId)->exists()) {
            $user->bookedEvents()->detach($eventId);
            return back()->with('success', 'Booking removed successfully.');
        }

        return back()->with('error', 'This booking does not exist.');
    }
}
