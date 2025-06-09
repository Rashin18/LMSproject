@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h4>Create Broadcast Message</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.broadcasts.send') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="recipient_type" class="form-label">Recipients</label>
                    <select class="form-select" id="recipient_type" name="recipient_type" required>
                        @foreach($recipientTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-danger">Send Broadcast</button>
            </form>
        </div>
    </div>
</div>
@endsection