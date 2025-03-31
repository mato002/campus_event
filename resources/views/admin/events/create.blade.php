@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-bold mb-6">Create New Event</h2>

    <form id="event-form" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        @csrf

        <div class="form-group">
            <label for="name" class="text-lg font-medium">Event Name</label>
            <input type="text" name="name" id="name" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>

        <div class="form-group">
            <label for="category_id" class="text-lg font-medium">Event Category</label>
            <select name="category_id" id="category_id" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date" class="text-lg font-medium">Start Date and Time</label>
            <input type="datetime-local" name="start_date" id="start_date" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>

        <div class="form-group">
            <label for="end_date" class="text-lg font-medium">End Date and Time</label>
            <input type="datetime-local" name="end_date" id="end_date" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>

        <div class="form-group">
            <label for="venue_id" class="text-lg font-medium">Venue</label>
            <select name="venue_id" id="venue_id" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @foreach ($venues as $venue)
                    <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-span-1 md:col-span-2">
            <label for="description" class="text-lg font-medium">Event Description</label>
            <textarea name="description" id="description" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="5"></textarea>
        </div>

        <div class="form-group col-span-1 md:col-span-2">
            <label for="image" class="text-lg font-medium">Event Image</label>
            <input type="file" name="image" id="image" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

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

        // Get CSRF token dynamically from the meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        fetch("{{ route('admin.events.store') }}", {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"  // Ensure JSON response
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Event created successfully!");
                window.location.href = "{{ route('admin.events.index') }}";
            } else if (data.errors) {
                let errors = Object.values(data.errors).flat().join("\n");
                alert("Validation errors occurred:\n" + errors);
            }
        })
        .catch(error => console.error("Error:", error));
    });
</script>
@endsection
