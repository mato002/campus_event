<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Message</title>
</head>
<body>
    <h2>New Contact Message</h2>
    <p><strong>Name:</strong> {{ $details['name'] ?? 'N/A' }}</p>
    <p><strong>Email:</strong> {{ $details['email'] ?? 'N/A' }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $details['message'] ?? 'No message provided.' }}</p>
</body>
</html>
