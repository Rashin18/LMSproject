@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Edit Assignment</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.assignments.update', $assignment) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Assignment Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $assignment->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Course</label>
                        <input type="text" class="form-control" 
                               value="{{ $assignment->course->title }}" readonly>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required>{{ old('description', $assignment->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="due_date" class="form-label">Due Date *</label>
                        <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" 
                               id="due_date" name="due_date" 
                               value="{{ old('due_date', $assignment->due_date) }}" required>
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="max_score" class="form-label">Max Score *</label>
                        <input type="number" class="form-control @error('max_score') is-invalid @enderror" 
                               id="max_score" name="max_score" 
                               value="{{ old('max_score', $assignment->max_score) }}" min="1" required>
                        @error('max_score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="pending" {{ old('status', $assignment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="graded" {{ old('status', $assignment->status) === 'graded' ? 'selected' : '' }}>Graded</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                @if($assignment->file_path)
                <div class="mb-3">
                    <label class="form-label">Current Attachment</label>
                    <div>
                        <a href="{{ Storage::url($assignment->file_path) }}" 
                           class="btn btn-sm btn-outline-primary"
                           target="_blank">
                            View Current File
                        </a>
                    </div>
                </div>
                @endif
                
                <div class="mb-3">
                    <label for="file_upload" class="form-label">
                        {{ $assignment->file_path ? 'Replace Attachment' : 'Add Attachment' }} (Optional)
                    </label>
                    <input type="file" class="form-control @error('file_path') is-invalid @enderror" 
                           id="file_upload" name="file_path">
                    @error('file_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary me-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Update Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection