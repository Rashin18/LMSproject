@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Courses</h1>

    @if($materials->count())
        <div class="row">
            @foreach($materials as $material)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $material->title }}</h5>
                            <p><strong>Subject:</strong> {{ $material->subject }}</p>
                            <p><strong>Type:</strong> {{ ucfirst($material->type) }}</p>
                            <a href="{{ route('student.materials.view', $material->id) }}" target="_blank" class="btn btn-primary">View</a>
                            <a href="{{ route('student.materials.download', $material->id) }}" class="btn btn-success">Download</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>You have no assigned materials yet.</p>
    @endif
</div>
@endsection
