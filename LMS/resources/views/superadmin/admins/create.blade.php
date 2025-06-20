@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Admin</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('superadmin.admins.store') }}">
        @csrf

        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group mb-3">
    <label>Role</label>
    <select name="role" class="form-control" required>
        <option value="">-- Select Role --</option>
        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
</div>


        <button type="submit" class="btn btn-success">Create Admin</button>
        <a href="{{ route('superadmin.admins.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection