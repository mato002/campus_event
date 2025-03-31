@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">Frequently Asked Questions</h1>
        
        <!-- Search Bar -->
        <div class="mb-6">
            <input type="text" id="searchInput" placeholder="Search for a question..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>
        
        <!-- General Questions -->
        <div class="faq-section mb-8">
            <h2 class="section-title text-2xl font-semibold text-gray-700 mb-4">General Questions</h2>

            <div class="faq mb-4">
                <h3 class="faq-question text-xl font-medium text-blue-600">How do I register for an event?</h3>
                <p class="faq-answer text-gray-600">Simply visit the <a href="{{ route('events.index') }}" class="text-blue-500 underline">Events</a> page and click on the event you want to register for.</p>
            </div>

            <div class="faq mb-4">
                <h3 class="faq-question text-xl font-medium text-blue-600">Can I cancel my registration?</h3>
                <p class="faq-answer text-gray-600">Currently, event cancellation depends on the organizer's policies. Please contact the event organizer for details.</p>
            </div>

            <div class="faq mb-4">
                <h3 class="faq-question text-xl font-medium text-blue-600">Is there a fee for registering for events?</h3>
                <p class="faq-answer text-gray-600">No, our platform does not charge users for registering for events.</p>
            </div>
        </div>

        <!-- Account & Profile Questions -->
        <div class="faq-section mb-8">
            <h2 class="section-title text-2xl font-semibold text-gray-700 mb-4">Account & Profile</h2>

            <div class="faq mb-4">
                <h3 class="faq-question text-xl font-medium text-blue-600">How do I update my profile information?</h3>
                <p class="faq-answer text-gray-600">Go to your dashboard, click on your profile, and edit the desired information. Save your changes when done.</p>
            </div>

            <div class="faq mb-4">
                <h3 class="faq-question text-xl font-medium text-blue-600">What if I forget my password?</h3>
                <p class="faq-answer text-gray-600">Click on the 'Forgot Password?' link on the login page and follow the instructions to reset your password.</p>
            </div>
        </div>

        <!-- Event Participation Questions -->
        <div class="faq-section mb-8">
            <h2 class="section-title text-2xl font-semibold text-gray-700 mb-4">Event Participation</h2>

            <div class="faq mb-4">
                <h3 class="faq-question text-xl font-medium text-blue-600">Can I participate in multiple events?</h3>
                <p class="faq-answer text-gray-600">Yes, you can register for as many events as you wish, as long as you meet the event requirements.</p>
            </div>

            <div class="faq mb-4">
                <h3 class="faq-question text-xl font-medium text-blue-600">Will I receive a confirmation after registering?</h3>
                <p class="faq-answer text-gray-600">Yes, you will receive a confirmation email and a notification in your dashboard upon successful registration.</p>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-blue-50 p-6 rounded-lg text-center shadow-md">
            <h2 class="text-xl font-bold text-blue-600 mb-2">Need Further Assistance?</h2>
            <p class="text-gray-700 mb-4">If you have additional questions or need help, feel free to contact us at:</p>
            <p class="font-semibold text-blue-600">support@campusevents.com</p>
        </div>
    </div>
</div>

<!-- JavaScript for Search Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const faqs = document.querySelectorAll('.faq');

        searchInput.addEventListener('input', () => {
            const filter = searchInput.value.toLowerCase();

            faqs.forEach(faq => {
                const question = faq.querySelector('.faq-question').textContent.toLowerCase();
                const answer = faq.querySelector('.faq-answer').textContent.toLowerCase();

                if (question.includes(filter) || answer.includes(filter)) {
                    faq.style.display = '';
                } else {
                    faq.style.display = 'none';
                }
            });
        });
    });
</script>

@section('styles')
    <style>
        .faq-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.875rem;
            color: #4B5563;
            margin-bottom: 1rem;
        }

        .faq {
            margin-bottom: 1rem;
        }

        .faq-question {
            font-size: 1.125rem;
            color: #1E40AF;
            font-weight: 500;
            cursor: pointer;
            transition: color 0.3s;
        }

        .faq-question:hover {
            color: #2563EB;
        }

        .faq-answer {
            font-size: 1rem;
            color: #4B5563;
        }

        .faq-answer a {
            color: #3B82F6;
            text-decoration: underline;
        }

        .faq-answer a:hover {
            text-decoration: none;
        }

        .bg-blue-50 {
            background-color: #eff6ff;
        }

        .text-center {
            text-align: center;
        }

        .bg-blue-50 p {
            color: #4B5563;
        }

        .bg-blue-50 h2 {
            color: #2563EB;
        }

        .bg-white {
            background-color: white;
        }

        .shadow-lg {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .w-full {
            width: 100%;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .border {
            border: 1px solid #e5e7eb;
        }

        .border-gray-300 {
            border-color: #D1D5DB;
        }

        .rounded-lg {
            border-radius: 0.375rem;
        }

        .focus\:outline-none:focus {
            outline: none;
        }

        .focus\:ring-2:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        .focus\:ring-blue-500:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        .transition {
            transition: all 0.3s ease;
        }
    </style>
@endsection

@endsection
