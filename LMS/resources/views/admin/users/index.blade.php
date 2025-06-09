@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container mt-5">
    <h2>Manage Users</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover mt-4">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="{{ $user->is_blocked ? 'table-danger' : '' }}">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->getRoleNames()->first()) }}</td>
                <td>{{ $user->is_blocked ? 'Blocked' : 'Active' }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>

                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $user->is_blocked ? 'btn-success' : 'btn-warning' }}">
                            {{ $user->is_blocked ? 'Unblock' : 'Block' }}
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
