@extends('layouts.app')

@section('content')

<!-- Home Section -->
<div class="home-section">
    <h1 class="home-title">Welcome to Campus Event Management</h1>
    <p class="home-description">Browse upcoming events, register for them, and stay updated on the latest happenings at your campus.</p>
    
    <!-- Browse Events Button -->
    <div class="browse-button-container">
<a href="{{ route('events.index') }}" class="browse-button">Browse Events</a>
    </div>
</div>

<!-- Statistics Section -->
<div class="statistics-section">
    <h2 class="section-title">Statistics</h2>
    <div class="statistics-container">
        <div class="statistics-item">
        <h3 class="text-lg font-semibold mb-2"> Members </h3>
        <p class="text-3xl text-blue-600 font-bold">{{ $totalRegularUsers }}</p>
            </div>
        <div class="statistics-item">
        <h3 class="text-lg font-semibold mb-2">Total Events</h3>
        <p class="text-3xl text-blue-600 font-bold">{{ $totalEvents }}</p>
        </div>
        <div class="statistics-item">
            <h3>Upcoming Events</h3>
            <p class="text-3xl text-purple-600 font-bold">{{ $upcomingEvents }}</p>
        </div>
    <!-- Total Feedbacks -->
        <div class="statistics-item">
            <h3 class="text-lg font-semibold mb-2">Total Feedbacks</h3>
            <p class="text-3xl text-purple-600 font-bold">{{ $totalFeedbacks }}</p>
        </div>
        </div>
        <div class="statistics-item">
            <h3 class="text-lg font-semibold mb-2">My Booked Events</h3>
            <p class="text-3xl text-green-600 font-bold">{{ $bookedEvents }}</p>
        </div>

    </div>
</div>

<!-- Feedback Section -->
<!-- Feedback Section -->
<div class="feedback-section">
    <h2 class="section-title">Latest Feedback</h2>
    <div class="feedback-container">
        @foreach($latestFeedbacks as $feedback)
            <div class="feedback-item">
                <p>"{{ $feedback->comment }}"</p>
                <span>- {{ $feedback->regularUser->name ?? 'Anonymous User' }}</span> <!-- Displaying the feedback giver's name -->
            </div>
        @endforeach
    </div>
</div>

<!-- Latest Events Section -->
<!-- Latest Events Section -->
<div class="latest-events-section">
    <h2 class="section-title">Latest Events</h2>
    <div class="latest-events-container">
        @foreach($latestEvents as $event)
            <div class="latest-event-item">
                <h3>{{ $event->name }}</h3>
                <p>{{ Str::limit($event->description, 100) }}</p>
                <a href="{{ route('events.show', $event->id) }}" class="event-link">View Event</a>
            </div>
        @endforeach
    </div>
</div>

@endsection

@section('styles')
<style>
    /* General Styling */
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    /* Home Section */
    .home-section {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(to right, #0056b3, #003d80);
        color: white;
        border-radius: 10px;
        margin: 20px;
    }

    .home-title {
        font-size: 36px;
        margin-bottom: 15px;
    }

    .home-description {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .browse-button {
        background-color: #ffc107;
        color: #333;
        padding: 12px 30px;
        font-size: 18px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease-in-out;
    }

    .browse-button:hover {
        background-color: #e0a800;
        transform: scale(1.1);
    }

    /* Statistics Section */
    .statistics-section {
        padding: 50px 20px;
        background: white;
        margin: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .statistics-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .statistics-item {
        background: #007bff;
        color: white;
        padding: 20px;
        border-radius: 10px;
        width: 200px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
        margin-bottom: 40px;
    }

    .statistics-item:hover {
        transform: translateY(-5px);
    }

    /* Feedback Section */
    .feedback-section {
        padding: 50px 20px;
        background: #fff;
        margin: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .feedback-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .feedback-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        width: 40%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Latest Events Section */
    .latest-events-section {
        padding: 50px 20px;
        background: white;
        margin: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .latest-events-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .latest-event-item {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 40%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .event-link {
        display: inline-block;
        margin-top: 15px;
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .event-link:hover {
        background-color: #218838;
    }
</style>
@endsection
