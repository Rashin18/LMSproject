@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow text-center">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle fa-5x text-danger"></i>
                    </div>
                    <h2 class="mb-3">Link Expired</h2>
                    <p class="lead">The application link has expired or is invalid.</p>
                    <p>Please contact us at {{ config('mail.support_email') }} to request a new link.</p>
                    
                    <div class="mt-4">
                        <a href="/" class="btn btn-primary">
                            Return to Home Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection