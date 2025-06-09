@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm" id="invoice">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0 text-primary">{{ config('app.name') }}</h2>
                            <p class="mb-0 text-muted">{{ config('app.address') }}</p>
                        </div>
                        <div class="text-end">
                            <h3 class="mb-0">INVOICE</h3>
                            <p class="mb-0"><strong>Date:</strong> {{ now()->format('d/m/Y') }}</p>
                            <p class="mb-0"><strong>Invoice #:</strong> INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Bill To -->
                    <div class="row mb-4 border-bottom pb-3">
                        <div class="col-md-6">
                            <h5>Bill To:</h5>
                            <p class="mb-1"><strong>{{ $payment->user->name }}</strong></p>
                            <p class="mb-1">{{ $payment->user->email }}</p>
                            @if($payment->user->phone)
                                <p class="mb-1">Phone: {{ $payment->user->phone }}</p>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5>Payment Details:</h5>
                            <p class="mb-1"><strong>Status:</strong> 
                                <span class="badge bg-success">Paid</span>
                            </p>
                            <p class="mb-1"><strong>Transaction ID:</strong> {{ $payment->payment_id }}</p>
                            <p class="mb-1"><strong>Payment Date:</strong> {{ $payment->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th class="text-end">Amount (INR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>LMS Payment (Order #{{ $payment->order_id }})</td>
                                    <td class="text-end">₹{{ $payment->formatted_amount }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Subtotal</strong></td>
                                    <td class="text-end">₹{{ $payment->formatted_amount }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Tax (0%)</strong></td>
                                    <td class="text-end">₹0.00</td>
                                </tr>
                                <tr class="table-active">
                                    <td colspan="2" class="text-end"><strong>Total</strong></td>
                                    <td class="text-end"><strong>₹{{ $payment->formatted_amount }}</strong></td>
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Method -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Payment Method</h5>
                                    <p class="mb-1"><strong>Razorpay</strong></p>
                                    <p class="mb-0">Transaction ID: {{ $payment->payment_id }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Notes</h5>
                                    <p class="mb-0">Thank you for your payment. This is a computer generated invoice and does not require signature.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thank You -->
                    <div class="text-center mt-4">
                        <h5 class="text-primary">Thank You For Your Business!</h5>
                        <p>If you have any questions about this invoice, please contact<br>
                        {{ config('app.email') }}  {{ config('app.phone') }}</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3 no-print">
                <button onclick="window.print()" class="btn btn-primary me-2">
                    <i class="fas fa-print me-1"></i> Print Invoice
                </button>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Payments
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #invoice, #invoice * {
            visibility: visible;
        }
        #invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            box-shadow: none;
            border: none !important;
        }
        .no-print {
            display: none !important;
        }
        @page {
            size: auto;
            margin: 5mm;
        }
    }
    .table-active {
        background-color: rgba(0,0,0,.03) !important;
    }
</style>
@endsection