@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Payment History</h4>
            <a href="{{ route('admin.payments.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> New Payment
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->user->name }}</td>
                            <td>₹{{ $payment->formatted_amount }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                   View <i class="fas fa-eye"></i>
                                </a>
                                @if($payment->status === 'completed')
                                    <a href="{{ route('admin.payments.invoice', $payment->id) }}" class="btn btn-sm btn-primary">
                                       Download <i class="fas fa-file-invoice"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No payments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $payments->links() }}
            </div>
        @endif
        
    </div>
</div>

@endsection