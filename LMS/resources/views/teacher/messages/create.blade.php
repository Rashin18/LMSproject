@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary">Send Message to Student</h2>

    <form method="POST" action="{{ route('teacher.messages.store') }}">
        @csrf

        <div class="mb-3">
            <label for="student_id" class="form-label">Select Student</label>
            <select class="form-select" name="student_id" required>
                <option value="">-- Choose Student --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Message</label>
            <textarea name="body" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">📤 Send Message</button>
    </form>
</div>
@endsection
