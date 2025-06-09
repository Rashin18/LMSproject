@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container mt-4">
    <h3>Edit User</h3>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
