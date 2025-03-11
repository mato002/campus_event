@extends('layouts.app')

@section('content')
    <h2>Search Results for "{{ $query }}"</h2>

    @if ($events->isEmpty())
        <p>No events found.</p>
    @else
        <ul>
            @foreach ($events as $event)
                <li><a href="{{ route('events.show', $event->id) }}">{{ $event->name }}</a></li>
            @endforeach
        </ul>
    @endif
@endsection
