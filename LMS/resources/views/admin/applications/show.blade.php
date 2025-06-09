@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Application: {{ $application->proposal->project_title }}
            </h6>
            @if($application->status === 'pending')
            <form action="{{ route('admin.applications.approve', $application) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Approve
                </button>
            </form>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Project Details</h5>
                    <p><strong>Title:</strong> {{ $application->proposal->project_title }}</p>
                    <p><strong>Budget:</strong> INR {{ number_format($application->proposal->budget, 2) }}</p>
                    <p><strong>Timeline:</strong> {{ $application->proposal->timeline }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Application Details</h5>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $application->status === 'approved' ? 'success' : 'warning' }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </p>
                    <p><strong>Submitted:</strong> {{ $application->created_at->format('M j, Y g:i a') }}</p>
                </div>
            </div>
            
            <hr>
            
            <h5 class="mt-4">Application Data</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    @foreach($application->data as $key => $value)
                    <tr>
                        <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                        <td>{{ $value }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection