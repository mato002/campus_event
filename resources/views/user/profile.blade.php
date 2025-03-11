@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="profile-card">
            <!-- Profile Picture Section -->
            <div class="profile-header">
            <img src="{{ asset('storage/profile_pictures/' . (Auth::guard('regular_user')->user()->profile_picture ?? 'default-avatar.png')) }}" 
            alt="Profile Picture" 
                class="profile-picture">



                <h2>{{ Auth::guard('regular_user')->user()->name }}</h2>
                <p class="email">{{ Auth::guard('regular_user')->user()->email }}</p>
            </div>

            <!-- Profile Details -->
            <div class="profile-details">
                <h3>Profile Information</h3>
                <p><strong>Phone:</strong> {{ Auth::guard('regular_user')->user()->phone ?? 'Not Provided' }}</p>
                <p><strong>Joined On:</strong> {{ Auth::guard('regular_user')->user()->created_at->format('F d, Y') }}</p>
                <p><strong>Role:</strong> Regular User</p>
            </div>

            <!-- Profile Actions -->
            <div class="profile-actions">
                <a href="{{ route('user.edit_profile') }}" class="btn edit-btn">Edit Profile</a>
                <a href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn logout-btn">
                    Logout
                </a>
            </div>

            <!-- Hidden Logout Form -->
            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Custom CSS for Profile Page -->
    <style>
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-card {
            padding: 20px;
        }

        .profile-header {
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #0056b3;
            object-fit: cover;
        }

        .email {
            color: #666;
            font-size: 14px;
        }

        .profile-details {
            text-align: left;
            margin-top: 20px;
        }

        .profile-details h3 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .profile-details p {
            font-size: 16px;
            margin: 8px 0;
        }

        .profile-actions {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .edit-btn {
            background: #0056b3;
            color: white;
        }

        .edit-btn:hover {
            background: #003d80;
        }

        .logout-btn {
            background: red;
            color: white;
        }

        .logout-btn:hover {
            background: darkred;
        }
    </style>
@endsection
