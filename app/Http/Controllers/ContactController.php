<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $subject = "New contact request: " . $request->subject;
        $message = $request->body;
        $headers = 'From: hossamsoliuman@gmail.com' . "\r\n" .
            'Reply-To: ' . $request->email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail('hossamsoliuman@gmail.com', $subject, $message, $headers);

        return redirect()->back()->with('message', 'Thank you for your email');
    }
}
