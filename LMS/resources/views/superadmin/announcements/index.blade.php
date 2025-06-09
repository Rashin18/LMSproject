@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h1>Announcements</h1>
        <a href="{{ route('superadmin.announcements.create') }}" class="btn btn-primary">
            Create Announcement
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date Range</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td>
                            <span class="badge bg-{{ $announcement->is_active ? 'success' : 'danger' }}">
                                {{ $announcement->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            @if($announcement->start_at)
                                {{ $announcement->start_at->format('M d, Y') }} - 
                                {{ $announcement->end_at?->format('M d, Y') ?? 'No end date' }}
                            @else
                                No date range
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('superadmin.announcements.edit', $announcement) }}" 
                               class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('superadmin.announcements.toggle', $announcement) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                    {{ $announcement->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form action="{{ route('superadmin.announcements.destroy', $announcement) }}" 
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection