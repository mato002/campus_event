<!-- resources/views/admin/dashboard.blade.php -->

@extends('layouts.admin')

@section('content')
    <div id="content-area">
        <h2>Welcome to the Campus Event Management System</h2>
        <p>Here we publish all events happening within the Campus together with its schedule</p>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div class="p-4 bg-blue-500 text-white rounded-lg">
            <h3 class="text-xl font-bold">Total Events</h3>
            <p class="text-2xl">{{ $totalEvents }}</p>
        </div>
        <div class="p-4 bg-green-500 text-white rounded-lg">
            <h3 class="text-xl font-bold">Total Venues</h3>
            <p class="text-2xl">{{ $totalVenues }}</p>
        </div>
        <div class="p-4 bg-yellow-500 text-white rounded-lg">
            <h3 class="text-xl font-bold">Total Admins</h3>
            <p class="text-2xl">{{ $totalUsers }}</p>
        </div>

        <div class="p-4 bg-yellow-500 text-white rounded-lg">
            <h3 class="text-xl font-bold">Total Users</h3>
            <p class="text-2xl">{{ $totalRegularUser }}</p>
        </div>
    <div class="p-4 bg-green-500 text-white rounded-lg">

    <h2 class="text-xl font-semibold mb-4">Upcoming Events</h2>


    <ul>
        @foreach($upcomingEvents as $event)
            <li class="text-white rounded-lg">{{ $event->name }} - {{ $event->start_date }}</li>
        @endforeach
    </ul>
    </div>
    </div>



   <!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the data passed from the controller
        const eventCountByMonth = JSON.parse(`{!! json_encode($eventCountByMonth ?? []) !!}`);

        // Extract months and event counts
        const months = eventCountByMonth.map(item => item.month);
        const counts = eventCountByMonth.map(item => item.count);

        // Ensure there's a canvas to draw on
        const canvas = document.getElementById('myChart');
        if (!canvas) {
            console.error("Canvas with id 'myChart' not found!");
            return;
        }

        // Chart.js configuration
        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',  
            data: {
                labels: months.map(month => `Month ${month}`),  // Month labels
                datasets: [{
                    label: 'Number of Events',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<!-- Canvas for the chart -->
<canvas id="myChart" width="400" height="200"></canvas>

@endsection
