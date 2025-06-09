@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 mb-0">Backup Management</h1>
        </div>
        <div class="col-auto">
            <form action="{{ route('superadmin.backups.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Backup
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Filename</th>
                            <th>Size</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($backupFiles as $backup)
                            <tr>
                                <td>{{ $backup['filename'] }}</td>
                                <td>{{ formatBytes($backup['size']) }}</td>
                                <td>{{ $backup['date'] }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('superadmin.backups.download', $backup['filename']) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <form action="{{ route('superadmin.backups.restore') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="backup_file" value="{{ $backup['filename'] }}">
                                            <button type="submit" class="btn btn-sm btn-outline-warning" 
                                                    onclick="return confirm('WARNING: This will overwrite your current database. Continue?')">
                                                <i class="fas fa-undo"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('superadmin.backups.destroy', $backup['filename']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this backup?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No backups available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection