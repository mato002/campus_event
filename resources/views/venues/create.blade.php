<!-- resources/views/venues/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Create Venue</h1>

    <!-- Display any validation errors -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Venue creation form -->
    <form action="{{ route('venues.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Venue Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="capacity">Capacity</label>
            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity') }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Venue</button>
    </form>
@endsection
