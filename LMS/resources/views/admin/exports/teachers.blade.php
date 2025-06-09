<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { max-width: 150px; margin-bottom: 10px; }
        h1 { color: #2c3e50; margin-bottom: 5px; }
        .report-info { margin-bottom: 20px; font-size: 14px; color: #7f8c8d; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #3498db; color: white; text-align: left; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .footer { margin-top: 30px; font-size: 12px; text-align: center; color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="header">
        <!-- Add your institution logo if needed -->
        <!-- <img src="{{ public_path('images/logo.png') }}" class="logo"> -->
        <h1>{{ $title }}</h1>
        <div class="report-info">
            Generated on: {{ now()->format('F j, Y \a\t H:i') }}<br>
            Total Teachers: {{ $teachers->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Courses Teaching</th>
                <th>Join Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->id }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->department ?? 'N/A' }}</td>
                <td>
                    @if($teacher->courses->count() > 0)
                        {{ $teacher->courses->pluck('name')->implode(', ') }}
                    @else
                        No courses assigned
                    @endif
                </td>
                <td>{{ $teacher->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ config('app.name') }} - Teacher Performance Report<br>
        Confidential - For internal use only
    </div>
</body>
</html>