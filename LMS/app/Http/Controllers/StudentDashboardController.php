<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentDashboardController extends Controller
{
    public function index()
    {
        return view('student.dashboard');
    }

    public function courses()
    {
        // Get materials assigned to the logged-in student
        $materials = auth()->user()->assignedMaterials()->latest('materials.created_at')->get();
        return view('student.courses.index', compact('materials'));
    }

    public function viewMaterial($id)
    {
        // Ensure ID reference is fully qualified to avoid ambiguity
        $material = auth()->user()->assignedMaterials()->where('materials.id', $id)->firstOrFail();

        return Storage::disk('public')->response($material->file_path);
    }

    public function view($id)
        {
            $material = auth()->user()->assignedMaterials()->where('materials.id', $id)->firstOrFail();
        
            // Eloquent pivot update
            auth()->user()->assignedMaterials()->updateExistingPivot($material->id, [
                'is_watched' => true,
                'progress' => 100,
            ]);
        
            return Storage::disk('public')->response($material->file_path);
        }
        
    public function download($id)
    {
        $material = auth()->user()->assignedMaterials()->where('materials.id', $id)->firstOrFail();

        $material->increment('download_count');

        $fileName = $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($material->file_path, $fileName);
    }

    public function updateProgress(Request $request, $materialId)
{
    $user = auth()->user();

    $request->validate([
        'progress' => 'required|integer|min:0|max:100',
        'is_watched' => 'nullable|boolean',
    ]);

    $material = Material::findOrFail($materialId);

    $user->assignedMaterials()->updateExistingPivot($materialId, [
        'progress' => $request->progress,
        'is_watched' => $request->progress == 100 ? true : ($request->is_watched ?? false),
    ]);

    return response()->json(['message' => 'Progress updated']);
}

public function myProgress()
{
    $user = auth()->user();

    $materials = $user->assignedMaterials()->withPivot('progress', 'is_watched')->get();

    return view('student.progress.index', compact('materials'));
}

}
