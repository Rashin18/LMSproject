<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $request)
{
    $teacherId = auth()->id();

    $query = Material::where('teacher_id', $teacherId);

    // Apply type filter if selected
    if ($request->has('type') && in_array($request->type, ['video', 'pdf', 'assignment'])) {
        $query->where('type', $request->type);
    }

    // Fetch materials sorted by latest
    $materials = $query->orderBy('created_at', 'desc')->get();

    return view('teacher.materials.index', compact('materials'));
}


    public function create()
    {
        return view('teacher.materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,pdf,assignment',
            'file' => 'required|file|mimes:mp4,avi,mov,pdf,docx,zip,rar|max:50000',
        ]);

        $path = $request->file('file')->store('materials', 'public');

        Material::create([
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $path,
        ]);

        return redirect()->route('teacher.materials.index')->with('success', 'Material uploaded successfully.');
    }
    public function edit($id)
{
    $material = Material::where('teacher_id', Auth::id())->findOrFail($id);
    return view('teacher.materials.edit', compact('material'));
}

public function update(Request $request, $id)
{
    $material = Material::where('teacher_id', Auth::id())->findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|in:video,pdf,assignment',
        'file' => 'nullable|file|mimes:mp4,avi,mov,pdf,docx,zip,rar|max:50000',
    ]);

    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('materials', 'public');
        $material->file_path = $path;
    }

    $material->title = $request->title;
    $material->type = $request->type;
    $material->save();

    return redirect()->route('teacher.materials.index')->with('success', 'Material updated successfully.');
}

public function destroy($id)
{
    $material = Material::where('teacher_id', Auth::id())->findOrFail($id);
    $material->delete();

    return redirect()->route('teacher.materials.index')->with('success', 'Material deleted successfully.');
}

public function download($id)
{
    $material = Material::where('teacher_id', Auth::id())->findOrFail($id);
    $material->increment('download_count');

    return response()->download(storage_path("app/public/{$material->file_path}"));
}

}
