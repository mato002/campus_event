@extends('layouts.admin')

@section('content')
    <div class="container p-8">
        <h1 class="text-3xl font-semibold mb-6">Create Venue</h1>

        <!-- Error Messages -->
        <div id="error-messages" class="mb-4 hidden">
            <ul class="text-red-500 list-disc pl-6"></ul>
        </div>

        <!-- Venue Creation Form -->
        <form id="venue-form" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6" method="POST" action="{{ route('admin.venues.store') }}">
            @csrf

            <!-- Venue Name -->
            <div class="form-group">
                <label for="name" class="text-lg font-medium">Venue Name</label>
                <input type="text" name="name" id="name" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-gray-500" placeholder="Enter venue name" value="{{ old('name') }}" required>
            </div>

            <!-- Venue Capacity -->
            <div class="form-group">
                <label for="capacity" class="text-lg font-medium">Capacity</label>
                <input type="number" name="capacity" id="capacity" class="form-control w-full p-3 rounded-md border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-gray-500" placeholder="Enter capacity" value="{{ old('capacity') }}" required>
            </div>

            <!-- Submit and Back Button -->
            <div class="form-group col-span-1 md:col-span-2 flex justify-between">
                <button type="submit" class="btn btn-primary mt-3 w-1/3 p-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Create Venue
                </button>

                <a href="{{ route('admin.venues.index') }}" class="mt-3 w-1/3 p-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 text-center">
                    Back to Venues
                </a>
            </div>
        </form>

        <!-- Success Message (Popup) -->
        <div id="success-message" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-10 p-4 bg-green-500 text-white rounded-md shadow-lg hidden">
            Venue created successfully!
        </div>
    </div>

    <script>
        document.getElementById("venue-form").addEventListener("submit", function (e) {
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);

            fetch("{{ route('admin.venues.store') }}", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest", // Ensure Laravel treats it as AJAX
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Display success popup message
                    document.getElementById("success-message").classList.remove("hidden");

                    // Hide any previous error messages
                    const errorMessages = document.getElementById("error-messages");
                    errorMessages.classList.add("hidden");
                    errorMessages.querySelector("ul").innerHTML = "";

                    // Reset form after successful creation
                    document.getElementById("venue-form").reset();

                    // Hide success popup after 3 seconds
                    setTimeout(() => {
                        document.getElementById("success-message").classList.add("hidden");
                    }, 3000);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                let errorDiv = document.getElementById("error-messages");
                errorDiv.classList.remove("hidden");
                errorDiv.querySelector("ul").innerHTML = error.errors 
                    ? Object.values(error.errors).map(err => `<li>${err}</li>`).join("")
                    : "<li>Something went wrong. Please try again.</li>";
            });
        });
    </script>
@endsection
