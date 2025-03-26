@extends('layouts.app')

@section('content')
<div class="events-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Explore Amazing Events</h1>
        <p>Discover upcoming events, book your spot, and make unforgettable memories.</p>
    </div>

    <div class="container mt-5">
        <!-- Upcoming Events Section -->
        <h2 class="section-title">Upcoming Events</h2>

        @if($upcomingEvents->count() > 0)
            <div class="event-grid">
                @foreach($upcomingEvents as $event)
                    <div class="event-card">
                        <div class="event-info d-flex">
                            <!-- Display Event Image -->
                            <div class="event-image-container">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="event-image mb-3">
                                @else
                                    <img src="{{ asset('images/default-event.jpg') }}" alt="Default Image" class="event-image mb-3">
                                @endif
                            </div>

                            <!-- Event Details -->
                            <div class="event-details ml-4">
                                <h5 class="event-title">{{ $event->name }}</h5>
                                <p><strong>Category:</strong> {{ $event->category }}</p>
                                <p><strong>Venue:</strong> {{ $event->venue->name }}</p>
                                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('events.show', $event->id) }}" class="event-btn">View Details</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="no-events">No upcoming events available at the moment.</p>
        @endif
    </div>

    <div class="container mt-5">
        <!-- Past Events Section -->
        <h2 class="section-title">Past Events</h2>

        @if($pastEvents->count() > 0)
            <div class="event-grid">
                @foreach($pastEvents as $event)
                    <div class="event-card past-event-card">
                        <div class="event-info d-flex">
                            <!-- Display Event Image -->
                            <div class="event-image-container">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="event-image mb-3">
                                @else
                                    <img src="{{ asset('images/default-event.jpg') }}" alt="Default Image" class="event-image mb-3">
                                @endif
                            </div>

                            <!-- Event Details -->
                            <div class="event-details ml-4">
                                <h5 class="event-title">{{ $event->name }}</h5>
                                <p><strong>Category:</strong> {{ $event->category }}</p>
                                <p><strong>Venue:</strong> {{ $event->venue->name }}</p>
                                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('events.show', $event->id) }}" class="event-btn">View Details</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="no-events">No past events available.</p>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        text-align: center;
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        padding: 60px 20px;
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

    /* Section Title */
    .section-title {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 30px;
        font-weight: bold;
        color: #333;
    }

    /* Event Grid Layout */
    .event-grid {
        display: flex;
        flex-wrap: wrap; /* Allow items to wrap onto the next line */
        justify-content: space-between; /* Distribute events evenly */
        gap: 30px; /* Add space between the cards */
    }

    /* Event Cards */
    .event-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 350px; /* Set max width for each card */
        transition: transform 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .event-card:hover {
        transform: scale(1.05);
    }

    /* Past Event Card Style (Slight Visual Difference) */
    .past-event-card {
        background: #f9f9f9; /* Lighter background for past events */
        border-left: 5px solid #ff6f61; /* Distinct border color */
    }

    /* Flex layout for image and event details */
    .event-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .event-image-container {
        flex-shrink: 0;
        width: 120px;
        height: 100px;
    }

    .event-image {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        object-fit: cover;
    }

    /* Event Details */
    .event-details {
        flex-grow: 1;
        margin-left: 20px;
    }

    .event-title {
        color: #007bff;
        font-size: 1.4rem;
        margin-bottom: 10px;
    }

    .event-info p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 5px;
    }

    /* View Details Button */
    .event-btn {
        display: block;
        text-align: center;
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        padding: 10px 15px;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: bold;
        text-decoration: none;
        transition: background 0.3s ease-in-out;
        margin-top: 15px;
    }

    .event-btn:hover {
        background: linear-gradient(to right, #0056b3, #008cff);
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        gap: 5px;
    }

    .pagination li {
        display: inline-block;
    }

    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 6px;
        text-decoration: none;
        background: #f8f9fa;
        color: #007bff;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .pagination li a:hover {
        background: #007bff;
        color: white;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .pagination .active span {
        background: #007bff;
        color: white;
        font-weight: bold;
        border-color: #007bff;
    }

    .pagination .disabled span {
        background: #e9ecef;
        color: #adb5bd;
        border-color: #ddd;
    }

    /* No Events */
    .no-events {
        text-align: center;
        font-size: 1.2rem;
        color: #777;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .event-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .event-image-container {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .event-details {
            margin-left: 0;
        }

        .event-grid {
            justify-content: center;
        }

        .event-card {
            max-width: 100%; /* Allow the card to take full width on small screens */
        }
    }
</style>
@endsection
