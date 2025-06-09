@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-primary">Welcome Super Admin</h1>
            <p class="text-muted">Oversee and manage the entire LMS platform including Admins and global system settings.</p>
            @if(\App\Models\Setting::where('key', 'maintenance_mode')->value('value') == '1')
            <div class="alert alert-warning">
                Maintenance mode is currently ACTIVE
            </div>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <!-- Manage Admins -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-check fs-1 text-danger"></i>
                    <h5 class="card-title mt-3">Manage Admins</h5>
                    <p class="card-text">Add or remove Admins, reset access, or monitor activity.</p>
                    <a href="{{ route('superadmin.admins.index') }}" class="btn btn-outline-danger btn-sm">Manage Admins</a>
                </div>
            </div>
        </div>

        <!-- Platform Settings -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-server fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Platform Settings</h5>
                    <p class="card-text">Control system-wide preferences and maintenance mode.</p>
                    <a href="{{ route('superadmin.settings.index') }}" class="btn btn-outline-success btn-sm">Settings</a>
                </div>
            </div>
        </div>

        <!-- Reports -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-data fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">View Reports</h5>
                    <p class="card-text">Audit logs, system usage, and user activity reports.</p>
                    <a href="{{ route('superadmin.reports.index') }}" class="btn btn-outline-info btn-sm">View Reports</a>
                </div>
            </div>
        </div>

        <!-- Register New User -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-plus fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Register New User</h5>
                    <p class="card-text">Create new Admin, Teacher, or Student accounts.</p>
                    <a href="{{ route('superadmin.users.create') }}" class="btn btn-outline-warning btn-sm">Register</a>
                </div>
            </div>
        </div>

        <!-- Manage Users -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 text-info"></i>
                    <h5 class="card-title mt-3">Manage Users</h5>
                    <p class="card-text">View, edit, or delete existing user accounts.</p>
                    <a href="{{ route('superadmin.users.index') }}" class="btn btn-outline-info btn-sm">Manage</a>
                </div>
            </div>
        </div>

        <!-- Announcements -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-megaphone fs-1 text-secondary"></i>
                    <h5 class="card-title mt-3">Announcements</h5>
                    <p class="card-text">Send system-wide messages to users.</p>
                    <a href="{{ route('superadmin.announcements.index') }}" class="btn btn-outline-secondary btn-sm">Announcements</a> {{-- Add route when ready --}}
                </div>
            </div>
        </div>

        <!-- Backup & Restore -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-cloud-arrow-down fs-1 text-dark"></i>
                    <h5 class="card-title mt-3">Backup & Restore</h5>
                    <p class="card-text">Download backups or restore data.</p>
                    <a href="{{ route('superadmin.backups.index') }}" class="btn btn-outline-dark btn-sm">Backup</a> {{-- Add route when ready --}}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
