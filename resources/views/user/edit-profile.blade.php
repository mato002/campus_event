@extends('layouts.app')

@section('content')
    <div class="profile-container">
        <h2 class="page-title">Edit Profile</h2>

        @if(session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('user.update_profile') }}" method="POST" enctype="multipart/form-data" class="profile-form">
            @csrf

            <!-- Profile Picture -->
            <div class="profile-picture-section">
                <label for="profile_picture" class="label">Profile Picture</label>
                <img src="{{ asset('storage/profile_pictures/' . ($user->profile_picture ?? 'default-avatar.png')) }}" class="profile-preview">
                <input type="file" name="profile_picture" class="input-file">
                @error('profile_picture') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Name -->
            <div class="input-group">
                <label for="name" class="label">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" required class="input-field">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="input-group">
                <label for="email" class="label">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required class="input-field">
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Bio -->
            <div class="input-group">
                <label for="bio" class="label">Bio</label>
                <textarea name="bio" id="bio" rows="4" class="input-field">{{ $user->bio ?? '' }}</textarea>
                @error('bio') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Phone Number -->
            <div class="input-group">
                <label for="phone" class="label">Phone Number</label>
                <input type="text" name="phone" id="phone" value="{{ $user->phone ?? '' }}" class="input-field">
                @error('phone') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Location -->
            <div class="input-group">
                <label for="location" class="label">Location</label>
                <input type="text" name="location" id="location" value="{{ $user->location ?? '' }}" class="input-field">
                @error('location') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Save and Back Buttons -->
            <div class="button-group">
                <a href="{{ route('user.profile') }}" class="btn back-btn">Back to Profile</a>
                <button type="submit" class="btn save-btn">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- CSS -->
    <style>
        .profile-container {
            max-width: 100%;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        .page-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        .profile-form {
            max-width: 100%;
            width: 100%;
        }

        .profile-picture-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .input-file {
            margin-top: 10px;
            border: 1px solid #ccc;
            padding: 8px;
            border-radius: 5px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #444;
            display: block;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            font-size: 1rem;
            color: #555;
            transition: border 0.3s ease;
        }

        .input-field:focus {
            border-color: #0056b3;
            outline: none;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .back-btn {
            background: #888;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #666;
        }

        .save-btn {
            padding: 12px 20px;
            background: #0056b3;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .save-btn:hover {
            background: #003d80;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
@endsection
