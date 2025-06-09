@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Courses</h1>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
            Create New Course
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($courses->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Teacher</th>
                            <th>Dates</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->teacher->name }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($course->start_date)->format('M d, Y') }}
                                @if($course->end_date)
                                    - {{ \Carbon\Carbon::parse($course->end_date)->format('M d, Y') }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $courses->links() }}
            @else
                <div class="alert alert-info">No courses found</div>
            @endif
        </div>
    </div>
</div>
@endsection