@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3>Application Form: {{ $proposal->project_title }}</h3>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('application-form.store', ['proposal' => $proposal->id, 'token' => request()->token]) }}">
                        @csrf
                        
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">Project Information</h5>
                            
                            <div class="form-group">
                                <label for="full_name">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       name="full_name" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Add more form fields as needed -->
                            
                        </div>
                        
                        <div class="form-group form-check mb-4">
                            <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" 
                                   id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I certify that the information provided is accurate
                            </label>
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection