@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary">Sent Messages</h2>
    <a href="{{ route('teacher.messages.create') }}" class="btn btn-sm btn-success mb-3">➕ New Message</a>

    @forelse($messages as $message)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $message->subject }}</h5>
                <p class="card-text">{{ $message->body }}</p>
                <small class="text-muted">To: Student ID {{ $message->student_id }} | Sent: {{ $message->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No messages sent yet.</div>
    @endforelse
</div>
@endsection
