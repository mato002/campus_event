<!-- resources/views/events/my_events.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Registered Events</h1>
        <div class="my-events-list">
            @foreach ($userEvents as $event)
                <div class="event-item">
                    <h3>{{ $event->title }}</h3>
                    <p>{{ $event->description }}</p>
                    <p><strong>Date:</strong> {{ $event->date }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
