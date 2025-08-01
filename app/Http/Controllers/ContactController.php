<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Handle form submission
    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|min:10',
        ]);

        Contact::create($request->only(['name', 'email', 'message']));


        // Send email notification to admin
        // Mail::raw("New contact message:\n\nName: {$contact->name}\nEmail: {$contact->email}\nMessage:\n{$contact->message}", function ($message) {
        //     $message->to('admin@example.com')
        //             ->subject('New Contact Message');
        // });

        return back()->with('success', 'Message sent successfully!');
    }

    // Show messages in admin panel
    public function showMessages(Request $request)
{
    $query = Contact::query();

    // Search by name or email
    if ($search = $request->input('search')) {
        $query->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
    }

    // Filter read/unread
    if ($filter = $request->input('filter')) {
        if ($filter === 'read') $query->where('is_read', true);
        if ($filter === 'unread') $query->where('is_read', false);
    }

    $messages = $query->latest()->paginate(10);

    return view('admin.messages.index', compact('messages'));
}


    public function markAsRead($id)
{
    $message = Contact::findOrFail($id);
    $message->is_read = true;
    $message->save();

    return back()->with('success', 'Message marked as read.');
}

}
