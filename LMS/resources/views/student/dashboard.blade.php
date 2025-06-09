@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-primary">Welcome Student</h1>
            <p class="text-muted">Access your learning materials and track your progress.</p>
            <x-announcements-list />
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-play-btn fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">My Courses</h5>
                    <p class="card-text">Watch assigned lessons and course materials.</p>
                    <a href="{{ route('student.courses') }}" class="btn btn-outline-primary btn-sm">View Courses</a>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up-arrow fs-1 text-success"></i>
                    <h5 class="card-title mt-3">My Progress</h5>
                    <p class="card-text">Track what you’ve completed and upcoming tasks.</p>
                    <a href="{{ route('student.progress') }}" class="btn btn-outline-primary mt-3">📈 Track Progress</a>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-chat-left-text fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Messages</h5>
                    <p class="card-text">Check announcements and messages from teachers.</p>
                    <a href="{{ route('student.messages') }}" class="btn btn-outline-warning btn-sm">View Messages</a>
                </div>
            </div>
        </div>
    </div>




</div>
@endsection
