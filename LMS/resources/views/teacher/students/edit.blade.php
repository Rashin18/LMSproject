@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Student</h2>
    <form method="POST" action="{{ route('teacher.students.update', $student->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $student->name }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $student->email }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (leave blank to keep current)</label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
