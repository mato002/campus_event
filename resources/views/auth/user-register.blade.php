<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration | CEMS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .branding {
            text-align: center;
            margin-bottom: 20px;
        }

        .branding img {
            width: 80px;
            height: auto;
        }

        .scrolling-text-wrapper {
            overflow: hidden;
            white-space: nowrap;
            background-color: #66ccff;
            border-radius: 5px;
            margin-top: 10px;
        }

        .scrolling-text {
            display: inline-block;
            padding: 10px 0;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            animation: scrollRight 10s linear infinite;
        }

        @keyframes scrollRight {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input:focus {
            border-color: #0056b3;
            outline: none;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #003d80;
        }

        .auth-links {
            text-align: center;
            margin-top: 20px;
        }

        .auth-links a {
            color: #0056b3;
            text-decoration: none;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .view-website {
            text-align: center;
            margin-top: 30px;
        }

        .view-website a {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .view-website a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Branding and Scrolling Title -->
    <div class="branding">
        <img src="{{ asset('storage/logos/logo.png') }}" alt="Website Logo" style="height: 50px;">
        <div class="scrolling-text-wrapper">
            <div class="scrolling-text">Campus Event Management System</div>
        </div>
    </div>

    <h2>User Registration</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.register') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name') }}" 
                required
            >
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ old('email') }}" 
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                required
            >
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                required
            >
        </div>

        <div class="form-group">
            <button type="submit">Register</button>
        </div>
    </form>

    <div class="auth-links">
        <p>Already have an account? 
            <a href="{{ route('user.login') }}">Login</a>
        </p>
    </div>

    <!-- View Website Button -->
    <div class="view-website">
        <a href="{{ route('home') }}">View Website</a>
    </div>
</div>

</body>
</html>
