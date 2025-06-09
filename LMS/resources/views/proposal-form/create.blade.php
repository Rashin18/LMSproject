@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center font-weight-light my-4">Submit Your Proposal</h3>
                </div>
                
                <div class="card-body">
                    @if($eoi->status !== 'approved')
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        This form requires an approved Expression of Interest
                    </div>
                    @else
                    <form id="proposalForm" action="{{ route('proposal-form.store', $eoi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">Project Information</h5>
                            
                            <div class="form-group">
                                <label for="project_title">Project Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('project_title') is-invalid @enderror" 
                                       id="project_title" name="project_title" value="{{ old('project_title') }}" required>
                                @error('project_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="detailed_description">Detailed Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('detailed_description') is-invalid @enderror" 
                                          id="detailed_description" name="detailed_description" rows="5" required>{{ old('detailed_description') }}</textarea>
                                @error('detailed_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Minimum 100 characters</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="budget">Estimated Budget (INR) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('budget') is-invalid @enderror" 
                                               id="budget" name="budget" value="{{ old('budget') }}" required>
                                        @error('budget')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="timeline">Project Timeline <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('timeline') is-invalid @enderror" 
                                               id="timeline" name="timeline" value="{{ old('timeline') }}" required>
                                        @error('timeline')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">Team Information</h5>
                            
                            <div class="form-group">
                                <label for="team_members">Team Members (if any)</label>
                                <textarea class="form-control @error('team_members') is-invalid @enderror" 
                                          id="team_members" name="team_members" rows="3">{{ old('team_members') }}</textarea>
                                @error('team_members')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">List team members and their roles</small>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">Contact Information</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                               id="contact_email" name="contact_email" value="{{ old('contact_email') }}" required>
                                        @error('contact_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_phone">Phone Number</label>
                                        <input type="tel" class="form-control @error('contact_phone') is-invalid @enderror" 
                                               id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                                        @error('contact_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group form-check mb-4">
                            <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" 
                                   id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">terms and conditions</a>
                                <span class="text-danger">*</span>
                            </label>
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane mr-2"></i> Submit Proposal
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

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('partials.terms-and-conditions')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Character counter for description
    document.getElementById('detailed_description').addEventListener('input', function() {
        const minLength = 100;
        const currentLength = this.value.length;
        const counter = document.getElementById('descCounter') || document.createElement('small');
        counter.id = 'descCounter';
        counter.className = 'form-text ' + (currentLength < minLength ? 'text-danger' : 'text-success');
        counter.textContent = `${currentLength} / ${minLength} characters`;
        
        if (!this.nextElementSibling || this.nextElementSibling.id !== 'descCounter') {
            this.parentNode.appendChild(counter);
        }
    });

    // Form submission handling
    document.getElementById('proposalForm')?.addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Submitting...';
    });
</script>
@endsection