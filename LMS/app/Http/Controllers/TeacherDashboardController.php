<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\DB;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        return view('teacher.dashboard');
    }

    public function studentProgressOverview()
    {
        $teacherId = auth()->id();

        // Get materials uploaded by this teacher
        $materials = Material::with(['assignedStudents'])->where('uploaded_by', $teacherId)->get();

        // Load progress records
        $progressRecords = DB::table('material_user_progress')
            ->whereIn('material_id', $materials->pluck('id'))
            ->get()
            ->groupBy(function ($item) {
                return $item->material_id . '-' . $item->user_id;
            });

        // Attach progress data manually to each student
        foreach ($materials as $material) {
            foreach ($material->assignedStudents as $student) {
                $key = $material->id . '-' . $student->id;
                $record = $progressRecords[$key][0] ?? null;

                // Add progress and watched status to the pivot object
                $student->pivot->progress = $record->progress ?? 0;
                $student->pivot->is_watched = $record->is_watched ?? false;
            }
        }

        return view('teacher.materials.progress.index', compact('materials'));
    }
}
