@extends('layouts.app')

@section('content')
<div class="page-container">
    <h1 class="page-title">{{ $category->name }} Events</h1>

    <div class="events-container">
        @foreach ($events as $event)
            <div class="event-item">
                <div class="event-title">
                    <h3>{{ $event->name }}</h3>
                </div>
                <div class="event-description">
                    <p>{{ $event->description }}</p>
                </div>

                <div class="event-image">
                    <img src="{{ $event->image ? asset('storage/' . $event->image) : asset('images/default-event.jpg') }}" alt="{{ $event->name }}" class="event-img">
                </div>

                <div class="event-venue">
                    <p><strong>Venue:</strong> {{ $event->venue->name ?? 'N/A' }}</p>
                </div>

                <div class="event-date">
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                </div>

                <!-- View Details Button -->
                <div class="event-btn-container">
                    <a href="{{ route('events.show', $event->id) }}" class="event-btn">View Details</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .events-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .event-item {
        background: #f4f4f4;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .event-item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    }

    .event-title h3 {
        margin-bottom: 10px;
    }

    .event-img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .event-venue,
    .event-date {
        font-size: 1rem;
        color: #555;
    }

    .event-venue p,
    .event-date p {
        margin: 5px 0;
    }

    /* Button Style */
    .event-btn-container {
        margin-top: 15px;
    }

    .event-btn {
        display: inline-block;
        background: #007bff;
        color: white;
        padding: 10px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 1rem;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .event-btn:hover {
        background: #0056b3;
    }
</style>
@endsection
