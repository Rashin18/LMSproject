<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TeacherUserController extends Controller
{
    // Show all students only
    public function index()
    {
        $students = User::where('role', 'student')->get();
        return view('teacher.students.index', compact('students'));
    }

    // Show edit form
    public function edit($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        return view('teacher.students.edit', compact('student'));
    }

    // Update student
    public function update(Request $request, $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('teacher.students.index')->with('success', 'Student updated successfully.');
    }

    // Block or unblock student
    public function toggleBlock($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->is_blocked = !$student->is_blocked;
        $student->save();

        return redirect()->route('teacher.students.index')->with('success', 'Student status updated.');
    }
}
