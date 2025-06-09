@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center font-weight-light my-4">
                        Affiliation Form: {{ $affiliation->application->proposal->project_title }}
                    </h3>
                </div>
                
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h5><i class="fas fa-exclamation-triangle"></i> Please fix these errors:</h5>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($affiliation->status !== 'pending')
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        This affiliation form has already been submitted.
                    </div>
                    @else
                    <form id="affiliationForm" method="POST" 
                          action="{{ route('affiliation-form.store', [
                              'application' => $affiliation->application_id,
                              'token' => $affiliation->token
                          ]) }}">
                        @csrf
                        
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">Organization Information</h5>
                            
                            <div class="form-group">
                                <label for="organization_name">Organization Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('organization_name') is-invalid @enderror" 
                                       id="organization_name" name="organization_name" 
                                       value="{{ old('organization_name', 'ATC tvm') }}" required>
                                @error('organization_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="organization_type">Organization Type <span class="text-danger">*</span></label>
                                <select class="form-control @error('organization_type') is-invalid @enderror" 
                                        id="organization_type" name="organization_type" required>
                                    <option value="">Select Type</option>
                                    <option value="educational" {{ old('organization_type') == 'educational' ? 'selected' : '' }}>Educational Institution</option>
                                    <option value="nonprofit" {{ old('organization_type') == 'nonprofit' ? 'selected' : '' }}>Non-Profit Organization</option>
                                    <option value="government" {{ old('organization_type') == 'government' ? 'selected' : '' }}>Government Agency</option>
                                    <option value="private" {{ old('organization_type') == 'private' ? 'selected' : '' }}>Private Company</option>
                                    <option value="other" {{ old('organization_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('organization_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">Contact Information</h5>
                            
                            <div class="form-group">
                                <label for="contact_person">Contact Person <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" 
                                       id="contact_person" name="contact_person" 
                                       value="{{ old('contact_person') }}" required>
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                               id="contact_email" name="contact_email" 
                                               value="{{ old('contact_email', $affiliation->application->proposal->contact_email) }}" required>
                                        @error('contact_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_phone">Phone Number</label>
                                        <input type="tel" class="form-control @error('contact_phone') is-invalid @enderror" 
                                               id="contact_phone" name="contact_phone" 
                                               value="{{ old('contact_phone', $affiliation->application->proposal->contact_phone) }}">
                                        @error('contact_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group form-check mb-4">
                            <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" 
                                   id="terms" name="terms" required {{ old('terms') ? 'checked' : '' }}>
                            <label class="form-check-label" for="terms">
                                I certify that the information provided is accurate and complete
                            </label>
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane mr-2"></i> Submit Affiliation Form
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
                
                <div class="card-footer text-center py-3">
                    <small class="text-muted">
                        Need help? Contact us at {{ config('mail.support_email') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection