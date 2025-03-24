@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-bold mb-6">Create New Event</h2>

    <form id="event-form" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        @csrf

        <!-- Event Name -->
        <div class="form-group">
            <label for="name" class="text-lg font-medium">Event Name</label>
            <input type="text" name="name" id="name" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>

        <!-- Event Category -->
        <div class="form-group">
            <label for="category" class="text-lg font-medium">Event Category</label>
            <input type="text" name="category" id="category" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>

        <!-- Start Date -->
        <div class="form-group">
            <label for="start_date" class="text-lg font-medium">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>

        <!-- End Date -->
        <div class="form-group">
            <label for="end_date" class="text-lg font-medium">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>

        <!-- Venue -->
        <div class="form-group">
            <label for="venue_id" class="text-lg font-medium">Venue</label>
            <select name="venue_id" id="venue_id" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @foreach ($venues as $venue)
                    <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Event Image -->
        <div class="form-group col-span-1 md:col-span-2">
            <label for="image" class="text-lg font-medium">Event Image</label>
            <input type="file" name="image" id="image" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <!-- Submit Button -->
        <div class="form-group col-span-1 md:col-span-2">
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition">Create Event</button>
        </div>
    </form>
</div>

<script>
    document.getElementById("event-form").addEventListener("submit", function(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        fetch("{{ route('admin.events.store') }}", {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                alert("Validation errors occurred.");
            } else {
                alert("Event created successfully!");
                window.location.href = "{{ route('admin.events.index') }}";
            }
        })
        .catch(error => console.error("Error:", error));
    });
</script>
@endsection
