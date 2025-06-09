@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Reset User Password</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.password.reset') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="user_id" class="form-label">Select User</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection