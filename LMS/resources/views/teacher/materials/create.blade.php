@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload New Material</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teacher.materials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="subject">Subject <span class="text-danger">*</span></label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="type">Type <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-control" required>
                <option value="">-- Select Type --</option>
                <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="material_file">Material File <span class="text-danger">*</span></label>
            <input type="file" name="material_file" id="material_file" class="form-control" required>
            <small class="form-text text-muted">Allowed file types: mp4, mov, avi, mkv, pdf, doc, docx, zip. Max size 10MB.</small>
        </div>

        <div class="form-group mb-3">
            <label for="student_ids">Assign to Students:</label>
            <select name="student_ids[]" id="student_ids" class="form-control" multiple>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ (collect(old('student_ids'))->contains($student->id)) ? 'selected':'' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple students.</small>
        </div>

        <button type="submit" class="btn btn-primary">Upload Material</button>
        <a href="{{ route('teacher.materials.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
