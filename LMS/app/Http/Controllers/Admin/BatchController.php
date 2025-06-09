<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Batch,
    User
};
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   // app/Http/Controllers/Admin/BatchController.php

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
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:batches',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ]);

    Batch::create($request->all());

    return redirect()->route('admin.batches.index')
                   ->with('success', 'Batch created successfully');
}
    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        //
    }
    // Add these methods to your BatchController



public function assignStudents(Batch $batch)
{
    $availableStudents = User::where('role', 'student')
        ->whereDoesntHave('batches', function($query) use ($batch) {
            $query->where('batch_id', $batch->id);
        })
        ->orderBy('name')
        ->get();

    return view('admin.batches.assign-students', compact('batch', 'availableStudents'));
}

/**
 * Store assigned students to a batch
 */
public function storeStudents(Request $request, Batch $batch)
{
    $request->validate([
        'students' => 'required|array',
        'students.*' => 'exists:users,id,role,student'
    ]);

    $batch->students()->attach($request->students);

    return redirect()->route('batches.show', $batch)
        ->with('success', 'Students assigned successfully');
}

/**
 * Remove a student from a batch
 */
public function removeStudent(Batch $batch, User $student)
{
    $batch->students()->detach($student->id);
    
    return back()->with('success', 'Student removed from batch');
}
}

