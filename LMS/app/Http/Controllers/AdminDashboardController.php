<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Proposal;
class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'studentCount' => User::where('role', 'student')->count(),
            'teacherCount' => User::where('role', 'teacher')->count(),
            'courseCount' => Course::count(),
            'batchCount' => Batch::count(),
            'recentProposals' => Proposal::with('eoi')
                ->latest()
                ->take(5)
                ->get()
        ]);
    }
}

