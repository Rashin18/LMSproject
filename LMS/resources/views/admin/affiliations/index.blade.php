@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Submitted Affiliations</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="affiliationsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Project Title</th>
                            <th>Applicant</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($affiliations as $affiliation)
                        <tr>
                            <td>AF-{{ $affiliation->id }}</td>
                            <td>{{ $affiliation->application->proposal->project_title }}</td>
                            <td>{{ $affiliation->application->data['full_name'] ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $affiliation->status === 'approved' ? 'success' : 'warning' }}">
                                    {{ ucfirst($affiliation->status) }}
                                </span>
                            </td>
                            <td>{{ $affiliation->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.affiliations.show', $affiliation) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#affiliationsTable').DataTable();
    });
</script>
@endsection