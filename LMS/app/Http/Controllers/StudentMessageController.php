<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class StudentMessageController extends Controller
{
    public function index()
    {
        // Get messages sent to this student with teacher info
        $messages = Message::with('teacher')->where('student_id', auth()->id())->latest()->get();
        return view('student.messages.index', compact('messages'));
        
        
    }

    public function reply(Request $request)
{
    $request->validate([
        'teacher_id' => 'required|exists:users,id',
        'subject' => 'required|string|max:255',
        'body' => 'required|string',
    ]);

    Message::create([
        'teacher_id' => $request->teacher_id,
        'student_id' => auth()->id(), // student replying
        'subject' => $request->subject,
        'body' => $request->body,
    ]);

    return redirect()->back()->with('success', 'Reply sent successfully.');
}

}