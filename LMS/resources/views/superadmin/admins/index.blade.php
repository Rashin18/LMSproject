@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Admins</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('superadmin.admins.create') }}" class="btn btn-success mb-3">Create Admin</a>

    <form method="GET" class="mb-3">
        <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="form-control w-25 d-inline-block">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @if($admins->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->is_blocked ? 'Blocked' : 'Active' }}</td>
                    <td>{{ ucfirst($admin->getRoleNames()->first() ?? 'No Role') }}</td>
                    <td>
                        <a href="{{ route('superadmin.admins.edit', $admin->id) }}" class="btn btn-sm btn-primary">Edit</a>

                        <form action="{{ route('superadmin.admins.toggle-block', $admin->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning">
                                {{ $admin->is_blocked ? 'Unblock' : 'Block' }}
                            </button>
                        </form>

                        <form action="{{ route('superadmin.admins.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $admins->links() }}
    @else
        <p>No admins found.</p>
    @endif
</div>
@endsection