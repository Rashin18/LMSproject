@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Assign Students to: {{ $batch->name }}</h4>
                <a href="{{ route('admin.batches.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back to Batches
                </a>
            </div>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <h5>Current Students ({{ $currentStudents->count() }})</h5>
                    @if($currentStudents->count() > 0)
                        <ul class="list-group mb-4">
                            @foreach($currentStudents as $student)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $student->name }} ({{ $student->email }})
                                <form action="{{ route('admin.batches.students.remove', [$batch, $student]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this student?')">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                </form>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-info">No students assigned yet</div>
                    @endif
                </div>
                
                <div class="col-md-6">
                    <h5>Available Students</h5>
                    <form action="{{ route('admin.batches.assign.store', $batch) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <select name="students[]" id="students" class="form-select" multiple size="10">
                                @foreach($availableStudents as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->name }} ({{ $student->email }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Assign Selected Students
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    // Enable better multiple selection
    document.getElementById('students').addEventListener('mousedown', function(e) {
        e.preventDefault();
        const option = e.target;
        if (option.tagName === 'OPTION') {
            option.selected = !option.selected;
        }
    });
</script>
@endpush
@endsection