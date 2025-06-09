@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h2 class="mb-4">Edit User</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="mb-3">
                    <label for="role" class="form-label">User Role</label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="" disabled>Select role</option>
                        @foreach(['admin','atc', 'teacher', 'student','applicant'] as $role)
                            <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Optional Password Change --}}
                <hr class="my-4">
                <p class="text-muted mb-2">Leave password fields blank if you don't want to change it.</p>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
