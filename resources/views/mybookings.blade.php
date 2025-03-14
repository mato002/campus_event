@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">My Booked Events</h2>

    @if ($bookedEvents->isEmpty())
        <p class="text-gray-600 text-lg text-center">You have not booked any events yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($bookedEvents as $event)
                <div class="bg-gray-50 p-6 rounded-lg shadow-xl transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">{{ $event->name }}</h3>
                        <p class="text-gray-600 mb-1"><strong>Category:</strong> {{ $event->category }}</p>
                        <p class="text-gray-600 mb-1"><strong>Venue:</strong> {{ $event->venue->name }}</p>
                        <p class="text-gray-600 mb-3"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                    </div>

                    <div class="mt-4 flex flex-col sm:flex-row justify-between items-center">
                        <form method="POST" action="{{ route('cancel.booking', $event->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 shadow-md w-full sm:w-auto">
                                Cancel Booking
                            </button>
                        </form>
                    </div>

                    {{-- Feedback Section --}}
                    @php
                        $feedback = $event->feedback->firstWhere('regular_user_id', auth()->guard('regular_user')->id());
                    @endphp

                    @if ($feedback)
                        <!-- If feedback already exists -->
                        <div class="mt-6 border-t pt-4 border-gray-200">
                            <p class="text-gray-600 font-semibold">Your Feedback:</p>
                            <p class="text-gray-700">Rating: {{ $feedback->rating }} stars</p>
                            <p class="text-gray-700">Comment: {{ $feedback->comment }}</p>
                        </div>
                    @else
                        <!-- If feedback does not exist, show the form -->
                        <form method="POST" action="{{ route('event.feedback.store', $event->id) }}" class="mt-6 border-t pt-4 border-gray-200">
                            @csrf
                            <div class="mb-4">
                                <label for="rating" class="block text-gray-700">Rating (1-5):</label>
                                <input type="number" id="rating" name="rating" min="1" max="5" class="border border-gray-300 rounded-lg w-full py-2 px-4 mt-2" required>
                            </div>
                            <div class="mb-4">
                                <label for="comment" class="block text-gray-700">Comment:</label>
                                <textarea id="comment" name="comment" class="border border-gray-300 rounded-lg w-full py-2 px-4 mt-2" rows="4"></textarea>
                            </div>
                            <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 shadow-md">
                                Submit Feedback
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-8 flex justify-center">
        <a href="{{ route('events.index') }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 shadow-md">
            Browse More Events
        </a>
    </div>
</div>
@endsection
