@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Create New Assignment</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.assignments.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Assignment Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="course_id" class="form-label">Course *</label>
                        <select class="form-select @error('course_id') is-invalid @enderror" 
                                id="course_id" name="course_id" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }} 
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="due_date" class="form-label">Due Date *</label>
                        <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" 
                               id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="max_score" class="form-label">Max Score *</label>
                        <input type="number" class="form-control @error('max_score') is-invalid @enderror" 
                               id="max_score" name="max_score" value="{{ old('max_score') }}" min="1" required>
                        @error('max_score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
    <label for="status" class="form-label">Status *</label>
    <select class="form-select @error('status') is-invalid @enderror" 
            id="status" name="status" required>
        <option value="">Select Status</option> <!-- Added default option -->
        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="graded" {{ old('status') === 'graded' ? 'selected' : '' }}>Graded</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                        
                    
                    <div class="col-md-4">
                        <label for="file_upload" class="form-label">Attachment (Optional)</label>
                        <input type="file" class="form-control @error('file_path') is-invalid @enderror" 
                               id="file_upload" name="file_path">
                        @error('file_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary me-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Create Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection