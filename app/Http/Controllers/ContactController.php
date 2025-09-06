<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Notifications\NewContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    /**
     *  ContactController
     * Store a newly created contact message in storage and send a notification.
     *
     * @param Request $request The incoming HTTP request.
     * @return RedirectResponse A redirect response to the previous page.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate the incoming request data.
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'required|email|max:255',
            'comment' => 'required|string|max:5000',
        ]);

        // 2. Create and store the contact message in the database.
        $contact = Contact::create($validated);

        // 3. Send a notification to the admin email address.
        // Make sure to change 'admin@example.com' to your actual admin email.
        Notification::route('mail', 'admin@example.com')
            ->notify(new NewContactMessage($contact));

        // 4. Redirect the user back with a success message.
        return back()->with('status', 'Your message has been sent successfully!');
    }
}
