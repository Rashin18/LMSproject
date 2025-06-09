@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Users</h1>
    <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary mb-3">Add User</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                @if($user->roles->count())
        {{ $user->roles->pluck('name')->join(', ') }}
    @else
        Student
    @endif
        </td>

                <td>{{ $user->is_blocked ? 'Blocked' : 'Active' }}</td>
                <td>
                    <a href="{{ route('superadmin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>

                    <form action="{{ route('superadmin.users.toggle-status', $user->id) }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-sm btn-warning">
        {{ $user->is_blocked ? 'Unblock' : 'Block' }}
    </button>
</form>


                    <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
