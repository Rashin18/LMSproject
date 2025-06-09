@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Material</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teacher.materials.update', $material->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input
                type="text"
                name="title"
                id="title"
                class="form-control"
                value="{{ old('title', $material->title) }}"
                required
            >
        </div>

        <div class="form-group mb-3">
            <label for="subject">Subject <span class="text-danger">*</span></label>
            <input
                type="text"
                name="subject"
                id="subject"
                class="form-control"
                value="{{ old('subject', $material->subject) }}"
                required
            >
        </div>

        <div class="form-group mb-3">
            <label for="type">Type <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-control" required>
                <option value="">-- Select Type --</option>
                <option value="video" {{ old('type', $material->type) == 'video' ? 'selected' : '' }}>Video</option>
                <option value="pdf" {{ old('type', $material->type) == 'pdf' ? 'selected' : '' }}>PDF</option>
                <option value="assignment" {{ old('type', $material->type) == 'assignment' ? 'selected' : '' }}>Assignment</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="material_file">Material File</label>
            <input type="file" name="material_file" id="material_file" class="form-control">
            <small class="form-text text-muted">Leave blank if you don't want to change the file.</small>
            <p>Current file: <a href="{{ route('teacher.materials.view', $material->id) }}" target="_blank">{{ basename($material->file_path) }}</a></p>
        </div>

        <div class="form-group mb-3">
            <label for="student_ids">Assign to Students:</label>
            <select name="student_ids[]" id="student_ids" class="form-control" multiple>
                @foreach($students as $student)
                    <option value="{{ $student->id }}"
                        {{ (collect(old('student_ids', $material->assignedStudents->pluck('id')->toArray()))->contains($student->id)) ? 'selected' : '' }}
                    >
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple students.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update Material</button>
        <a href="{{ route('teacher.materials.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
