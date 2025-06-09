@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Assignment Details</h4>
                <div>
                    <a href="{{ route('admin.assignments.edit', $assignment) }}" class="btn btn-light btn-sm">
                        Edit
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h3>{{ $assignment->title }}</h3>
                    <p class="text-muted">Course: {{ $assignment->course->name }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-{{ $assignment->due_date }}">
                        Due: {{ $assignment->due_date }}
                    </span>
                </div>
            </div>
            
            <div class="mb-4">
                <h5>Description</h5>
                <div class="border p-3 rounded bg-light">
                    {!! nl2br(e($assignment->description)) !!}
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Details</h6>
                            <ul class="list-unstyled">
                                <li><strong>Max Score:</strong> {{ $assignment->max_score }}</li>
                                <li><strong>Created:</strong> {{ $assignment->created_at->diffForHumans() }}</li>
                                <li><strong>Status:</strong> 
                                    <span class="badge bg-{{ $assignment->status === 'graded' ? 'success' : 'warning' }}">
                                        {{ ucfirst($assignment->status) }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    @if($assignment->file_path)
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Attachments</h6>
                            <a href="{{ Storage::url($assignment->file_path) }}" 
                               class="btn btn-outline-primary"
                               target="_blank">
                                <i class="bi bi-download"></i> Download File
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary">
                Back to Assignments
            </a>
        </div>
    </div>
</div>
@endsection