@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Profile</h2>

        @if(session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('user.update_profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Profile Picture -->
            <div class="profile-picture-section">
                <label for="profile_picture">Profile Picture:</label>
                <img src="{{ asset('storage/profile_pictures/' . ($user->profile_picture ?? 'default-avatar.png')) }}" class="profile-preview">
                <input type="file" name="profile_picture">
                @error('profile_picture') <p class="error">{{ $message }}</p> @enderror
            </div>

            <!-- Name -->
            <label>Name:</label>
            <input type="text" name="name" value="{{ $user->name }}" required>
            @error('name') <p class="error">{{ $message }}</p> @enderror

            <!-- Email -->
            <label>Email:</label>
            <input type="email" name="email" value="{{ $user->email }}" required>
            @error('email') <p class="error">{{ $message }}</p> @enderror

            <!-- Save Button -->
            <button type="submit" class="btn save-btn">Save Changes</button>
        </form>
    </div>

    <!-- CSS -->
    <style>
        .container {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-picture-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: auto;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .save-btn {
            background: #0056b3;
            color: white;
        }

        .save-btn:hover {
            background: #003d80;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
@endsection
