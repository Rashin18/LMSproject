<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    User,
    Course,
    Student,
    Teacher,
    Batch,
    ActivityLog,
};
use Illuminate\Http\Request;
use App\Exports\{
    StudentsExport,
    TeachersExport,
    CoursesExport,
};
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminReportController extends Controller
{
    public function index()
    {
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.index', compact('recentActivities'));
    }

    public function students() {
        $students = Student::with('courses')->paginate(25);
        return view('admin.reports.students', compact('students'));
    }
    
    public function teachers() {
        $teachers = Teacher::with('courses')->paginate(25);
        return view('admin.reports.teachers', compact('teachers'));
    }
    
    public function courses() {
        $courses = Course::withCount('students')->paginate(25);
        return view('admin.reports.courses', compact('courses'));
    }
    
    public function export($type)
    {
        $validTypes = ['students', 'teachers', 'courses'];
        $validFormats = ['xlsx', 'csv', 'pdf'];

        if (!in_array($type, $validTypes)) {
            abort(404, 'Invalid export type');
        }
    
        
        $filename = ucfirst($type) . '_Export_' . now()->format('Y-m-d_H-i') . '.xlsx';
    
        switch ($type) {
            case 'students':
                return Excel::download(new StudentsExport(), $filename);
            case 'teachers':
                return Excel::download(new TeachersExport(), $filename);
            case 'courses':
                return Excel::download(new CoursesExport(), $filename);
        }
    }
}