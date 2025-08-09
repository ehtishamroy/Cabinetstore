<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $fullName = trim(($this->data['first-name'] ?? '') . ' ' . ($this->data['last-name'] ?? ''));
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        $replyTo = isset($this->data['email']) && filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)
            ? $this->data['email']
            : null;

        $message = $this->subject('New Contact Form Submission')
            ->from($fromAddress, $fromName)
            ->view('emails.contact-form');

        if ($replyTo) {
            $message->replyTo($replyTo, $fullName ?: null);
        }

        return $message;
    }
}


