@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Assigned Students for: {{ $material->title }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($material->assignedStudents->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($material->assignedStudents as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <form action="{{ route('teacher.materials.remove_student_assignment', ['materialId' => $material->id, 'studentId' => $student->id]) }}" method="POST" onsubmit="return confirm('Are you sure to remove this assignment?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No students assigned to this material yet.</p>
    @endif

    <a href="{{ route('teacher.materials.index') }}" class="btn btn-secondary mt-3">Back to Materials</a>
</div>
@endsection
