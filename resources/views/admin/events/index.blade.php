@extends('layouts.admin')

@section('content')
<div class="flex flex-col h-full min-h-screen">
    <h2 class="text-3xl font-semibold mb-6">Events List</h2>

    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-4 bg-blue-500 text-white hover:bg-blue-600 p-3 rounded-md">Create Event</a>

    <div class="flex-grow h-3/4">
        <table class="table table-bordered w-full text-left">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-2">#</th>
                    <th class="px-6 py-2">Event Name</th>
                    <th class="px-6 py-2">Category</th>
                    <th class="px-6 py-2">Start Date</th>
                    <th class="px-6 py-2">End Date</th>
                    <th class="px-6 py-2">Venue</th>
                    <th class="px-6 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="events-table-body">
                @foreach ($events as $index => $event)
                    <tr class="border-b border-gray-300" id="event-row-{{ $event->id }}">
                        <td class="px-6 py-2">{{ $events->firstItem() + $index }}</td>
                        <td class="px-6 py-2">{{ $event->name }}</td>
                        <td class="px-6 py-2">{{ $event->category->name ?? 'No Category' }}</td> <!-- FIXED -->
                        <td class="px-6 py-2">{{ $event->start_date }}</td>
                        <td class="px-6 py-2">{{ $event->end_date }}</td>
                        <td class="px-6 py-2">{{ $event->venue->name ?? 'No Venue' }}</td>
                        <td class="px-6 py-2 flex space-x-2">
                            <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-info btn-sm bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">View</a>
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning btn-sm bg-yellow-500 text-white p-2 rounded-md hover:bg-yellow-600">Edit</a>
                            <button type="button"
                                class="btn btn-danger btn-sm bg-red-500 text-white p-2 rounded-md hover:bg-red-600 delete-btn"
                                data-event-id="{{ $event->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-auto flex justify-between p-4 bg-gray-100">
        @if ($events->previousPageUrl())
            <a href="{{ $events->previousPageUrl() }}" class="btn bg-gray-500 text-white p-3 rounded-md hover:bg-gray-600">
                &lt; Previous
            </a>
        @else
            <span class="p-3 text-gray-400">No Previous Page</span>
        @endif

        @if ($events->nextPageUrl())
            <a href="{{ $events->nextPageUrl() }}" class="btn bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600">
                Next &gt;
            </a>
        @else
            <span class="p-3 text-gray-400">No More Pages</span>
        @endif
    </div>

    <!-- Laravel's built-in pagination -->
    <div class="mt-4">
        {{ $events->links() }} <!-- Laravel's pagination links -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            let eventId = this.getAttribute("data-event-id");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/events/${eventId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Content-Type": "application/json"
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "The event has been deleted successfully.",
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Remove event row from table
                            document.getElementById(`event-row-${eventId}`).remove();
                        } else {
                            Swal.fire("Error!", data.message, "error");
                        }
                    }).catch(error => {
                        Swal.fire("Error!", "An unexpected error occurred.", "error");
                    });
                }
            });
        });
    });
});
</script>
@endsection
