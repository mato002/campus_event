@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">My Booked Events</h2>

    @if ($bookedEvents->isEmpty())
        <p class="text-gray-600 text-lg text-center">You have not booked any events yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($bookedEvents as $event)
                <div class="bg-white p-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl bg-gray-50">
                    <!-- Flex Container for Image and Details -->
                    <div class="flex flex-col sm:flex-row items-center mb-6">
                        <!-- Event Image -->
                        <div class="event-image-container mb-4 sm:mb-0 sm:w-1/3">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="event-image mb-3 sm:mb-0">
                            @else
                                <img src="{{ asset('images/default-event.jpg') }}" alt="Default Image" class="event-image mb-3 sm:mb-0">
                            @endif
                        </div>

                        <!-- Event Information -->
                        <div class="sm:w-2/3 sm:pl-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">{{ $event->name }}</h3>
                            <p class="text-gray-600 mb-1"><strong>Category:</strong> {{ $event->category->name }}</p>
                            <p class="text-gray-600 mb-1"><strong>Venue:</strong> {{ $event->venue->name }}</p>
                            <p class="text-gray-600 mb-3"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Cancel Booking Button -->
                    <div class="mt-4 flex flex-col sm:flex-row justify-between items-center">
                        <form method="POST" action="{{ route('cancel.booking', $event->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 shadow-md w-full sm:w-auto">
                                Cancel Booking
                            </button>
                        </form>
                    </div>

                    <!-- Feedback Section -->
                    <div class="mt-6 border-t pt-4 border-gray-200">
                        @php
                            $feedback = $event->feedback->firstWhere('regular_user_id', auth()->guard('regular_user')->id());
                        @endphp

                        @if ($feedback)
                            <!-- Display Feedback if Exists -->
                            <div class="mt-4">
                                <p class="text-gray-600 font-semibold">Your Feedback:</p>

                                <!-- Display Rating as Stars -->
                                <div class="text-yellow-500 mb-3">
                                    @for ($i = 0; $i < 5; $i++)
                                        <!-- Check if the current index is less than the rating to display filled stars -->
                                        <i class="fas fa-star {{ $i < $feedback->rating ? '' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>

                                <p class="text-gray-700">Comment: {{ $feedback->comment }}</p>
                            </div>
                        @else
                            <!-- If no feedback, show the form to submit feedback -->
                            <form method="POST" action="{{ route('event.feedback.store', $event->id) }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="rating" class="block text-gray-700">Rating (1-5):</label>
                                    <input type="number" id="rating" name="rating" min="1" max="5" class="border border-gray-300 rounded-lg w-full py-2 px-4 mt-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="comment" class="block text-gray-700">Comment:</label>
                                    <textarea id="comment" name="comment" class="border border-gray-300 rounded-lg w-full py-2 px-4 mt-2" rows="4"></textarea>
                                </div>
                                <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 shadow-md">
                                    Submit Feedback
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Browse More Events Button centered below all events -->
    <div class="mt-8 flex justify-center">
        <a href="{{ route('events.index') }}" class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105">
            Browse More Events
        </a>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Event Image Styling */
    .event-image-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .event-image {
        width: 100%;
        height: auto;
        border-radius: 8px;
        object-fit: contain;  /* Ensure the whole image fits without cropping */
        max-width: 100%;
        max-height: 250px;  /* Set max height, adjust as needed */
    }

    /* Adjust grid layout to ensure events appear in rows */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem; /* Adjust gap between events */
    }

    /* Adjust the flex container for the event image and details */
    .flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Make the image and details sit side by side */
    .sm\:w-1\/3 {
        width: 33.33%;
    }

    .sm\:w-2\/3 {
        width: 66.67%;
    }

    /* Apply background to each event card */
    .bg-gray-50 {
        background-color: #f9fafb;  /* Light gray background for the event cards */
    }

    /* Hover effect to scale and show shadow on each event card */
    .hover\:scale-105:hover {
        transform: scale(1.05);
    }

    .hover\:shadow-2xl:hover {
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    /* Styling for the Browse More Events button */
    .browse-more-btn {
        padding: 12px 24px;
        background-color: #3182ce;
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-size: 18px;
        text-align: center;
        transition: all 0.3s ease-in-out;
    }

    .browse-more-btn:hover {
        background-color: #2b6cb0;
        transform: scale(1.05);
    }
</style>
@endsection
   