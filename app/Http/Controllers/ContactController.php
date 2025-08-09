<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;

class ContactController extends Controller
{
    /**
     * Handle contact form submission and send an email to site owner
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'first-name' => 'required|string|max:100',
            'last-name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:5000',
        ]);

        try {
            Mail::to('ufone802@gmail.com')->send(new ContactFormSubmission($validated));
        } catch (\Throwable $e) {
            Log::error('Contact form email send failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['contact' => 'Failed to send your message. Please try again later.'])->withInput();
        }

        return back()->with('status', 'Thank you! Your message has been sent.');
    }
}


