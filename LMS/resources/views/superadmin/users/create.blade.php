@extends('layouts.app')

@section('title', 'Create New User')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    Register New User
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('superadmin.users.store') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password"
        class="form-control @error('password') is-invalid @enderror" required>
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Password Confirmation -->
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation"
        class="form-control @error('password_confirmation') is-invalid @enderror" required>
    @error('password_confirmation')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">User Role</label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="" disabled selected>Select role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="atc" {{ old('role') == 'atc' ? 'selected' : '' }}>ATC</option>
                                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                                <option value="applicant" {{ old('role') == 'applicant' ? 'selected' : '' }}>Applicant</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Create User</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
