<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event Management</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles') 
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Top Bar Styles */
        .top-bar {
            background: #f8f9fa;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        /* Search Bar */
        .search-container {
            flex: 1;
        }

        .search-container form {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid #ccc;
        }

        .search-container input {
            flex: 1;
            padding: 8px;
            border: none;
            outline: none;
        }

        .search-container button {
            background: #0056b3;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }

        .search-container button:hover {
            background: #003d80;
        }

        /* Auth Links */
        .auth-links {
            margin-left: 20px;
        }

        .auth-links a {
            text-decoration: none;
            color: #0056b3;
            margin-left: 10px;
            font-weight: bold;
        }

        .auth-links a:hover {
            text-decoration: underline;
            color: #ddd;
        }

        /* Header & Navigation */
        header {
            background: #0056b3;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            padding: 8px 12px;
            transition: background 0.3s;
        }

        nav ul li a:hover {
            background: #003d80;
            border-radius: 5px;
        }

        /* Main Content */
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Footer Styles */
        footer {
            background-color: #003d80;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            box-shadow: 0px -4px 6px rgba(0, 0, 0, 0.1);
        }

        footer .footer-container {
            width: 100%;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        footer .footer-section {
            width: 30%;
            padding: 10px;
        }

        footer .footer-section h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        footer .footer-section ul {
            list-style: none;
            padding: 0;
        }

        footer .footer-section ul li {
            margin: 5px 0;
        }

        footer .footer-section ul li a {
            color: white;
            text-decoration: none;
        }

        footer .footer-section ul li a:hover {
            text-decoration: underline;
        }

        .copyright {
            text-align: center;
            background: #222;
            color: white;
            padding: 10px;
            font-size: 14px;
            width: 100%;
        }

        /* Social Icons */
        .social-icons a {
            color: white;
            text-decoration: none;
            margin-right: 10px;
        }

        .social-icons a:hover {
            text-decoration: underline;
        }
        .dropdown {
        position: relative;
        display:flexbox;
        background-color: #333;
    }

    .dropdown-btn {
        background-color: #0056b3;
        color: white;
        padding: 8px 12px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .dropdown-btn:hover {
        background-color: #003d80;
    }

    /* Dropdown Content (hidden by default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f8f9fa;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        padding: 10px;
        border-radius: 5px;
    }

    .dropdown-content a {
        color: black;
        text-decoration: none;
        display: block;
        padding: 8px 12px;
    }

    .dropdown-content a:hover {
        background-color: #222;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
    </style>
</head>
<body>
    <!-- Top Bar with Search, Login, and Register -->
    <div class="top-bar">
        <div class="search-container">
            <form action="/search" method="GET">
                <input type="text" name="query" placeholder="Search events..." required>
                <button type="submit">🔍</button>
            </form>
        </div>
        <div class="auth-links">
        @if(Auth::guard('regular_user')->check())
        <div class="dropdown">
            <button class="dropdown-btn">My Profile</button>
            <div class="dropdown-content">
            <p>{{ Auth::guard('regular_user')->user()->name }}</p>
            <p>{{ Auth::guard('regular_user')->user()->email }}</p>
            <a href="{{ route('my.bookings') }}">My Bookings</a>
            <a href="{{ route('user.edit_profile') }}">Edit Profile</a>


                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
        </div>                    |
        @else
            <a href="{{ route('user.login') }}">Login</a> |
            <a href="{{ route('user.register') }}">Register</a>
        @endif
    </div>
    </div>

    <header>
        <h1>Campus Events</h1>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('events.index') }}">Events</a></li>
                <li><a href="{{ route('categories.index') }}">Categories</a></li>
                <li><a href="{{ route('my.bookings') }}">My Bookings</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('faqs') }}">FAQs</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>

            </ul>
        </nav>
    </header>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com/profile.php?id=100055387355209" target="_blank">🔵 Facebook</a> |
                    <a href="https://www.instagram.com/mathiasmathias5454/" target="_blank">📷 Instagram</a> |
                    <a href="https://x.com/mato33171432" target="_blank">🐦 Twitter</a> |
                    <a href="https://www.youtube.com/@mathiasodhis3368" target="_blank">▶️ YouTube</a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Important Links</h3>
                <ul>
                    <li><a href="/home">Home</a></li>
                    <li><a href="/events">Events</a></li>
                    <li><a href="/my-events">My Events</a></li>
                    <li><a href="/categories">Categories</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/faqs">FAQs</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul>
                    <li>📍 123 Campus Street, City</li>
                    <li>📧 support@campusevents.com</li>
                    <li>📞 +254 728 883 160</li>
                </ul>
            </div>
        </div>
        <p>&copy; {{ date('Y') }} Campus Event Management. All Rights Reserved.</p>
    </footer>

    <div class="copyright">
        <p>&copy; 2025 Matech Technologies</p>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
