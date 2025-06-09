<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicantDashboardController extends Controller
{
    public function dashboard()
{
    return view('applicant.dashboard');
}
}
