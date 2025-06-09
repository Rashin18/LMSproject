<!DOCTYPE html>
<html>
<head>
    <title>System Reports - {{ now()->format('Y-m-d') }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2d3748; font-size: 24px; }
        h2 { color: #4a5568; font-size: 18px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { background-color: #4299e1; color: white; padding: 2px 6px; border-radius: 10px; font-size: 12px; }
    </style>
</head>
<body>
    <h1>System Reports - {{ now()->format('Y-m-d') }}</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    <p>Date range: {{ $data['filters']['start'] }} to {{ $data['filters']['end'] }}</p>

    <h2>System Overview</h2>
    <table>
        <tr>
            <th>Metric</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Total Users</td>
            <td>{{ $data['system']['total_users'] }}</td>
        </tr>
        <tr>
            <td>Active Today</td>
            <td>{{ $data['system']['active_today'] }}</td>
        </tr>
        <tr>
            <td>New This Week</td>
            <td>{{ $data['system']['new_this_week'] }}</td>
        </tr>
    </table>

    <h2>User Statistics</h2>
    <table>
        <tr>
            <th>Role</th>
            <th>Count</th>
        </tr>
        @foreach($data['user']['by_role'] as $role => $count)
        <tr>
            <td>{{ ucfirst($role) }}</td>
            <td><span class="badge">{{ $count }}</span></td>
        </tr>
        @endforeach
    </table>

    <h2>Recent Activity (Last 10)</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>User</th>
            <th>Action</th>
            <th>IP Address</th>
        </tr>
        @foreach($data['audit']->take(10) as $log)
        <tr>
            <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ $log->user->name ?? 'System' }}</td>
            <td>{{ $log->action }}</td>
            <td>{{ $log->ip_address }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
