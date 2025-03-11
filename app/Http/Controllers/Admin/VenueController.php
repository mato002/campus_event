<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class VenueController extends Controller
{
    /**
     * Display a paginated listing of venues.
     */
    public function index()
    {
        $venues = Venue::orderBy('id', 'asc')->paginate(5);
        return view('admin.venues.index', compact('venues'));
    }

    /**
     * Show the form for creating a new venue.
     */
    public function create()
    {
        return view('admin.venues.create');
    }

    /**
     * Store a newly created venue in the database.
     */
    public function store(Request $request)
    {
        Log::info('Venue Store Method Called', ['request_data' => $request->all()]);

        $validated = $request->validate([
            'name' => 'required|string|unique:venues|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        try {
            $venue = Venue::create($validated);
            Log::info('Venue Created Successfully', ['venue' => $venue]);

            // If the request is an AJAX request, return a JSON response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Venue created successfully!'
                ]);
            }

            // For non-AJAX requests, redirect to venue index with success message
            return redirect()->route('admin.venues.index')->with('success', 'Venue created successfully!');
        } catch (\Exception $e) {
            Log::error('Venue Creation Failed', ['error' => $e->getMessage()]);

            // Handle AJAX request error
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while creating the venue.'
                ], 500);
            }

            // For non-AJAX requests, redirect back with error message
            return redirect()->back()->with('error', 'Something went wrong while creating the venue.');
        }
    }

    /**
     * Display the specified venue.
     */
    public function show($id)
    {
        $venue = Venue::find($id);
        if (!$venue) abort(404);

        return view('admin.venues.show', compact('venue'));
    }

    /**
     * Show the form for editing the specified venue.
     */
    public function edit($id)
    {
        $venue = Venue::find($id);
        if (!$venue) abort(404);

        return view('admin.venues.edit', compact('venue'));
    }

    /**
     * Update the specified venue in storage.
     */
    public function update(Request $request, $id)
    {
        $venue = Venue::find($id);
        if (!$venue) abort(404);

        $validated = $request->validate([
            'name' => 'required|string|unique:venues,name,' . $id . '|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $venue->update($validated);
        Log::info('Venue Updated Successfully', ['venue' => $venue]);

        return redirect()->route('admin.venues.index')->with('success', 'Venue updated successfully!');
    }

    /**
     * Remove the specified venue from storage.
     */
    public function destroy(Request $request, $id)
    {
        Log::info('Venue Deletion Attempt', ['venue_id' => $id]);

        $venue = Venue::find($id);
        if (!$venue) {
            return response()->json([
                'success' => false,
                'message' => 'Venue not found.'
            ], 404);
        }

        if (Event::where('venue_id', $id)->exists()) {
            Log::warning('Venue Deletion Blocked - Linked to Events', ['venue_id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete venue. It is linked to existing events.'
            ], 400);
        }

        $venue->delete();
        Log::info('Venue Deleted Successfully', ['venue_id' => $id]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Venue deleted successfully!']);
        }

        return redirect()->route('admin.venues.index')->with('success', 'Venue deleted successfully!');
    }
}
