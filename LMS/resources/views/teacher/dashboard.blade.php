@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-primary">Welcome Teacher</h1>
            <p class="text-muted">Manage your courses, materials, student progress, and communication.</p>
            <x-announcements-list />
        </div>
    </div>

    <div class="row g-4">
        <!-- Upload Materials -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-upload fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Upload Materials</h5>
                    <p class="card-text">Upload videos, PDFs, and assignments.</p>
                    <a href="{{ route('teacher.materials.index') }}" class="btn btn-outline-primary btn-sm">Upload</a>
                </div>
            </div>
        </div>

        <!-- Manage Students -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Manage Students</h5>
                    <p class="card-text">View enrolled students and track activity.</p>
                    <a href="{{ route('teacher.students.index') }}" class="btn btn-outline-success btn-sm">View Students</a>
                </div>
            </div>
        </div>

        <!-- Student Progress -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-line fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Student Progress</h5>
                    <p class="card-text">See who watched your videos and progress.</p>
                    <a href="{{ route('teacher.materials.progress.overview') }}" class="btn btn-outline-warning btn-sm">Track Progress</a>
                </div>
            </div>
        </div>

        <!-- Send Messages -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-envelope fs-1 text-info"></i>
                    <h5 class="card-title mt-3">Send Messages</h5>
                    <p class="card-text">Send messages to students easily.</p>
                    <a href="{{ route('teacher.messages.index') }}" class="btn btn-outline-info btn-sm">Send Message</a>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
