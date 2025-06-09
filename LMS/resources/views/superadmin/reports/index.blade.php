@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- FILTER FORM - ADD THIS RIGHT HERE -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('superadmin.reports.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="start_date">From Date</label>
                        <input type="date" name="start_date" class="form-control" 
                               value="{{ $reports['filters']['start'] }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">To Date</label>
                        <input type="date" name="end_date" class="form-control" 
                               value="{{ $reports['filters']['end'] }}">
                    </div>
                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('superadmin.reports.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END FILTER FORM -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-primary">System Reports</h1>
            <p class="text-muted">Audit logs, system usage, and user activity reports</p>
        </div>
    </div>
     <!-- EXPORT BUTTONS - ADD HERE -->
     <div class="col-auto">
        <div class="mb-3 float-end">
            <a href="{{ route('superadmin.reports.export', ['type' => 'csv'] + request()->query()) }}" 
               class="btn btn-sm btn-outline-success">
               <i class="bi bi-file-earmark-excel"></i> Export CSV
            </a>
            <a href="{{ route('superadmin.reports.export', ['type' => 'pdf'] + request()->query()) }}" 
               class="btn btn-sm btn-outline-danger">
               <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>
    </div>


    <div class="row">
        <!-- System Reports Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">System Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Total Users</h6>
                                <p class="h3">{{ $reports['system']['total_users'] }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Active Today</h6>
                                <p class="h3">{{ $reports['system']['active_today'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>New This Week</h6>
                                <p class="h3">{{ $reports['system']['new_this_week'] }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Storage Usage</h6>
                                <p>{{ $reports['system']['storage_usage']['used'] }} of {{ $reports['system']['storage_usage']['total'] }}</p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ $reports['system']['storage_usage']['percentage'] }}%;" 
                                         aria-valuenow="{{ $reports['system']['storage_usage']['percentage'] }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ $reports['system']['storage_usage']['percentage'] }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Statistics Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">User Statistics</h5>
                </div>
                <div class="card-body">
                    <h6>Users by Role</h6>
                    <ul class="list-group mb-4">
                        @foreach($reports['user']['by_role'] as $role => $count)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ ucfirst($role) }}
                            <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                        </li>
                        @endforeach
                    </ul>
                    
                    <h6>Activity Last 30 Days</h6>
                    <canvas id="activityChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Audit Logs Card -->
    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0 text-white">Audit Logs</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Details</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports['audit'] as $log)
                        <tr>
                            <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ Str::limit($log->details, 50) }}</td>
                            <td>{{ $log->ip_address }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $reports['audit']->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('activityChart').getContext('2d');
        const activityData = @json($reports['user']['activity']);
        
        const labels = activityData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        });
        
        const data = activityData.map(item => item.count);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'User Activity',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush