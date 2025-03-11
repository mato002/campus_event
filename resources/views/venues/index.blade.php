@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">Venues</h1>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Button to Create a New Venue -->
        <a href="{{ route('admin.venues.create') }}" class="btn btn-primary mb-3">Add New Venue</a>

        <!-- Venue Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venues as $venue)
                        <tr id="venue-{{ $venue->id }}">
                            <td>{{ $venue->id }}</td>
                            <td>{{ $venue->name }}</td>
                            <td>{{ $venue->capacity }}</td>
                            <td>
                                <a href="{{ route('admin.venues.show', $venue->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.venues.edit', $venue->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm deleteVenue" data-id="{{ $venue->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $venues->links() }}
        </div>
    </div>

    <!-- AJAX Script for Deleting Venue -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.deleteVenue').forEach(button => {
                button.addEventListener('click', function () {
                    let venueId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this venue?')) {
                        fetch(`{{ url('admin/venues') }}/${venueId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById(`venue-${venueId}`).remove();
                                alert('Venue deleted successfully!');
                            } else {
                                alert(data.message || 'Error deleting venue.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            });
        });
    </script>
@endsection
