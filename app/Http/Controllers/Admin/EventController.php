<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        // Paginate events with 5 events per page
        $events = Event::with('venue')->orderBy('id', 'asc')->paginate(5);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        // Get all available venues for event creation
        $venues = Venue::all();
        return view('admin.events.create', compact('venues'));
    }

    public function show($id)
    {
        // Find the event by its ID
        $event = Event::findOrFail($id);
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for image
            ]);

            // Handle image upload if it exists
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('events', 'public');
            }

            // Create event with the validated data and image path
            $event = Event::create([
                'name' => $validated['name'],
                'category' => $validated['category'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'venue_id' => $validated['venue_id'],
                'image' => $imagePath, // Store the image path
            ]);

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
        // Find the event by its ID and get all available venues for the edit form
        $event = Event::with('venue')->findOrFail($id);
        $venues = Venue::all();
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        // Handle image upload if it exists
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($event->image) {
                Storage::delete('public/' . $event->image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        // Update the event
        $event->update($validated);

        // Redirect with success message
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        try {
            // Find the event by its ID
            $event = Event::findOrFail($id);

            // Delete the associated image if it exists
            if ($event->image) {
                Storage::delete('public/' . $event->image);
            }

            // Delete the event
            $event->delete();

            // Log deletion success
            Log::info('Event Deleted Successfully', ['event_id' => $id]);

            // Return success message as JSON
            return response()->json(['success' => true, 'message' => 'Event deleted successfully!']);
        } catch (\Exception $e) {
            // Log error if something goes wrong
            Log::error('Event Deletion Failed', ['error' => $e->getMessage()]);

            // Return error message as JSON
            return response()->json(['success' => false, 'message' => 'Error deleting event.'], 500);
        }
    }
}
