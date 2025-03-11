@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-4">Venue Details</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold">{{ $venue->name }}</h2>
            <p class="text-gray-700 mt-2"><strong>Capacity:</strong> {{ $venue->capacity }}</p>

            <div class="mt-4">
                <a href="{{ route('admin.venues.edit', $venue->id) }}" class="btn btn-warning bg-yellow-500 text-white p-2 rounded-md hover:bg-yellow-600">Edit Venue</a>

                <form action="{{ route('admin.venues.destroy', $venue->id) }}" method="POST" class="inline-block" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger bg-red-500 text-white p-2 rounded-md hover:bg-red-600" onclick="confirmDelete()">Delete Venue</button>
                </form>
            </div>
        </div>

        <a href="{{ route('admin.venues.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">Back to Venue List</a>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this venue?')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endsection
