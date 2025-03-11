@extends('layouts.app')

@section('content')
<div class="page-container">
    <h1>Frequently Asked Questions</h1>

    <div class="faq">
        <h3>How do I register for an event?</h3>
        <p>Simply visit the <a href="{{ route('events.index') }}">Events</a> page and click on the event you want to register for.</p>
    </div>

    <div class="faq">
        <h3>Can I cancel my registration?</h3>
        <p>Currently, event cancellation depends on the organizer's policies. Please contact the event organizer for details.</p>
    </div>

    <div class="faq">
        <h3>Is there a fee for registering for events?</h3>
        <p>No, our platform does not charge users for registering for events.</p>
    </div>
</div>
@endsection
