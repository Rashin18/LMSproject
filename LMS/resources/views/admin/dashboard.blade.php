@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-primary">Welcome Admin</h1>
            <p class="text-muted">Manage The LMS Platform – Users, Courses And Reports.</p>
            <x-announcements-list />
        </div>
    </div>

    <!-- First Row of Cards -->
    <div class="row g-4">
        <!-- User Management Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Manage Users</h5>
                    <p class="card-text">Approve/Block Users And Reset Passwords.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm">View Users</a>
                </div>
            </div>
        </div>

        <!-- Course Management Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-journal-bookmark fs-1 text-info"></i>
                    <h5 class="card-title mt-3">Manage Courses</h5>
                    <p class="card-text">Create And Organize Courses & Subjects.</p>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-info btn-sm">View Courses</a>
                </div>
            </div>
        </div>

        <!-- Batch Management Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-collection fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Batch Management</h5>
                    <p class="card-text">Create Batches And Assign Students.</p>
                    <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-warning btn-sm">View Batches</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row of Cards -->
    <div class="row g-4 mt-0">
        <!-- Teacher Assignment Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-check fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Teacher Assignment</h5>
                    <p class="card-text">Assign Teachers To Subjects.</p>
                    <a href="{{ route('admin.assignments.index') }}" class="btn btn-outline-success btn-sm">Assign Teachers</a>
                </div>
            </div>
        </div>

        <!-- Reports Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up fs-1 text-purple"></i>
                    <h5 class="card-title mt-3">Reports</h5>
                    <p class="card-text">View Student And Teacher Reports.</p>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-success btn-sm">View Reports</a>
                </div>
            </div>
        </div>

        <!-- Broadcast Messages Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-megaphone fs-1 text-info"></i>
                    <h5 class="card-title mt-3">Broadcast Messages</h5>
                    <p class="card-text">Send Announcements To Users.</p>
                    <a href="{{ route('admin.broadcasts.history') }}" class="btn btn-outline-info btn-sm">Send Message</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Third Row of Cards - EOI and Proposals -->
    <div class="row g-4 mt-0">
        <!-- EOI messages -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-envelope-check fs-1 text-danger"></i>
                    <h5 class="card-title mt-3">Expression Of Interest</h5>
                    <p class="card-text">View And Manage Submitted Expression Of Interests.</p>
                    <a href="{{ route('admin.eois.index') }}" class="btn btn-outline-danger btn-sm">
                        Manage EOIs
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Proposals Card -->
        <div class="col-md-4">
           
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-check fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Recent Proposals</h5>
                    <p class="card-text">View And Manage Submitted Proposals.</p>
                    <a href="{{ route('admin.proposals.index') }}" class="btn btn-outline-warning btn-sm mt-3">
                        View All Proposals
                    </a>
                </div>
            </div>
        </div>

       

        <!-- Empty column to maintain layout -->
        <div class="col-md-4">
            
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-check fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Applications</h5>
                    <p class="card-text">View And Manage Submitted Applications.</p>
                    <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-warning btn-sm mt-3">
                        View Applications
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-0">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-check fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Affiliations</h5>
                    <p class="card-text">View And Manage Submitted Affiliations.</p>
                    <a href="{{ route('admin.affiliations.index') }}" class="btn btn-outline-warning mt-2">
                        View Affiliations
                    </a>
                </div>
            </div>
        </div>    
        
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-credit-card fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Payment</h5>
                    <p class="card-text">Razopay Payment.</p>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-outline-success">
                       <i class="bi bi-credit-card"></i> Manage And Make Payments
                    </a>
                </div>
            </div>
        </div> 
    </div>

    <!-- Quick Actions and System Status -->
    <div class="row mt-4">
        <div class="col-md-6 container">
            <div class="card shadow-sm text-center">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-1">System Status</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Total Students:</strong> {{ $studentCount }}</p>
                    <p class="mb-1"><strong>Total Teachers:</strong> {{ $teacherCount }}</p>
                    <p class="mb-1"><strong>Active Courses:</strong> {{ $courseCount }}</p>
                    <p class="mb-0"><strong>Current Batches:</strong> {{ $batchCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection