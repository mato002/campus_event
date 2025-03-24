@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800">Edit Event</h2>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger mb-4 p-4 bg-red-100 text-red-800 border-l-4 border-red-500 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success mb-4 p-4 bg-green-100 text-green-800 border-l-4 border-green-500 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form to update event -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Event Name -->
            <div class="mb-4">
                <label for="name" class="form-label text-lg font-medium text-gray-700">Event Name</label>
                <input type="text" name="name" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name', $event->name) }}" required>
            </div>

            <!-- Event Category -->
            <div class="mb-4">
                <label for="category" class="form-label text-lg font-medium text-gray-700">Category</label>
                <input type="text" name="category" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('category', $event->category) }}" required>
            </div>

            <!-- Start Date -->
            <div class="mb-4">
                <label for="start_date" class="form-label text-lg font-medium text-gray-700">Start Date</label>
                <input type="datetime-local" name="start_date" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i')) }}" required>
            </div>

            <!-- End Date -->
            <div class="mb-4">
                <label for="end_date" class="form-label text-lg font-medium text-gray-700">End Date</label>
                <input type="datetime-local" name="end_date" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('end_date', \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i')) }}" required>
            </div>

            <!-- Venue Selection -->
            <div class="mb-4">
                <label for="venue_id" class="form-label text-lg font-medium text-gray-700">Venue</label>
                <select name="venue_id" id="venue_id" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled>Select a venue</option>
                    @foreach($venues as $venue)
                        <option value="{{ $venue->id }}" {{ $event->venue_id == $venue->id ? 'selected' : '' }}>
                            {{ $venue->name }} (Capacity: {{ $venue->capacity }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Event Image Upload -->
            <div class="mb-4">
                <label for="image" class="form-label text-lg font-medium text-gray-700">Event Image</label>
                <input type="file" name="image" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                @if ($event->image)
                    <div class="mt-2 text-sm text-gray-600">
                        <span class="font-medium">Uploaded File:</span> {{ basename($event->image) }}
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="mt-6 text-center">
                <button type="submit" class="btn bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out">
                    Update Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
