@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Submitted Proposals</h6>
            <div>
                <a href="{{ route('admin.eois.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back to EOIs
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="proposalsTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Project Title</th>
                            <th>Submitted By</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proposals as $proposal)
                        <tr>
                            <td>PR-{{ $proposal->id }}</td>
                            <td>{{ Str::limit($proposal->project_title, 30) }}</td>
                            <td>{{ $proposal->contact_email }}</td>
                            <td>INR {{ number_format($proposal->budget, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $proposal->status === 'approved' ? 'success' : ($proposal->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($proposal->status) }}
                                </span>
                            </td>
                            <td>{{ $proposal->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.proposals.show', $proposal) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                @if($proposal->status === 'pending')
                                <form action="{{ route('admin.proposals.approve', $proposal) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>

                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No proposals found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($proposals->hasPages())
            <div class="mt-3">
                {{ $proposals->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#proposalsTable').DataTable({
            responsive: true,
            columnDefs: [
                { orderable: false, targets: -1 } // Disable sorting for actions column
            ]
        });
    });
</script>
@endsection