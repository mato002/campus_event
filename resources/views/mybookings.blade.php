@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">My Booked Events</h2>

    @if ($bookedEvents->isEmpty())
        <p class="text-gray-600 text-lg text-center">You have not booked any events yet.</p>
    @else
        <div class="grid gap-6">
            @foreach ($bookedEvents as $event)
                <div class="bg-gray-100 p-6 rounded-lg shadow-md flex flex-col sm:flex-row justify-between items-start sm:items-center border border-gray-300 hover:shadow-lg transition duration-300">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $event->name }}</h3>
                        <p class="text-gray-700"><strong>Category:</strong> {{ $event->category }}</p>
                        <p class="text-gray-700"><strong>Venue:</strong> {{ $event->venue->name }}</p>
                        <p class="text-gray-700"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <form method="POST" action="{{ route('cancel.booking', $event->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-5 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200 shadow-md">
                                Cancel Booking
                            </button>
                        </form>
                    </div>
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
