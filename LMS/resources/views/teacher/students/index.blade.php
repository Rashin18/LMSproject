@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Management</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->is_blocked ? 'Blocked' : 'Active' }}</td>
                    <td>
                        <a href="{{ route('teacher.students.edit', $student->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('teacher.students.toggle-block', $student->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">
                                {{ $student->is_blocked ? 'Unblock' : 'Block' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
