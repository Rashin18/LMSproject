<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required', 'email' => 'required|email', 'message' => 'required'
        ]);

        Contact::create($request->only('name', 'email', 'message'));

        return back()->with('success', 'Message sent successfully!');
    }
}
