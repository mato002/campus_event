@extends('layouts.app')

@section('content')
<div class="events-container">
    <!-- Hero Section (Optional, for consistency) -->
    <div class="hero-section">
        <h1>Event Details</h1>
        <p>Here are the details of the event you selected.</p>
    </div>

    <div class="container mt-5">
        <!-- Event Details Section -->
        <div class="event-detail-card">
            <div class="row">
                <div class="col-md-5">
                    <!-- Event Image -->
                    <div class="event-image-container">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="event-image">
                        @else
                            <img src="{{ asset('images/default-event.jpg') }}" alt="Default Image" class="event-image">
                        @endif
                    </div>
                </div>

                <div class="col-md-7">
                    <!-- Event Info -->
                    <h2 class="event-title">{{ $event->name }}</h2>
                    <p class="event-category"><strong>Category:</strong> {{ $event->category }}</p>
                    <p class="event-venue"><strong>Venue:</strong> {{ $event->venue->name }}</p>
                    <p class="event-date"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                    <p class="event-description"><strong>Description:</strong> {{ $event->description ?? 'No description available.' }}</p>
                </div>
            </div>

            <div class="mt-6 d-flex justify-content-between">
                <!-- Buttons in One Row -->
                <a href="{{ route('events.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    Back to Events
                </a>

                <!-- Booking Form -->
                <form id="bookEventForm" method="POST" action="{{ route('book.event', $event->id) }}">
                    @csrf
                    <button type="submit" id="bookEventButton" class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200" onclick="showBookingPopup(event)">
                        Book Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Booking Popup -->
<div id="bookingPopup" class="booking-popup" style="display: none;">
    <div class="popup-content">
        @if(session('status') === 'success')
            <p>Your event has been successfully booked!</p>
        @else
            <p>This event has already passed, and you cannot book it.</p>
        @endif
        <button onclick="closeBookingPopup()">OK</button>
    </div>
</div>

<script>
    // Function to display the booking popup
    function showBookingPopup(e) {
        e.preventDefault(); // Prevent the form submission (page reload)

        // Show the popup
        document.getElementById('bookingPopup').style.display = 'block';

        // Simulate form submission after 1 second (for the demo)
        setTimeout(function() {
            document.getElementById('bookEventForm').submit(); // Submit the form to actually book the event
        }, 1000);
    }

    // Function to close the popup
    function closeBookingPopup() {
        document.getElementById('bookingPopup').style.display = 'none';
    }
</script>

@endsection

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        text-align: center;
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        padding: 40px 20px;
        border-radius: 8px;
    }

    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .hero-section p {
        font-size: 1.2rem;
    }

    /* Event Details Card */
    .event-detail-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Event Image */
    .event-image-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .event-image {
        width: 600px;
        height: auto;
        border-radius: 8px;
        object-fit: contain;  /* Changed from cover to contain */
        max-width: 100%;  /* Ensures image size is consistent */
        max-height: 300px;  /* Keeps image size proportional */
    }

    /* Event Title */
    .event-title {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 15px;
    }

    /* Event Info */
    .event-category,
    .event-venue,
    .event-date,
    .event-description {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #555;
    }

    .event-category strong,
    .event-venue strong,
    .event-date strong,
    .event-description strong {
        color: #333;
    }

    /* Button Styles */
    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .bg-gray-500 {
        background-color: #6b7280;
    }

    .text-white {
        color: white;
    }

    .hover\:bg-gray-600:hover {
        background-color: #4b5563;
    }

    .transition {
        transition: all 0.3s ease;
    }

    .bg-blue-500 {
        background-color: #007bff;
    }

    .hover\:bg-blue-600:hover {
        background-color: #0056b3;
    }

    /* Booking Popup */
    .booking-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .popup-content p {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .popup-content button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .popup-content button:hover {
        background-color: #0056b3;
    }
</style>
@endsection
