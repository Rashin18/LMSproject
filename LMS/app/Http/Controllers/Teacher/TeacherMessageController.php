<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherMessageController extends Controller
{
    public function index()
    {
        // Show messages sent by this teacher
        //$messages = Message::where('teacher_id', auth()->id())->latest()->get();
        //return view('teacher.messages.index', compact('messages'));
        // Get messages sent to this teacher (i.e. teacher is the receiver)
        $messages = Message::with('student')
        ->where('teacher_id', auth()->id())
        ->latest()
        ->get();

        return view('teacher.messages.index', compact('messages'));

    }

    public function create()
    {
        // Get only students
        $students = User::where('role', 'student')->get();
        return view('teacher.messages.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Message::create([
            'teacher_id' => auth()->id(),
            'student_id' => $request->student_id,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return redirect()->route('teacher.messages.index')->with('success', 'Message sent successfully!');
    }
}
