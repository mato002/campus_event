@extends('layouts.app')

@section('content')
<div class="page-container max-w-4xl mx-auto px-6 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Contact Us</h1>
    <p class="text-gray-600 mb-4">We would love to hear from you! Whether you have questions, feedback, or just want to say hello, feel free to reach out.</p>

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="alert alert-success mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Contact Form -->
    <div class="contact-form-container">
        <h2 class="text-2xl font-medium text-gray-800 mb-4">Get in Touch</h2>
        
        <form action="{{ route('contact.send') }}" method="POST">
            @csrf
            <div class="form-fields">
                <!-- Name -->
                <div class="form-field">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" id="name" name="name" class="form-input" required>
                </div>

                <!-- Email -->
                <div class="form-field">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>
            </div>

            <!-- Message -->
            <div class="form-field">
                <label for="message" class="form-label">Your Message</label>
                <textarea id="message" name="message" rows="6" class="form-input" required></textarea>
            </div>

            <button type="submit" class="form-submit-btn">
                Send Message
            </button>
        </form>
    </div>

    <div class="mt-8 text-center text-gray-500 text-sm">
        <p>&copy; 2025 Campus Events. All rights reserved.</p>
    </div>
</div>

@section('styles')
    <style>
        .contact-form-container {
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 8px;
        }

        .form-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-field {
            margin-bottom: 15px;
        }

        .form-label {
            font-size: 16px;
            color: #4A4A4A;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #3B82F6;
        }

        .form-submit-btn {
            width: 100%;
            background-color: #3B82F6;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .form-submit-btn:hover {
            background-color: #2563EB;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
@endsection
@endsection
