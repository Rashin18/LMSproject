@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">Create Announcement</div>
        <div class="card-body">
            <form action="{{ route('superadmin.announcements.store') }}" method="POST">
                @csrf
                @include('superadmin.announcements.form')
                
            </form>
        </div>
    </div>
</div>
@endsection