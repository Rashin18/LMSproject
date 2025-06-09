<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Material,
};
use Illuminate\Support\Facades\Storage;


class TeacherMaterialController extends Controller
{
    // List all materials for the authenticated teacher
    public function index()
    {
        $materials = Material::where('teacher_id', auth()->id())->latest()->get();
        return view('teacher.materials.index', compact('materials'));
    }

    // Show form to create new material
    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('teacher.materials.create', compact('students'));
    }

    // Store new material
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'subject' => 'required|string|max:255',
        'type' => 'required|in:video,pdf,assignment',
        'material_file' => 'required|file|max:10240|mimes:mp4,mov,avi,mkv,pdf,doc,docx,zip',
        'student_ids' => 'nullable|array',
        'student_ids.*' => 'exists:users,id',
    ]);

    $path = $request->file('material_file')->store('materials', 'public');

    $material = Material::create([
        'teacher_id' => auth()->id(),
        'title' => $request->title,
        'subject' => $request->subject,
        'type' => $request->type,
        'file_path' => $path,
        'download_count' => 0,
    ]);

    // Assign students if any selected
    if ($request->has('student_ids')) {
        $material->assignedStudents()->sync($request->student_ids);
    }

    return redirect()->route('teacher.materials.index')
        ->with('success', 'Material uploaded and assigned successfully.');
}


    // Download a material file and increment download count
    public function download($id)
    {
        $material = Material::where('id', $id)
            ->where('teacher_id', auth()->id())
            ->firstOrFail();

        $material->increment('download_count');

        $fileName = $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($material->file_path, $fileName);
    }

    // Show form to edit existing material
    public function edit($id)
    {
        $material = Material::where('id', $id)
            ->where('teacher_id', auth()->id())
            ->firstOrFail();
    
        $students = User::where('role', 'student')->get();
    
        return view('teacher.materials.edit', compact('material', 'students'));
    }
    // Update existing material
    public function update(Request $request, $id)
{
    $material = Material::where('id', $id)
        ->where('teacher_id', auth()->id())
        ->firstOrFail();

    $request->validate([
        'title' => 'required|string|max:255',
        'subject' => 'required|string|max:255',
        'type' => 'required|in:video,pdf,assignment',
        'material_file' => 'nullable|file|max:10240|mimes:mp4,mov,avi,mkv,pdf,doc,docx,zip',
        'student_ids' => 'nullable|array',
        'student_ids.*' => 'exists:users,id',
    ]);

    $data = [
        'title' => $request->title,
        'subject' => $request->subject,
        'type' => $request->type,
    ];

    if ($request->hasFile('material_file')) {
        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $data['file_path'] = $request->file('material_file')->store('materials', 'public');
    }

    $material->update($data);

    if ($request->has('student_ids')) {
        $material->assignedStudents()->sync($request->student_ids);
    } else {
        $material->assignedStudents()->sync([]); // remove all assigned students if none selected
    }

    return redirect()->route('teacher.materials.index')
        ->with('success', 'Material updated and assigned successfully.');
}

    // Delete material
    public function destroy($id)
    {
        $material = Material::where('id', $id)
            ->where('teacher_id', auth()->id())
            ->firstOrFail();

        // Delete file from storage
        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('teacher.materials.index')
            ->with('success', 'Material deleted successfully.');
    }
    public function view($id)
{
    $material = Material::where('id', $id)->where('teacher_id', auth()->id())->firstOrFail();

    // Return the file inline (for browser viewing)
    return Storage::disk('public')->response($material->file_path);
}
public function assignForm($id)
{
    $material = Material::findOrFail($id);
    $students = User::where('role', 'student')->get();
    return view('teacher.materials.assign', compact('material', 'students'));
}

public function assignToStudents(Request $request, $id)
{
    $material = Material::findOrFail($id);
    $material->assignedStudents()->sync($request->student_ids); // array of user IDs
    return redirect()->route('teacher.materials.index')->with('success', 'Material assigned successfully.');
}
public function assignedStudents($id)
{
    $material = Material::with('assignedStudents')->where('teacher_id', auth()->id())->findOrFail($id);
    return view('teacher.materials.assigned_students', compact('material'));
}
public function removeStudentAssignment($materialId, $studentId)
{
    $material = Material::where('teacher_id', auth()->id())->findOrFail($materialId);
    $material->assignedStudents()->detach($studentId);

    return redirect()->back()->with('success', 'Student assignment removed successfully.');
}

public function progress($id)
{
    $material = Material::where('id', $id)->where('teacher_id', auth()->id())->firstOrFail();
    $students = $material->progressByStudents;

    return view('teacher.materials.progress', compact('material', 'students'));
}
public function progressOverview()
{
    $materials = Material::with('assignedStudents')->where('teacher_id', auth()->id())->get();
    return view('teacher.materials.progress_overview', compact('materials'));
}

public function studentProgress($materialId)
{
    $material = Material::with('progressByStudents')->findOrFail($materialId);
    $students = $material->progressByStudents;

    return view('teacher.materials.progress', compact('material', 'students'));
}


}
