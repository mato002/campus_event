@extends('layouts.admin')

@section('content')
<div class="flex flex-col p-8">
    <h2 class="text-primary text-3xl font-semibold mb-6">Event Details</h2>

    <table class="table table-bordered table-striped w-full">
        <thead class="bg-blue-700 text-white">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Event Name</th>
                <th class="px-4 py-2">Category</th>
                <th class="px-4 py-2">Start Date</th>
                <th class="px-4 py-2">End Date</th>
                <th class="px-4 py-2">Venue</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-gray-100">
                <td class="px-4 py-2">1</td>
                <td class="px-4 py-2">{{ $event->name }}</td>
                <td class="px-4 py-2">{{ $event->category }}</td>
                <td class="px-4 py-2">{{ $event->start_date }}</td>
                <td class="px-4 py-2">{{ $event->end_date }}</td>
                <td class="px-4 py-2">{{ $event->venue->name ?? 'N/A' }}</td>
                <td class="px-4 py-2 flex space-x-2">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm bg-gray-500 text-white hover:bg-gray-600">Back</a>
                    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning btn-sm bg-yellow-500 text-white hover:bg-yellow-600">Edit</a>

                    <button type="button" class="btn btn-danger btn-sm bg-red-500 text-white hover:bg-red-600" id="delete-btn" data-event-id="{{ $event->id }}">
                        Delete
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("delete-btn").addEventListener("click", function () {
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
                        }).then(() => {
                            window.location.href = "{{ route('admin.events.index') }}";
                        });
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
</script>
@endsection
