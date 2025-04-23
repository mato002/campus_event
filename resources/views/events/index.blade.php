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
                        <div class="event-info">
                            <!-- Event Image as Background -->
                            <div class="event-image-container" style="background-image: url('{{ $event->image ? asset('storage/' . $event->image) : asset('images/default-event.jpg') }}');">
                                <!-- Event Details on Top of the Image -->
                                <div class="event-details">
                                    <h5 class="event-title">{{ $event->name }}</h5>
                                    <p><strong>Category:</strong> {{ $event->category->name}}</p>
                                    <p><strong>Venue:</strong> {{ $event->venue->name }}</p>
                                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <!-- View Details Button -->
                            <a href="{{ route('events.show', $event->id) }}" class="event-btn">View Details</a>
                        </div>
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
                        <div class="event-info">
                            <!-- Event Image as Background -->
                            <div class="event-image-container" style="background-image: url('{{ $event->image ? asset('storage/' . $event->image) : asset('images/default-event.jpg') }}');">
                                <!-- Event Details on Top of the Image -->
                                <div class="event-details">
                                    <h5 class="event-title">{{ $event->name }}</h5>
                                    <p><strong>Category:</strong> {{ $event->category->name }}</p>
                                    <p><strong>Venue:</strong> {{ $event->venue->name }}</p>
                                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <!-- View Details Button -->
                            <a href="{{ route('events.show', $event->id) }}" class="event-btn">View Details</a>
                        </div>
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
        position: relative;
        overflow: hidden;
    }
    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
        animation: fadeInOutColor 5s infinite; /* Add animation */
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
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Three columns layout */
        gap: 30px; /* Add space between the cards */
        margin-top: 20px;
    }

    /* Event Cards */
    .event-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 450px; /* Ensure a consistent height for all cards */
        max-width: 100%;
    }

    .event-card:hover {
        transform: scale(1.05);
    }

    /* Past Event Card Style (Slight Visual Difference) */
    .past-event-card {
        background: #f9f9f9;
        border-left: 5px solid #ff6f61;
    }

    /* Flex layout for image and event details */
    .event-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
        position: relative;
        height: 100%;
        justify-content: space-between; /* Ensure button is at the bottom */
    }

    /* Event Image Container */
    .event-image-container {
        position: relative;
        width: 100%;
        height: 90%; /* Image takes up 60% of the card height */
        background-size: cover;
        background-position: center;
        border-radius: 8px;
    }

    .event-details {
        position: relative;
        z-index: 1;
        color: white;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 10px;
        border-radius: 8px;
        width: calc(100% - 20px);
        box-sizing: border-box;
    }

    .event-title {
        font-size: 1.5rem;
    }

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

    /* No Events */
    .no-events {
        text-align: center;
        font-size: 1.2rem;
        color: #777;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .event-grid {
            grid-template-columns: repeat(2, 1fr); /* Two columns on medium screens */
        }
    }

    @media (max-width: 768px) {
        .event-grid {
            grid-template-columns: 1fr; /* Single column on small screens */
        }

        .event-card {
            min-height: 400px; /* Adjust height for smaller screens */
        }
    }

    /* Animation for fading in and out with color change */
    @keyframes fadeInOutColor {
        0% {
            opacity: 0;
            color: #007bff;
        }
        25% {
            opacity: 1;
            color: #ff6f61;
        }
        50% {
            opacity: 1;
            color: #32cd32; /* Green */
        }
        75% {
            opacity: 1;
            color: #ff4500; /* Orange */
        }
        100% {
            opacity: 0;
            color: #00c6ff; /* Blue */
        }
    }
</style>
@endsection
