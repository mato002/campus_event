@extends('layouts.admin')

@section('content')
<div class="flex flex-col h-full min-h-screen">
    <h2 class="text-3xl font-semibold mb-6">Venues List</h2>

    <!-- Success Message Popup -->
    @if(session('success'))
        <div id="success-alert" class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message Popup -->
    @if(session('error'))
        <div id="error-alert" class="bg-red-500 text-white p-3 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('admin.venues.create') }}" class="btn btn-primary mb-4 bg-blue-500 text-white hover:bg-blue-600 p-3 rounded-md">Add New Venue</a>

    <div class="flex-grow h-3/4">
        <table class="table table-bordered w-full text-left">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-2">#</th>
                    <th class="px-6 py-2">Venue Name</th>
                    <th class="px-6 py-2">Capacity</th>
                    <th class="px-6 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="venues-table-body">
                @foreach ($venues as $index => $venue)
                    <tr class="border-b border-gray-300" id="venue-row-{{ $venue->id }}">
                        <td class="px-6 py-2">{{ ($venues->firstItem() + $index) }}</td>
                        <td class="px-6 py-2">{{ $venue->name }}</td>
                        <td class="px-6 py-2">{{ $venue->capacity }}</td>
                        <td class="px-6 py-2 flex space-x-2">
                            <a href="{{ route('admin.venues.show', $venue->id) }}" class="btn btn-info btn-sm bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">View</a>
                            <a href="{{ route('admin.venues.edit', $venue->id) }}" class="btn btn-warning btn-sm bg-yellow-500 text-white p-2 rounded-md hover:bg-yellow-600">Edit</a>
                            <button class="btn btn-danger btn-sm bg-red-500 text-white p-2 rounded-md hover:bg-red-600 deleteVenue" data-id="{{ $venue->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-auto flex justify-between p-4 bg-gray-100">
        @if ($venues->previousPageUrl())
            <a href="{{ $venues->previousPageUrl() }}" class="btn bg-gray-500 text-white p-3 rounded-md hover:bg-gray-600">&lt; Previous</a>
        @else
            <span class="p-3 text-gray-400">No Previous Page</span>
        @endif

        @if ($venues->nextPageUrl())
            <a href="{{ $venues->nextPageUrl() }}" class="btn bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600">Next &gt;</a>
        @else
            <span class="p-3 text-gray-400">No More Pages</span>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hide success/error alerts after 3 seconds
        setTimeout(() => {
            if (document.getElementById('success-alert')) {
                document.getElementById('success-alert').style.display = 'none';
            }
            if (document.getElementById('error-alert')) {
                document.getElementById('error-alert').style.display = 'none';
            }
        }, 3000);

        // Add event listener for delete buttons
        const deleteButtons = document.querySelectorAll('.deleteVenue');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const venueId = this.getAttribute('data-id');
                
                if (confirm('Are you sure you want to delete this venue?')) {
                    fetch(`/admin/venues/${venueId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the deleted row from the table
                            document.getElementById(`venue-row-${venueId}`).remove();

                            // Reload the page to update venue numbers and pagination
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the venue.');
                    });
                }
            });
        });
    });
</script>
@endsection
