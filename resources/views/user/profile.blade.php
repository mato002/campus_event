@extends('layouts.app')

@section('content')
    <div class="profile-container">
        <div class="profile-card">
            <!-- Profile Header -->
            <div class="profile-header">
                <img src="{{ asset('storage/profile_pictures/' . (Auth::guard('regular_user')->user()->profile_picture ?? 'default-avatar.png')) }}" 
                     alt="Profile Picture" 
                     class="profile-picture">
                <h2>{{ Auth::guard('regular_user')->user()->name }}</h2>
                <p class="email">{{ Auth::guard('regular_user')->user()->email }}</p>
            </div>

            <!-- Profile Details Section -->
            <div class="profile-details">
                <div class="detail-item">
                    <span> Phone:</span> {{ Auth::guard('regular_user')->user()->phone ?? 'Not Provided' }}
                </div>
                <div class="detail-item">
                    <span> Location:</span> {{ Auth::guard('regular_user')->user()->location ?? 'Not Provided' }}
                </div>
                <div class="detail-item">
                    <span> Bio:</span> {{ Auth::guard('regular_user')->user()->bio ?? 'Not Provided' }}
                </div>
                <div class="detail-item">
                    <span> Joined On:</span> {{ Auth::guard('regular_user')->user()->created_at->format('F d, Y') }}
                </div>
                <div class="detail-item">
                    <span> Role:</span> Regular User
                </div>
            </div>

            <!-- Profile Actions Section -->
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
        body {
            background-color: #f0f4f8;
            font-family: 'Arial', sans-serif;
        }

        .profile-container {
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .profile-card {
            width: 90%;
            max-width: 1000px;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        .profile-header {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-picture {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0056b3;
            margin-bottom: 15px;
        }

        .profile-header h2 {
            font-size: 1.8rem;
            color: #333;
            margin: 10px 0;
        }

        .email {
            color: #666;
            font-size: 14px;
        }

        .profile-details {
            display: grid;
            gap: 15px;
            border-left: 2px solid #f0f0f0;
            padding-left: 20px;
        }

        .detail-item {
            padding: 10px;
            background: #f9f9f9;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-item span {
            font-weight: bold;
            color: #0056b3;
        }

        .profile-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            grid-column: span 2;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .edit-btn {
            background-color: #0056b3;
        }

        .edit-btn:hover {
            background-color: #004099;
        }

        .logout-btn {
            background-color: red;
        }

        .logout-btn:hover {
            background-color: darkred;
        }

        @media (max-width: 768px) {
            .profile-card {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
