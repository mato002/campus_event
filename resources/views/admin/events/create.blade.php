@extends('layouts.admin')

@section('content')
    <div class="container p-8">
        <h1 class="text-3xl font-semibold mb-6">Create Event</h1>

        <!-- Error Messages -->
        <div id="error-messages" class="mb-4 hidden">
            <ul class="text-red-500 list-disc pl-6"></ul>
        </div>

        <!-- Event creation form -->
        <form id="event-form" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}"> <!-- Ensure CSRF token is set -->

            <div class="form-group">
                <label for="name" class="text-lg font-medium">Event Name</label>
                <input type="text" name="name" id="name" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-gray-500" placeholder="Enter event name" required>
            </div>

            <div class="form-group">
                <label for="category" class="text-lg font-medium">Category</label>
                <input type="text" name="category" id="category" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-gray-500" placeholder="Enter category" required>
            </div>

            <div class="form-group">
                <label for="start_date" class="text-lg font-medium">Start Date</label>
                <input type="datetime-local" name="start_date" id="start_date" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>

            <div class="form-group">
                <label for="end_date" class="text-lg font-medium">End Date</label>
                <input type="datetime-local" name="end_date" id="end_date" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>

            <div class="form-group">
                <label for="venue_id" class="text-lg font-medium">Select Venue</label>
                <select name="venue_id" id="venue_id" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="" disabled selected>Select a venue</option>
                    @foreach($venues as $venue)
                        <option value="{{ $venue->id }}">{{ $venue->name }} (Capacity: {{ $venue->capacity }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-span-1 md:col-span-2 flex justify-between">
                <button type="submit" class="btn btn-primary mt-3 w-1/3 p-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Create Event
                </button>

                <a href="{{ route('admin.events.index') }}" class="mt-3 w-1/3 p-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 text-center">
                    Back to Events
                </a>
            </div>
        </form>

        <!-- Success Message -->
        <div id="success-message" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-10 p-4 bg-green-500 text-white rounded-md shadow-lg hidden">
            Event created successfully!
        </div>
    </div>

    <script>
        document.getElementById("event-form").addEventListener("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('admin.events.store') }}", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(result => {
                if (result.status === 201) {
                    console.log("Event Created:", result.body.event);
                    document.getElementById("success-message").classList.remove("hidden");
                    document.getElementById("event-form").reset();
                    setTimeout(() => {
                        document.getElementById("success-message").classList.add("hidden");
                    }, 3000);
                } else {
                    console.error("Error:", result.body);
                    alert("Error: " + JSON.stringify(result.body));
                }
            })
            .catch(error => {
                console.error("Network Error:", error);
                alert("Network Error: " + error);
            });
        });
    </script>
@endsection
