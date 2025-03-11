<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('venue')->orderBy('id', 'asc')->paginate(5); // Paginate results (5 per page)
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $venues = Venue::all();
        return view('admin.events.create', compact('venues'));
    }

    public function show($id)
{
    // Find the event by its ID
    $event = Event::findOrFail($id);

    // Return the view with the event data
    return view('admin.events.show', compact('event'));
}


    public function store(Request $request)
    {
        Log::info('Event Store Method Hit', ['request' => $request->all()]);

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'venue_id' => 'required|exists:venues,id',
            ]);

            $event = Event::create($validated);
            Log::info('Event Created Successfully', ['event' => $event]);

            return response()->json([
                'success' => true,
                'event' => $event
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Failed', ['errors' => $e->validator->errors()->all()]);
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()->toArray()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Event Creation Failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Try again.',
                'error_details' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        // Find the event by its ID
        $event = Event::with('venue')->findOrFail($id);
        $venues = Venue::all();  // Fetch all available venues

        // Return the view with the event data
        return view('admin.events.edit', compact('event', 'venues'));
    }

    public function update(Request $request, $id)
    {
        // Find the event by its ID
        $event = Event::findOrFail($id);

        // Validate and update event data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'venue_id' => 'required|exists:venues,id',
        ]);

        // Update the event
        $event->update($validated);

        // Redirect with success message
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        try {
            // Find and delete the event
            $event = Event::findOrFail($id);
            $event->delete();

            // Log deletion success
            Log::info('Event Deleted Successfully', ['event_id' =>$id]);

            // Return success message as JSON
            return response()->json(['success' => true, 'message' => 'Event deleted successfully!']);
        } catch (\Exception $e) {
            // Log error if something goes wrong
            Log::error('Event Deletion Failed', ['error' => $e->getMessage()]);

            // Return error message as JSON
            return response()->json(['success' => false, 'message' => 'Error deleting event.'], 500);



{
    $event = Event::find($id);

    if (!$event) {
        return response()->json(['success' => false, 'message' => 'Event not found.'], 404);
    }

    $event->delete();

    return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
}

        }
    }
    
}
