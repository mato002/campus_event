<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="flex flex-col h-screen">


    <div class="flex flex-1">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-1/4 p-6 flex flex-col"> 
            <div class="text-3xl font-bold mb-8">
                Campus Event Management System
            </div>
            <ul class="space-y-4 flex-grow">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Home</a>
                </li>
                
                <li>
                    <a href="{{ route('admin.manage-users') }}"><i class="fas fa-users"></i> Manage Users</a>
                </li>

                <li>
                    <a href="{{ route('admin.events.index') }}" class="block px-4 py-2 hover:bg-gray-700">Events</a>
                </li>
                <li>
                    <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2 hover:bg-gray-700">Bookings</a>
                </li>

                <li>
                    <a href="{{ route('admin.venues.index') }}" class="block px-4 py-2 hover:bg-gray-700">Venues</a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" id="users" class="block px-4 py-2 hover:bg-gray-700">Settings</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header with Profile and Logout -->
            <div class="bg-gray-100 p-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Admin Dashboard</h1>

                <div class="relative">
                    <button id="profile-toggle" class="flex items-center space-x-2 text-gray-800 hover:text-gray-600">
                        <span class="font-semibold">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div id="profile-content" class="absolute right-0 mt-2 w-64 bg-gray-800 text-white border border-gray-200 rounded-md shadow-lg hidden">
                        <div class="p-4">
                            <h2 class="text-lg font-bold mb-2">Admin Profile</h2>
                            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p><strong>Role:</strong> Administrator</p>
                            <hr class="my-2">
                            <!-- Added hover effects to the links -->
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Website</a>
                            <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Edit Profile</a>

                            <!-- Logout Section -->
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="submit" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white w-full text-left">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 p-8" id="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer with Copyright -->
    <footer class="bg-gray-800 text-white text-center py-4 w-full">
        &copy; 2025 Matech Technologies
    </footer>

    <script>
        // Toggle profile visibility
        document.getElementById('profile-toggle').addEventListener('click', function(event) {
            event.stopPropagation(); // Prevents click from affecting other elements
            const profileContent = document.getElementById('profile-content');
            profileContent.classList.toggle('hidden');
        });

        // Hide profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileContent = document.getElementById('profile-content');
            const profileToggle = document.getElementById('profile-toggle');
            if (!profileContent.contains(event.target) && !profileToggle.contains(event.target)) {
                profileContent.classList.add('hidden');
            }
        });

        // JavaScript Logout Handling
        document.getElementById('logout-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            if (confirm("Are you sure you want to logout?")) {
                this.submit(); // If confirmed, submit form
            }
        });
    </script>

@yield('scripts')

</body>
</html>
