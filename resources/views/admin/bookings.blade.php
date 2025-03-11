@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">User Bookings</h2>

    @if ($bookings->isEmpty())
        <p class="text-gray-600 text-lg">No events have been booked yet.</p>
    @else
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="py-2 px-4 border">Event Name</th>
                    <th class="py-2 px-4 border">Regular User</th>
                    <th class="py-2 px-4 border">Booking Date</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $event)
                    @foreach ($event->regularUsers as $user)
                        <tr class="text-gray-700 border-b">
                            <td class="py-2 px-4 border">{{ $event->name }}</td>
                            <td class="py-2 px-4 border">{{ $user->name }} ({{ $user->email }})</td>
                            <td class="py-2 px-4 border">{{ $user->pivot->created_at->format('M d, Y') }}</td>
                            <td class="py-2 px-4 border">
                                <form method="POST" action="{{ route('admin.cancel.booking', ['eventId' => $event->id, 'userId' => $user->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200"
                                            onclick="return confirm('Are you sure you want to remove this booking?');">
                                        Cancel Booking
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-4 flex justify-center">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
