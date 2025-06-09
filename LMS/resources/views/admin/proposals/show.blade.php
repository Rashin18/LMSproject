@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2>Proposal: {{ $proposal->project_title }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Project Details</h5>
                    <p><strong>Title:</strong> {{ $proposal->project_title }}</p>
                    <p><strong>Budget:</strong> INR {{ number_format($proposal->budget, 2) }}</p>
                    <p><strong>Timeline:</strong> {{ $proposal->timeline }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Contact Information</h5>
                    <p><strong>Email:</strong> {{ $proposal->contact_email }}</p>
                    <p><strong>Phone:</strong> {{ $proposal->contact_phone ?? 'N/A' }}</p>
                    <p><strong>Submitted:</strong> {{ $proposal->created_at->format('M j, Y g:i a') }}</p>
                </div>
            </div>
            
            <div class="mt-4">
                <h5>Detailed Description</h5>
                <div class="border p-3 bg-light rounded">
                    {!! nl2br(e($proposal->detailed_description)) !!}
                </div>
            </div>
            
            @if($proposal->team_members)
            <div class="mt-4">
                <h5>Team Members</h5>
                <div class="border p-3 bg-light rounded">
                    {!! nl2br(e($proposal->team_members)) !!}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection