<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Batch,
};




class AdminBatchController extends Controller
{

    public function index()
    {
        $batches = Batch::latest()->paginate(10);
        return view('admin.batches.index', compact('batches'));
    }

    public function create()
    {
        return view('admin.batches.create');
    }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:batches,code',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        Batch::create($validated);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch created successfully');
            
    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', 'Error creating batch: ' . $e->getMessage());
    }
}
public function edit(Batch $batch)
    {
        return view('admin.batches.edit', compact('batch'));
    }

    /**
     * Update the specified batch.
     */
    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:batches,code,'.$batch->id,
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $batch->update($validated);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch updated successfully');
    }
    public function destroy(Batch $batch)
    {
        $batch->delete();

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch deleted successfully');
    }

    public function showAssignForm(Batch $batch)
{
    $availableStudents = User::where('role', 'student')
        ->whereDoesntHave('batches', function($query) use ($batch) {
            $query->where('batch_student.batch_id', $batch->id);
        })
        ->orderBy('name')
        ->get();

    $currentStudents = $batch->students;

    return view('admin.batches.assign', compact('batch', 'availableStudents', 'currentStudents'));
}
    
public function assignStudents(Request $request, Batch $batch)
{
    $request->validate([
        'students' => 'required|array',
        'students.*' => 'exists:users,id,role,student'
    ]);

    // Get current students to prevent duplicates
    $currentStudents = $batch->students()->pluck('users.id')->toArray();
    $newStudents = array_diff($request->students, $currentStudents);

    if (!empty($newStudents)) {
        $batch->students()->attach($newStudents);
    }

    return redirect()->route('admin.batches.assign', $batch)
        ->with('success', 'Students assigned successfully');
}
    
    public function removeStudent(Batch $batch, User $student)
    {
        $batch->students()->detach($student->id);
        
        return back()->with('success', 'Student removed from batch');
    }
}