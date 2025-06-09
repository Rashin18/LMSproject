<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        h1 { color: #2c3e50; margin-bottom: 5px; }
        .summary { 
            display: flex; 
            justify-content: space-around; 
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-item { text-align: center; }
        .summary-value { 
            font-size: 24px; 
            font-weight: bold;
            color: #3498db;
        }
        .summary-label { 
            font-size: 14px; 
            color: #7f8c8d;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #27ae60; color: white; text-align: left; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        .enrollment-high { background-color: #d4edda; }
        .enrollment-medium { background-color: #fff3cd; }
        .enrollment-low { background-color: #f8d7da; }
        .footer { margin-top: 30px; font-size: 12px; text-align: center; color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <div class="report-info">
            Generated on: {{ now()->format('F j, Y \a\t H:i') }}
        </div>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-value">{{ $courses->count() }}</div>
            <div class="summary-label">Total Courses</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $courses->sum('students_count') }}</div>
            <div class="summary-label">Total Enrollments</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">
                {{ number_format($courses->avg('students_count'), 1) }}
            </div>
            <div class="summary-label">Avg. per Course</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Course Name</th>
                <th>Instructor</th>
                <th>Students</th>
                <th>Schedule</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr class="
                @if($course->students_count > 30) enrollment-high
                @elseif($course->students_count > 15) enrollment-medium
                @else enrollment-low
                @endif
            ">
                <td>{{ $course->code }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->teacher->name ?? 'Not assigned' }}</td>
                <td>{{ $course->students_count }}</td>
                <td>
                    {{ $course->schedule ?? 'Not scheduled' }}<br>
                    {{ $course->location ?? 'Location not set' }}
                </td>
                <td>
                    @if($course->is_active)
                        <span style="color: #28a745;">Active</span>
                    @else
                        <span style="color: #dc3545;">Inactive</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ config('app.name') }} - Academic Course Report<br>
        Valid as of {{ now()->format('F j, Y') }}
    </div>
</body>
</html>