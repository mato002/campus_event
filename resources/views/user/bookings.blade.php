<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 30px;
        }

        .booking-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #e0f2fe;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
        }

        .booking-card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .event-title {
            font-size: 20px;
            font-weight: bold;
            color: #0c4a6e;
        }

        .booking-date {
            font-size: 14px;
            color: #4b5563;
            margin-top: 4px;
        }

        .cancel-button {
            padding: 8px 16px;
            background-color: #ef4444;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cancel-button:hover {
            background-color: #dc2626;
        }

        .browse-button {
            display: block;
            margin: 30px auto 0;
            padding: 10px 20px;
            background-color: #1d4ed8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
        }

        .browse-button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="header-title">My Booked Events</h2>

        @if($bookings->isEmpty())
            <p class="text-gray-600 text-lg text-center">You have no bookings yet.</p>
        @else
            @foreach($bookings as $booking)
                <div class="booking-card">
                    <div>
                        <h3 class="event-title">{{ $booking->event->name }}</h3>
                        <p class="booking-date">Booked on: {{ $booking->created_at->format('M d, Y') }}</p>
                    </div>
                    <form method="POST" action="{{ route('cancel.booking', $booking->event->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cancel-button">Cancel</button>
                    </form>
                </div>
            @endforeach
        @endif

        <a href="{{ route('browse.events') }}" class="browse-button">Browse More Events</a>
    </div>
</body>
</html>
