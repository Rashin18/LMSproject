@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-primary">Welcome Applicant</h1>
            <p class="text-muted">Manage the LMS platform – users, courses, and reports.</p>
            <x-announcements-list />
        </div>
    </div>
</div>
@endsection