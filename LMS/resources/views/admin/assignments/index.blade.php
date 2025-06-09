@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3>Manage Assignments</h3>
            <div>
                <a href="{{ route('admin.assignments.create') }}" class="btn btn-light">
                    <i class="fas fa-plus"></i> Create New
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @include('admin.assignments.partials.search')
                
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Title</th>
                            <th>Course</th>
                            <th>Teacher</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->title }}</td>
                            <td>{{ $assignment->course->title }}</td>
                            <td>{{ $assignment->teacher->name }}</td>
                            <td>{{ $assignment->due_date }}</td>
                            <td>
                                <span class="badge badge bg-{{ $assignment->status === 'graded' ? 'success' : 'warning' }} ">
                                    {{ ucfirst($assignment->status) }}
                                </span>
                            </td>
                            <td>
    <div class="btn-group btn-group-sm" role="group">
        <a href="{{ route('admin.assignments.show', $assignment) }}" 
           class="btn btn-info" title="View">
            View<i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.assignments.edit', $assignment) }}" 
           class="btn btn-primary" title="Edit">Edit
            <i class="fas fa-edit"></i>
        </a>
        <form class="d-inline" action="{{ route('admin.assignments.destroy', $assignment) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" 
                    onclick="return confirm('Are you sure you want to delete this assignment?')" 
                    title="Delete"> Delete
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</td>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No assignments found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $assignments->links() }}
        </div>
    </div>
</div>
@endsection