@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📈 My Progress</h2>

    @if($materials->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Subject</th>
                    <th>Type</th>
                    <th>Watched</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                    <tr>
                        <td>{{ $material->title }}</td>
                        <td>{{ $material->subject }}</td>
                        <td>{{ ucfirst($material->type) }}</td>
                        <td>
                            @if($material->pivot->is_watched)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $material->pivot->progress ?? 0 }}%">
                                    {{ $material->pivot->progress ?? 0 }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">No assigned materials yet.</div>
    @endif
</div>
@endsection
