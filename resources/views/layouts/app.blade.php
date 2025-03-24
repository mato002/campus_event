<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event Management</title>

    <!-- ✅ Google Fonts and FontAwesome CDN -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('styles')

    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* ✅ Top Bar Styles */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            gap: 20px;
            flex-wrap: wrap;
        }

        .search-container {
            flex: 1;
            display: flex;
            justify-content: flex-start;
            min-width: 250px;
        }

        .search-container form {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 400px;
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

        .auth-links {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            min-width: 250px;
        }

        .auth-links a,
        .dropdown {
            text-decoration: none;
            color: #0056b3;
            font-weight: bold;
        }

        .auth-links a:hover {
            text-decoration: underline;
            color: #003d80;
        }

        /* ✅ Dropdown styling */
        .dropdown {
            position: relative;
        }

        .dropdown-btn {
            background-color: #0056b3;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
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
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* ✅ Header Navigation */
        header {
            background: #0056b3;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
        }

        nav ul li a:hover {
            background-color: #003d80;
            border-radius: 5px;
        }

        /* ✅ Main Container */
        .container {
            width: 90%;
            margin: 30px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* ✅ Footer */
        footer {
            background-color: #003d80;
            color: white;
            padding: 30px 20px;
        }

        footer .footer-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        footer .footer-section {
            flex: 1;
            padding: 10px;
            min-width: 250px;
            margin-bottom: 20px;
        }

        footer ul {
            list-style: none;
            padding: 0;
        }

        footer ul li {
            margin-bottom: 10px;
        }

        footer ul li a {
            color: white;
            text-decoration: none;
        }

        footer ul li a:hover {
            text-decoration: underline;
        }

        /* ✅ Social Icons */
        .social-icons a {
            color: white;
            margin-bottom: 15px;
            text-decoration: none;
            transition: color 0.3s, text-decoration 0.3s;
            display: flex;
            align-items: center;
            font-size: 18px;
        }

        .social-icons a i {
            margin-right: 10px;
            font-size: 24px;
        }

        .social-icons a:hover {
            color: #0056b3;
        }

        .social-btn {
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .social-btn:hover {
            background-color: #333;
            color: white;
        }

        /* ✅ Copyright */
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            color: #ccc;
        }

        /* ✅ Responsive Styles */
        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-container {
                justify-content: center;
                width: 100%;
            }

            .auth-links {
                justify-content: center;
                width: 100%;
                margin-top: 10px;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }

            header h1 {
                font-size: 20px;
            }

            footer .footer-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <!-- ✅ Top Bar with Search and Profile/Login/Register -->
    <div class="top-bar">
        <div class="search-container">
            <form action="/search" method="GET">
                <input type="text" name="query" placeholder="Search events..." required>
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                </div>
            @else
                <a href="{{ route('user.login') }}">Login</a>
                <a href="{{ route('user.register') }}">Register</a>
            @endif
        </div>
    </div>

    <!-- ✅ Header Section -->
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

    <!-- ✅ Main Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- ✅ Footer Section -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i>Facebook</a>
                    <a href="#" class="social-btn"><i class="fab fa-instagram"></i>Instagram</a>
                    <a href="#" class="social-btn"><i class="fab fa-twitter"></i>Twitter</a>
                    <a href="#" class="social-btn"><i class="fab fa-youtube"></i>YouTube</a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Important Links</h3>
                <ul>
                    <li><a href="/home">> Home</a></li>
                    <li><a href="/events">> Events</a></li>
                    <li><a href="/categories">> Categories</a></li>
                    <li><a href="/about">> About</a></li>
                    <li><a href="/contact">> Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul>
                    <li>123 Campus Street</li>
                    <li>mathiasodhis@gmail.com</li>
                    <li>+254 728 883 160</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Matech Technologies. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
