<!-- resources/views/admin/profile.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto">
        <h2 class="text-2xl font-bold mb-4">Admin Profile</h2>

        <!-- Profile Picture Display -->
        <div class="text-center mb-4">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('default-avatar.png') }}" 
                 alt="Profile Picture" class="w-32 h-32 rounded-full mx-auto">
        </div>

        <!-- Admin Details -->
        <div class="space-y-4">
            <div>
                <strong>Name:</strong> {{ $admin->name }}
            </div>
            <div>
                <strong>Email:</strong> {{ $admin->email }}
            </div>
            <div>
                <strong>Created At:</strong> {{ $admin->created_at->format('M d, Y') }}
            </div>
            <div>
                <strong>Last Updated:</strong> {{ $admin->updated_at->format('M d, Y') }}
            </div>
        </div>

        <!-- Profile Picture Upload Form -->
        <div class="mt-4">
            <form action="{{ route('admin.profile.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Upload Profile Picture</label>
                    <input type="file" name="profile_picture" class="border p-2 w-full">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Upload</button>
            </form>
        </div>

        <!-- Edit Profile Button -->
        <div class="mt-4">
            <a href="#" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Edit Profile</a>
        </div>
    </div>
@endsection
