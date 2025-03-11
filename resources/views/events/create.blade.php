@extends('layouts.app')

@section('content')
    <h1>Create Event</h1>

    <!-- Display any validation errors -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Event creation form -->
    <form action="{{ route('admin.events.store') }}" method="POST">
        @csrf

        <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Event Name</th>
                    <th class="border px-4 py-2">Category</th>
                    <th class="border px-4 py-2">Start Date</th>
                    <th class="border px-4 py-2">End Date</th>
                    <th class="border px-4 py-2">Venue</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">
                        <input type="text" name="name" class="form-control w-full" value="{{ old('name') }}" required>
                    </td>
                    <td class="border px-4 py-2">
                        <input type="text" name="category" class="form-control w-full" value="{{ old('category') }}" required>
                    </td>
                    <td class="border px-4 py-2">
                        <input type="datetime-local" name="start_date" class="form-control w-full" value="{{ old('start_date') }}" required>
                    </td>
                    <td class="border px-4 py-2">
                        <input type="datetime-local" name="end_date" class="form-control w-full" value="{{ old('end_date') }}" required>
                    </td>
                    <td class="border px-4 py-2">
                        <select name="venue_id" class="form-control w-full" required>
                            <option value="" disabled selected>Select a venue</option>
                            @foreach($venue as $venue)
                                <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->name }} (Capacity: {{ $venue->capacity }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Submit Button at the Bottom -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Create Event</button>
        </div>
    </form>

    <!-- Display Existing Events in Rows -->
    <h2 class="mt-6">Existing Events</h2>
    <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Event Name</th>
                <th class="border px-4 py-2">Category</th>
                <th class="border px-4 py-2">Start Date</th>
                <th class="border px-4 py-2">End Date</th>
                <th class="border px-4 py-2">Venue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td class="border px-4 py-2">{{ $event->name }}</td>
                    <td class="border px-4 py-2">{{ $event->category }}</td>
                    <td class="border px-4 py-2">{{ $event->start_date }}</td>
                    <td class="border px-4 py-2">{{ $event->end_date }}</td>
                    <td class="border px-4 py-2">{{ $event->venue->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
