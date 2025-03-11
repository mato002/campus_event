@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Venue</h2>

    <form action="{{ route('venues.update', $venue->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Venue Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $venue->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $venue->capacity) }}" required>
            @error('capacity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update Venue</button>
    </form>
</div>
@endsection
