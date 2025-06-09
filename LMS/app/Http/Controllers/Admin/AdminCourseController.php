<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Course,
};
class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.courses.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

            Course::create($validated);
        
            return redirect()->route('admin.courses.index')
                ->with('success', 'Course created successfully');
        }

    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully');
    }
}