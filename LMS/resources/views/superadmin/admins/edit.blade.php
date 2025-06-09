@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Admin</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('superadmin.admins.update', $admin->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Admin</button>
        <a href="{{ route('superadmin.admins.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection