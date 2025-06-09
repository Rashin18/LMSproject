<!-- resources/views/eoi/form.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Expression of Interest</h4>
        </div>
      <!-- resources/views/eoi/create.blade.php -->
<form method="POST" action="{{ route('eoi.store') }}" id="eoi-form">
    @csrf <!-- Critical for Laravel forms -->
    
    <!-- Guest User Fields -->
    @guest
    <div class="mb-3">
        <label for="name" class="form-label">Full Name *</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Email *</label>
        <input type="email" class="form-control" name="email" required>
    </div>
    @endguest
    
    <div class="mb-3">
        <label for="project_details" class="form-label">Project Details *</label>
        <textarea class="form-control" name="project_details" rows="5" required></textarea>
    </div>

    

    <button type="submit" class="btn btn-primary" id="submit-btn">Submit EOI</button>
</form>

<!-- Add this for error display -->
@if($errors->any())
<div class="alert alert-danger mt-3">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    </div>
</div>
@endsection
@section('scripts')
<script>
document.getElementById('eoi-form').addEventListener('submit', function(e) {
    const btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Submitting...';
});
</script>
@endsection