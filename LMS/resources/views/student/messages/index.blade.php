@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-primary mb-4">📬 Messages from Teachers</h2>

    @foreach ($messages as $message)
        <div class="card mb-3 shadow-sm">
            <div class="card-header">
                <strong>{{ $message->subject }}</strong> from <strong>{{ $message->teacher->name ?? 'Unknown Teacher' }}(Teacher)</strong>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $message->body }}</p>

                <!-- Reply form -->
                <form action="{{ route('student.messages.reply') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="teacher_id" value="{{ $message->teacher->id }}">
                    <input type="hidden" name="subject" value="Reply: {{ $message->subject }}">

                    <div class="mb-2">
                        <textarea name="body" rows="2" class="form-control" placeholder="Type your reply..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Send Reply</button>
                </form>
            </div>
        </div>
    @endforeach

    @if ($messages->isEmpty())
        <div class="alert alert-info">No messages available yet.</div>
    @endif
</div>
@endsection