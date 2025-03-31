@extends('layouts.app')

@section('content')
    <div class="page-container">
        <section class="about-section">
            <div class="about-container">
                <h1>About Us</h1>

                <p>
                    Welcome to the <strong>Campus Event Management System!</strong> Our platform is designed to help students, faculty, and event organizers manage and participate in campus events efficiently.
                </p>
                <p>
                    We aim to streamline event booking, participation, and feedback to create an engaging campus experience.
                </p>

                <div class="about-details">
                    <h2>Our Mission</h2>
                    <p>
                        To provide a seamless and efficient event management platform that enhances the experience of campus life through better coordination and communication.
                    </p>

                    <h2>Our Vision</h2>
                    <p>
                        To be the leading campus event management system that empowers students, faculty, and organizers to create memorable and well-organized events.
                    </p>

                    <h2>Features</h2>
                    <ul>
                        <li>Easy Event Booking & Registration</li>
                        <li>Personalized Dashboards for Users and Admins</li>
                        <li>Event Feedback and Rating System</li>
                        <li>Automated Event Reminders and Notifications</li>
                        <li>Comprehensive Analytics for Event Performance</li>
                    </ul>

                    <h2>Contact Information</h2>
                    <p>
                        For inquiries or support, please reach out to us at: <strong>support@campuseventsystem.com</strong>
                    </p>
                </div>
            </div>
        </section>
    </div>

    <style>
        body {
            background-color: #e5e7eb;
            transition: background-color 0.3s;
        }

        .about-section {
            padding: 3rem 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s;
        }

        .about-container {
            background-color: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
            transition: all 0.3s;
        }

        .about-container h1 {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
            color: #1d4ed8;
        }

        .about-container p {
            color: #4b5563;
            margin-bottom: 1.25rem;
            line-height: 1.8;
            transition: color 0.3s;
        }

        .about-details h2 {
            font-size: 1.75rem;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
            color: #1f2937;
            font-weight: bold;
            transition: color 0.3s;
        }

        .about-details ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
            color: #374151;
            transition: all 0.3s;
        }

        .about-details ul li {
            margin-bottom: 0.5rem;
            position: relative;
            padding-left: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .about-details ul li:hover {
            color: #1d4ed8;
            transform: scale(1.05);
        }

        .about-container:hover {
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.15);
            background-color: #f9fafb;
        }

        .about-details h2:hover {
            color: #1d4ed8;
        }

        a, strong {
            transition: color 0.3s;
        }

        a:hover, strong:hover {
            color: #1d4ed8;
        }
    </style>
@endsection
