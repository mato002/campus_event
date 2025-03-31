<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['venue', 'category'])->orderBy('id', 'asc')->paginate(5);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $venues = Venue::all();
        $categories = Category::all();
        return view('admin.events.create', compact('categories', 'venues'));
    }

    public function show($id)
    {
        $event = Event::with(['venue', 'category'])->findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    public function store(Request $request)
    {
        Log::info('Event Store Method Hit', ['request' => $request->all()]);

        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'start_date' => 'required|date|date_format:Y-m-d\TH:i',
                'end_date' => 'required|date|date_format:Y-m-d\TH:i|after:start_date',
                'venue_id' => 'required|exists:venues,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'description' => 'nullable|string|max:2000',
            ]);

            Log::info('Validation Successful', ['validated_data' => $validated]);

            $imagePath = $request->hasFile('image') 
                ? $request->file('image')->store('events', 'public') 
                : null;

            $event = Event::create([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'venue_id' => $validated['venue_id'],
                'image' => $imagePath,
                'description' => $request->input('description') ?? null,
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
        $event = Event::with(['venue', 'category'])->findOrFail($id);
        $venues = Venue::all();
        $categories = Category::all();

        return view('admin.events.edit', compact('categories', 'event', 'venues'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date|date_format:Y-m-d\TH:i',
            'end_date' => 'required|date|date_format:Y-m-d\TH:i|after:start_date',
            'venue_id' => 'required|exists:venues,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'description' => 'nullable|string|max:2000',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::delete('public/' . $event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update(array_merge($validated, [
            'description' => $request->input('description') ?? $event->description,
        ]));

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);

            if ($event->image) {
                Storage::delete('public/' . $event->image);
            }

            $event->delete();

            Log::info('Event Deleted Successfully', ['event_id' => $id]);

            return response()->json(['success' => true, 'message' => 'Event deleted successfully!']);
        } catch (\Exception $e) {
            Log::error('Event Deletion Failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error deleting event.'], 500);
        }
    }
}
