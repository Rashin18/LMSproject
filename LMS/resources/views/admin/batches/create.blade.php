@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create New Batch</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.batches.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Batch Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="code" class="form-label">Batch Code</label>
                    <input type="text" class="form-control" id="code" name="code" required>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date (Optional)</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <button type="submit" class="btn btn-primary">Create Batch</button>
            </form>
        </div>
    </div>
</div>
@endsection