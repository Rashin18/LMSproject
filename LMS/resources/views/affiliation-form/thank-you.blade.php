@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow text-center">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#28a745" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>
                    <h2 class="mb-3">Thank You!</h2>
                    <p class="lead">Your affiliation form has been successfully submitted.</p>
                    <p>We've sent a confirmation to the administrator and will contact you soon.</p>
                    
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