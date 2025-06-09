<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\{
    StoreAssignmentRequest,
    UpdateAssignmentRequest,
};
use App\Models\{
    Assignment,
    Course,
    User,
};


class AdminAssignmentController extends Controller
{
    public function index()
{
    $search = request('search');
    
    $assignments = Assignment::with(['course', 'teacher'])
        ->when($search, function($query) use ($search) {
            $query->where(function($query) use ($search) {
                $query->where('assignments.title', 'like', '%' . $search . '%')
                      ->orWhere('assignments.description', 'like', '%' . $search . '%')
                      ->orWhereHas('course', function($query) use ($search) {
                          $query->where('title', 'like', '%' . $search . '%');
                      })
                      ->orWhereHas('teacher', function($query) use ($search) {
                          $query->where('teacher_id', 'like', '%' . $search . '%');
                                
                      });
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.assignments.index', compact('assignments'));
}

    public function create()
    {
    // Check if the active scope exists before using it
    $courses = method_exists(Course::class, 'scopeActive') 
        ? Course::active()->get()
        : Course::all();

    $teachers = User::where('role', 'teacher')->get();
    
    return view('admin.assignments.create', compact('courses', 'teachers'));
    }

    public function store(StoreAssignmentRequest $request)
    {
        Assignment::create($request->validated());

        return redirect()->route('admin.assignments.index')
            ->with('success', 'Assignment created successfully');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load([
            'course',
            'teacher',
            'submissions' => function($query) {
                $query->with('student')->latest();
            }
        ]);
    
        return view('admin.assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $courses = Course::active()->get();
        $teachers = User::where('role', 'teacher')->get();
        
        return view('admin.assignments.edit', compact('assignment', 'courses', 'teachers'));
    }

    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $assignment->update($request->validated());

        return redirect()->route('admin.assignments.index')
            ->with('success', 'Assignment updated successfully');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->submissions()->exists()) {
            return back()->with('error', 'Cannot delete assignment with submissions');
        }

        $assignment->delete();

        return redirect()->route('admin.assignments.index')
            ->with('success', 'Assignment deleted successfully');
    }
}