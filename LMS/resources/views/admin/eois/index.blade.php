@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Expressions of Interest</h1>
    
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eois as $eoi)
                    <tr>
                        <td>{{ $eoi->id }}</td>
                        <td>{{ $eoi->name }}</td>
                        <td>{{ $eoi->email }}</td>
                        <td>
                            <span class="badge bg-{{ 
                                $eoi->status == 'approved' ? 'success' : 
                                ($eoi->status == 'rejected' ? 'danger' : 'warning') 
                            }}">
                                {{ ucfirst($eoi->status) }}
                            </span>
                        </td>
                        <td>{{ $eoi->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.eois.show', $eoi) }}" class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $eois->links() }}
        </div>
    </div>
</div>
@endsection