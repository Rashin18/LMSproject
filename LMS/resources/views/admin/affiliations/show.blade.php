@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Affiliation: {{ $affiliation->application->proposal->project_title }}
            </h6>
            @if($affiliation->status === 'submitted')
            <form action="{{ route('admin.affiliations.approve', $affiliation) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Approve
                </button>
            </form>
            @endif
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Project Details</h5>
                    <p><strong>Title:</strong> {{ $affiliation->application->proposal->project_title }}</p>
                    <p><strong>Budget:</strong> INR {{ number_format($affiliation->application->proposal->budget, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Affiliation Details</h5>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $affiliation->status === 'approved' ? 'success' : 'warning' }}">
                            {{ ucfirst($affiliation->status) }}
                        </span>
                    </p>
                    <p><strong>Submitted:</strong> {{ $affiliation->created_at->format('M j, Y g:i a') }}</p>
                </div>
            </div>
            
            <h5>Affiliation Information</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    @foreach($affiliation->form_data as $key => $value)
                    <tr>
                        <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                        <td>{{ is_array($value) ? implode(', ', $value) : $value }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection