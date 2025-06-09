<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function redirectToDashboard()
{
    $user = auth()->user();
    
    return match($user->role) {
        'superadmin' => redirect()->route('superadmin.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        'teacher' => redirect()->route('teacher.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        'atc' => redirect()->route('atc.dashboard'),
        'applicant' => redirect()->route('applicant.dashboard'),
        default => redirect('/')
    };
}

   } 