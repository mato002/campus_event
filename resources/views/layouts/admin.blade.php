<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>
<body class="flex flex-col min-h-screen">

    <!-- Header with toggle sidebar on mobile -->
    <header class="bg-gray-800 text-white flex items-center justify-between p-4 sm:hidden">
        <div class="text-lg font-bold">Campus Event Management</div>
        <button id="mobile-menu-toggle" class="focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </header>

    <div class="flex flex-1 flex-col sm:flex-row">

        <!-- Sidebar -->
        <aside id="sidebar" class="bg-gray-800 text-white w-full sm:w-1/4 p-4 sm:p-6 flex flex-col space-y-4  sm:flex transition-all duration-300">
            <div class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-8">
                Campus Event Management
            </div>

            <ul class="space-y-2 sm:space-y-4 flex-grow">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">Home</a>
                </li>
                <li>
                    <a href="{{ route('admin.manage-users') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.events.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">Events</a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">Event Categories</a>
                </li>

                <li>
                    <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">Bookings</a>
                </li>
                <li>
                    <a href="{{ route('admin.venues.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">Venues</a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" id="users" class="block px-4 py-2 hover:bg-gray-700 rounded">Settings</a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header with Profile and Logout -->
            <div class="bg-gray-100 p-4 flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-semibold">Admin Dashboard</h1>

                <div class="relative">
                    <button id="profile-toggle" class="flex items-center space-x-2 text-gray-800 hover:text-gray-600 focus:outline-none">
                        <span class="font-semibold text-sm sm:text-base">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div id="profile-content" class="absolute right-0 mt-2 w-48 sm:w-64 bg-gray-800 text-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                        <div class="p-4 text-sm sm:text-base">
                            <h2 class="text-lg font-bold mb-2">Admin Profile</h2>
                            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p><strong>Role:</strong> Administrator</p>
                            <hr class="my-2">
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">Website</a>
                            <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">Edit Profile</a>

                            <!-- Logout Section -->
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="submit" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white w-full text-left rounded">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <main class="flex-1 p-4 sm:p-8" id="content-area">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4 text-sm sm:text-base">
        &copy; 2025 Matech Technologies
    </footer>

    <!-- Scripts -->
    <script>
        // Toggle profile dropdown visibility
        document.getElementById('profile-toggle').addEventListener('click', function(event) {
            event.stopPropagation();
            const profileContent = document.getElementById('profile-content');
            profileContent.classList.toggle('hidden');
        });

        // Hide profile dropdown on outside click
        document.addEventListener('click', function(event) {
            const profileContent = document.getElementById('profile-content');
            const profileToggle = document.getElementById('profile-toggle');
            if (!profileContent.contains(event.target) && !profileToggle.contains(event.target)) {
                profileContent.classList.add('hidden');
            }
        });

        // Confirm logout action
        document.getElementById('logout-form').addEventListener('submit', function(event) {
            event.preventDefault();
            if (confirm("Are you sure you want to logout?")) {
                this.submit();
            }
        });

        // Mobile sidebar toggle
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('sidebar');

        mobileMenuToggle && mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    </script>

    @yield('scripts')
</body>
</html>
