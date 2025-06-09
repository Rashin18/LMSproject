@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Payment Details</h4>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Payment Information</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="40%">Payment ID:</th>
                        <td>{{ $payment->id }}</td>
                    </tr>
                    <tr>
                        <th>Order ID:</th>
                        <td>{{ $payment->order_id }}</td>
                    </tr>
                    <tr>
                        <th>Transaction ID:</th>
                        <td>{{ $payment->payment_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Amount Details</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="40%">Amount:</th>
                        <td>₹{{ $payment->formatted_amount }}</td>
                    </tr>
                    <tr>
                        <th>Currency:</th>
                        <td>{{ strtoupper($payment->currency) }}</td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>User:</th>
                        <td>{{ $payment->user->name }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($payment->status === 'completed')
            <div class="text-center mt-3">
                <a href="{{ route('admin.payments.invoice', $payment->id) }}" class="btn btn-primary">
                    <i class="fas fa-file-invoice me-1"></i> Download Invoice
                </a>
            </div>
        @endif
    </div>
</div>

@endsection