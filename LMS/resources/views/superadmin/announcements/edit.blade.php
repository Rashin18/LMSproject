@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">Edit Announcement</div>
        <div class="card-body">
            <form action="{{ route('superadmin.announcements.update', $announcement) }}" method="POST">
                @csrf @method('PUT')
                @include('superadmin.announcements.form')
                
            </form>
        </div>
    </div>
</div>
@endsection
