@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Venue Details</h2>

    <div class="mb-3">
        <strong>Name:</strong> {{ $venue->name }}
    </div>

    <div class="mb-3">
        <strong>Capacity:</strong> {{ $venue->capacity }}
    </div>

    <a href="{{ route('venues.index') }}" class="btn btn-primary">Back to List</a>
</div>
@endsection
