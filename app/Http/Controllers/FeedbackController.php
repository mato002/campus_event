<?php

namespace App\Http\Controllers;

use App\Models\EventFeedback;
use App\Models\Event;
use App\Models\RegularUser;  // Import RegularUser model
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, $eventId)
    {
        // Validate the incoming data
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Find the event being reviewed
        $event = Event::findOrFail($eventId);

        // Create the feedback for the event
        EventFeedback::create([
            'event_id' => $event->id,
            'regular_user_id' => auth()->guard('regular_user')->id(),  // Reference regular_user_id
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Feedback submitted successfully.');
    }
}
