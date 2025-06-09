@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Reports Dashboard</h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-download"></i> Export Reports
            </button>
            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'students']) }}">Export Student Data</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'teachers']) }}">Export Teacher Data</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'courses']) }}">Export Course Data</a></li>
            </ul>
        </div>
    </div>

    <!-- Cards section remains the same -->
    <div class="row mb-4">
        <!-- ... your existing card code ... -->
    </div>

    <!-- Updated Recent Activity Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h4 class="mb-0">Recent Activity</h4>
        </div>
        <div class="card-body">
            @if(isset($recentActivities) && $recentActivities->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Description</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentActivities as $activity)
                            <tr>
                                <td><span class="badge bg-{{ $activity->type_color ?? 'primary' }}">{{ $activity->type ?? 'N/A' }}</span></td>
                                <td>{{ $activity->description ?? 'No description' }}</td>
                                <td>{{ $activity->user->name ?? 'System' }}</td>
                                <td>{{ $activity->created_at->diffForHumans() }}</td>
                                <td>
                                    @if(isset($activity->action_link))
                                        <a href="{{ $activity->action_link }}" class="btn btn-sm btn-outline-primary">View</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No recent activities found</div>
            @endif
        </div>
    </div>
</div>
@endsection