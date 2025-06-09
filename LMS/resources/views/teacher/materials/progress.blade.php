@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Progress: {{ $material->title }}</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Email</th>
                <th>Progress</th>
                <th>Watched</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($students as $student)
    <tr>
        <td>{{ $student->name }}</td>
        <td>{{ $student->email }}</td>
        <td>
            @if($student->pivot->is_watched)
                <span class="badge bg-success">Yes</span>
            @else
                <span class="badge bg-secondary">No</span>
            @endif
        </td>
        <td>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ $student->pivot->progress ?? 0 }}%;" aria-valuenow="{{ $student->pivot->progress ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                    {{ $student->pivot->progress ?? 0 }}%
                </div>
            </div>
        </td>
    </tr>
@endforeach



        </tbody>
    </table>
</div>
@endsection
