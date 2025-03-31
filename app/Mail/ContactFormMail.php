<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ContactFormMail extends Mailable
{
    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->replyTo($this->details['email'])  // Use replyTo instead of from
                    ->subject('New Contact Message')
                    ->view('emails.contact-form')
                    ->with(['details' => $this->details]);
    }
}
