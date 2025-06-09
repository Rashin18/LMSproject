@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Broadcast History</h4>
                <a href="{{ route('admin.broadcasts.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> New Broadcast
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($broadcasts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="15%">Date</th>
                                <th width="25%">Subject</th>
                                <th width="20%">Recipients</th>
                                <th width="20%">Sent By</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($broadcasts as $broadcast)
                            <tr>
                                <td>{{ $broadcast->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ Str::limit($broadcast->subject, 40) }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ ucfirst($broadcast->recipient_type) }} ({{ $broadcast->recipient_count }})
                                    </span>
                                </td>
                                <td>{{ $broadcast->sender->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" 
                                            data-bs-target="#messageModal{{ $broadcast->id }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $broadcasts->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center py-4">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5>No broadcast history found</h5>
                    <p class="mb-0">You haven't sent any broadcasts yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@foreach($broadcasts as $broadcast)
<!-- Modal for each message -->
<div class="modal fade" id="messageModal{{ $broadcast->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ $broadcast->subject }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h6>Message Content:</h6>
                    <div class="p-3 bg-light rounded">
                        {!! nl2br(e($broadcast->message)) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Recipients:</strong><br>
                        <span class="badge bg-primary">
                            {{ ucfirst($broadcast->recipient_type) }} ({{ $broadcast->recipient_count }} users)
                        </span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Sent On:</strong><br>
                        {{ $broadcast->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('styles')
<style>
    /* Custom pagination styling */
    .pagination {
        --bs-pagination-padding-x: 0.5rem;
        --bs-pagination-padding-y: 0.25rem;
        --bs-pagination-font-size: 0.875rem;
    }
    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        min-width: 32px;
        text-align: center;
    }
</style>
@endpush

@endsection