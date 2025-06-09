@extends('layouts.app')

@section('content')
<div class="container">
    <h1>EOI Details</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Name:</strong> {{ $eoi->name }}
                </div>
                <div class="col-md-6">
                    <strong>Email:</strong> {{ $eoi->email }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Status:</strong>
                    <span class="badge bg-{{ 
                        $eoi->status == 'approved' ? 'success' : 
                        ($eoi->status == 'rejected' ? 'danger' : 'warning') 
                    }}">
                        {{ ucfirst($eoi->status) }}
                    </span>
                </div>
                <div class="col-md-6">
                    <strong>Submitted:</strong> {{ $eoi->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
            
            <div class="mb-3">
                <strong>Project Details:</strong>
                <div class="border p-3 mt-2">
                    {!! nl2br(e($eoi->project_details)) !!}
                </div>
            </div>
            
            <form action="{{ route('admin.eois.update-status', $eoi) }}" method="POST">
            @csrf
            
            <div class="row">
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="pending" {{ $eoi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $eoi->status == 'approved' ? 'selected' : '' }}>Approve (will send email)</option>
                <option value="rejected" {{ $eoi->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Update Status</button>
        </div>
    </div>
</form>
        </div>
    </div>
    
    <a href="{{ route('admin.eois.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection