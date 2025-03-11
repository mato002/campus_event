@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $event->name }}</h2>
    
    <div class="border-t border-gray-300 pt-4 space-y-3">
        <p class="text-lg"><strong class="text-gray-600">Category:</strong> <span class="text-gray-800">{{ $event->category }}</span></p>
        <p class="text-lg"><strong class="text-gray-600">Venue:</strong> <span class="text-gray-800">{{ $event->venue->name }}</span></p>
        <p class="text-lg"><strong class="text-gray-600">Date:</strong> <span class="text-gray-800">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</span></p>
        <p class="text-lg"><strong class="text-gray-600">Description:</strong> <span class="text-gray-800">{{ $event->description ?? 'No description available.' }}</span></p>
    </div>

    <div class="mt-6 flex justify-between">
        <a href="{{ route('events.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
            Back to Events
        </a>
        
        <form method="POST" action="{{ route('book.event', $event->id) }}">
    @csrf
    <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
        Book Event
    </button>
       </form>

    </div>
</div>

<script>
    document.getElementById('book-event-form').addEventListener('submit', function(event) {
        event.preventDefault();

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Event booked successfully! You can view it in your My Bookings page.');
                window.location.href = "{{ route('my.bookings') }}";
            } else {
                alert('Failed to book event. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
</script>
@endsection
