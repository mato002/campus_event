@extends('layouts.app')

@section('content')
<div class="page-container">
    <h1>Contact Us</h1>
    <p>If you have any questions or concerns, feel free to reach out to us!</p>

    <form action="#" method="POST">
        @csrf
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Your Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit">Send Message</button>
    </form>
</div>
@endsection
