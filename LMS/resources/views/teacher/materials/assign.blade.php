@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Assign Material: {{ $material->title }}</h3>

    <form method="POST" action="{{ route('teacher.materials.assign', $material->id) }}">
        @csrf
        <div class="form-group">
            <label>Select Students</label>
            @foreach($students as $student)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                        {{ $material->assignedStudents->contains($student->id) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $student->name }} ({{ $student->email }})</label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary mt-3">Assign</button>
    </form>
</div>
@endsection
