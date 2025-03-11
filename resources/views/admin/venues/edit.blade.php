@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800">Edit Venue</h2>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger mb-4 p-4 bg-red-100 text-red-800 border-l-4 border-red-500 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success mb-4 p-4 bg-green-100 text-green-800 border-l-4 border-green-500 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form to update venue -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <form action="{{ route('admin.venues.update', $venue->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Venue Name -->
            <div class="mb-4">
                <label for="name" class="form-label text-lg font-medium text-gray-700">Venue Name</label>
                <input type="text" name="name" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name', $venue->name) }}" required>
            </div>

            <!-- Venue Capacity -->
            <div class="mb-4">
                <label for="capacity" class="form-label text-lg font-medium text-gray-700">Capacity</label>
                <input type="number" name="capacity" class="form-control w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('capacity', $venue->capacity) }}" required>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 text-center">
                <button type="submit" class="btn bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out">Update Venue</button>
            </div>
        </form>
    </div>
</div>
@endsection
