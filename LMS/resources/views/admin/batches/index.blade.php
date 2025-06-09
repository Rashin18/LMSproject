@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Batches</h1>
        <a href="{{ route('admin.batches.create') }}" class="btn btn-primary">
            Create New Batch
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($batches->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($batches as $batch)
                        <tr>
                            <td>{{ $batch->name }}</td>
                            <td>{{ Str::limit($batch->description, 50) }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.batches.edit', $batch) }}" class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>
                                    <!-- Add this new button -->
                                    <a href="{{ route('admin.batches.assign', $batch) }}" 
                                       class="btn btn-sm btn-outline-success">
                                        Assign Students
                                    </a>
                                    <form action="{{ route('admin.batches.destroy', $batch) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $batches->links() }}
            @else
                <div class="alert alert-info">No batches found</div>
            @endif
        </div>
    </div>
</div>
@endsection