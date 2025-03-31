@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Search Results for "{{ $query }}"</h1>

    @if($events->isEmpty() && $venues->isEmpty() && $users->isEmpty() && $categories->isEmpty() && $bookings->isEmpty())
        <p>No results found.</p>
    @else
        @if(!$events->isEmpty())
            <h2>Events</h2>
            @foreach($events as $event)
                <p>{{ $event->title }} - {{ $event->description }}</p>
            @endforeach
        @endif

        @if(!$venues->isEmpty())
            <h2>Venues</h2>
            @foreach($venues as $venue)
                <p>{{ $venue->name }} - {{ $venue->location }}</p>
            @endforeach
        @endif

        @if(!$users->isEmpty())
            <h2>Users</h2>
            @foreach($users as $user)
                <p>{{ $user->name }} - {{ $user->email }}</p>
            @endforeach
        @endif

        @if(!$categories->isEmpty())
            <h2>Categories</h2>
            @foreach($categories as $category)
                <p>{{ $category->name }}</p>
            @endforeach
        @endif

        @if(!$bookings->isEmpty())
            <h2>Bookings</h2>
            @foreach($bookings as $booking)
                <p>Event: {{ $booking->event->title }} - User: {{ $booking->user->name }}</p>
            @endforeach
        @endif
    @endif
</div>
@endsection
