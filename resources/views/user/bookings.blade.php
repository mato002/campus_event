<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">My Bookings</h2>

        @if($bookings->isEmpty())
            <p class="text-gray-600 text-lg text-center">You have no bookings yet.</p>
        @else
            <div class="grid gap-6">
                @foreach($bookings as $booking)
                    <div class="bg-blue-100 p-5 rounded-lg shadow-md flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold text-blue-800">{{ $booking->event->name }}</h3>
                            <p class="text-gray-700">Booked on: {{ $booking->created_at->format('M d, Y') }}</p>
                        </div>
                        <form method="POST" action="{{ route('cancel.booking', $booking->event->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                                Cancel
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
