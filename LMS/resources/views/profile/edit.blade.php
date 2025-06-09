@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Edit Profile</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Profile Update Form --}}
    <form method="POST" action="{{ route('profile.update') }}" class="mb-4">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="form-control"
                required
                autofocus
            >
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="form-control"
                required
            >
        </div>

        <hr class="my-4">

        <h4 class="mb-3">Change Password</h4>

        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input
                type="password"
                id="current_password"
                name="current_password"
                class="form-control"
                placeholder="Leave blank to keep current password"
            >
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input
                type="password"
                id="new_password"
                name="new_password"
                class="form-control"
                placeholder="Leave blank to keep current password"
            >
            <div class="form-text">Minimum 8 characters</div>
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
            <input
                type="password"
                id="new_password_confirmation"
                name="new_password_confirmation"
                class="form-control"
                placeholder="Confirm new password"
            >
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    {{-- Delete Profile Form --}}
    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Profile</button>
    </form>
</div>
@endsection