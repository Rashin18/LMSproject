@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Student Progress Overview</h2>

    @if($materials->count())
        <div class="accordion" id="materialAccordion">
            @foreach($materials as $index => $material)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                            {{ $material->title }} ({{ ucfirst($material->type) }})
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#materialAccordion">
                        <div class="accordion-body">
                            @if($material->assignedStudents->count())
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Email</th>
                                            <th>Watched</th>
                                            <th>Progress (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($material->assignedStudents as $student)
    <tr>
        <td>{{ $student->name }}</td>
        <td>{{ $student->email }}</td>
        <td>
            <span class="badge bg-secondary">
                {{ $student->pivot->is_watched ? 'Yes' : 'No' }}
            </span>
        </td>
        <td>
            {{ $student->pivot->progress }}%
        </td>
    </tr>
@endforeach


                                    </tbody>
                                </table>
                            @else
                                <div class="text-muted">No students assigned.</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No materials uploaded yet.</div>
    @endif
</div>
@endsection

