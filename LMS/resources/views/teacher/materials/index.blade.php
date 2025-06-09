@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Materials</h1>
    <a href="{{ route('teacher.materials.create') }}" class="btn btn-primary mb-3">Upload New Material</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($materials->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Type</th>
                    <th>Downloads</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                <tr>
                    <td>{{ $material->title }}</td>
                    <td>{{ $material->subject }}</td>
                    <td>{{ ucfirst($material->type) }}</td>
                    <td>{{ $material->download_count }}</td>
                    <td>
                        <a href="{{ route('teacher.materials.assigned_students', $material->id) }}" class="btn btn-info btn-sm">Assigned Students</a>
                        <a href="{{ route('teacher.materials.view', $material->id) }}" class="btn btn-sm btn-primary" target="_blank" rel="noopener noreferrer">View</a>
                        <a href="{{ route('teacher.materials.download', $material->id) }}" class="btn btn-sm btn-success">Download</a>
                        <a href="{{ route('teacher.materials.edit', $material->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('teacher.materials.destroy', $material->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this material?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No materials uploaded yet.</p>
    @endif
</div>
@endsection
