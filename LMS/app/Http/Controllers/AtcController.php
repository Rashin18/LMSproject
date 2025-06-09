<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // Make sure this import exists
use Illuminate\Http\Request;

class AtcController extends Controller  // Must extend the base Controller
{
    public function __construct()
    {
        
    }

    public function dashboard()
    {
        return view('atc.dashboard');
    }
}