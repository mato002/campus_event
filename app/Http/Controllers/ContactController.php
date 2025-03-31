<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');  // Your contact form view
    }

    public function send(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
    
        // Get the authenticated user
        $user = auth()->user();
    
        // If user is logged in, use their email address as the sender
        $fromEmail = $user ? $user->email : $request->email;
    
        // Prepare the details array
        $details = [
            'name' => $request->name,
            'email' => $fromEmail,
            'message' => $request->message,
        ];
    
        // Send the email
        Mail::to('mathiasodhis@gmail.com')->send(new ContactFormMail($details));
    
        // Redirect back with a success message
        return redirect()->route('contact.form')->with('success', 'Your message has been sent!');
    }
    }

