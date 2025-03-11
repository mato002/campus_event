@extends('layouts.admin')

@section('content')
<div class="flex flex-col h-full min-h-screen">
    <h2 class="text-3xl font-semibold mb-6">Settings</h2>

    <!-- Success Message Popup -->
    @if(session('success'))
        <div id="success-alert" class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message Popup -->
    @if(session('error'))
        <div id="error-alert" class="bg-red-500 text-white p-3 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Site Name -->
        <div class="mb-4 flex items-center">
            <label for="site_name" class="block text-gray-700 w-1/4 mr-4">Site Name</label>
            <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" class="border border-gray-300 p-2 rounded-md w-3/4">
            @error('site_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Timezone -->
        <div class="mb-4 flex items-center">
            <label for="timezone" class="block text-gray-700 w-1/4 mr-4">Timezone</label>
            <input type="text" name="timezone" id="timezone" value="{{ old('timezone', $settings['timezone'] ?? '') }}" class="border border-gray-300 p-2 rounded-md w-3/4">
            @error('timezone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Date Format -->
        <div class="mb-4 flex items-center">
            <label for="date_format" class="block text-gray-700 w-1/4 mr-4">Date Format</label>
            <input type="text" name="date_format" id="date_format" value="{{ old('date_format', $settings['date_format'] ?? '') }}" class="border border-gray-300 p-2 rounded-md w-3/4">
            @error('date_format') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Logo Upload -->
        <div class="mb-4 flex items-center">
            <label for="logo" class="block text-gray-700 w-1/4 mr-4">Logo</label>
            <input type="file" name="logo" id="logo" class="border border-gray-300 p-2 rounded-md w-3/4">
            @error('logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email Configuration -->
        <div class="mb-4 flex items-center">
            <label for="mail_driver" class="block text-gray-700 w-1/4 mr-4">Mail Driver</label>
            <input type="text" name="mail_driver" id="mail_driver" value="{{ old('mail_driver', $settings['mail_driver'] ?? '') }}" class="border border-gray-300 p-2 rounded-md w-3/4">
            @error('mail_driver') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4 flex items-center">
            <label for="mail_host" class="block text-gray-700 w-1/4 mr-4">Mail Host</label>
            <input type="text" name="mail_host" id="mail_host" value="{{ old('mail_host', $settings['mail_host'] ?? '') }}" class="border border-gray-300 p-2 rounded-md w-3/4">
            @error('mail_host') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4 flex items-center">
            <label for="mail_port" class="block text-gray-700 w-1/4 mr-4">Mail Port</label>
            <input type="text" name="mail_port" id="mail_port" value="{{ old('mail_port', $settings['mail_port'] ?? '') }}" class="border border-gray-300 p-2 rounded-md w-3/4">
            @error('mail_port') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600">Save Settings</button>
    </form>

    <!-- Backup Section -->
    <div class="mt-6">
        <h3 class="text-xl font-semibold mb-4">Backup Settings</h3>
        <form action="{{ route('admin.settings.backup') }}" method="GET">
            <button type="submit" class="bg-green-500 text-white p-3 rounded-md hover:bg-green-600">Download Settings Backup</button>
        </form>
    </div>

    <!-- Restore Section -->
    <div class="mt-6">
        <h3 class="text-xl font-semibold mb-4">Restore Settings</h3>
        <form action="{{ route('admin.settings.restore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="settings_file" class="border border-gray-300 p-2 rounded-md mb-4">
            @error('settings_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <button type="submit" class="bg-yellow-500 text-white p-3 rounded-md hover:bg-yellow-600">Restore Settings from File</button>
        </form>
    </div>

    <!-- Test Email Section -->
    <div class="mt-6">
        <h3 class="text-xl font-semibold mb-4">Test Email</h3>
        <form action="{{ route('admin.settings.testEmail') }}" method="POST">
            @csrf
            <input type="email" name="test_email" placeholder="Enter email address" class="border border-gray-300 p-2 rounded-md mb-4 w-1/3">
            <button type="submit" class="bg-indigo-500 text-white p-3 rounded-md hover:bg-indigo-600">Send Test Email</button>
        </form>
    </div>
</div>
@endsection
