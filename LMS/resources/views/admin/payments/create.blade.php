@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Create Payment</h4>
    </div>
    <div class="card-body">
        <form id="payment-form">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Amount (₹)</label>
                <input type="number" class="form-control" id="amount" name="amount" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary" id="pay-button">Pay Now</button>
        </form>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('payment-form').addEventListener('submit', function(e) {
    console.log(document.getElementById('amount').value);

    e.preventDefault();
    
    const amount = document.getElementById('amount').value;
    const button = document.getElementById('pay-button');
    button.disabled = true;
    button.textContent = 'Processing...';

    fetch("{{ route('admin.payments.create-order') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ amount: amount })
    })
    .then(response => response.json())
    .then(data => {
        const options = {
            key: "{{ config('services.razorpay.key') }}",
            amount: data.amount,
            currency: data.currency,
            name: "{{ config('app.name') }}",
            order_id: data.id,
            handler: function(response) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('admin.payments.verify') }}";
                
                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = "{{ csrf_token() }}";
                form.appendChild(token);

                const paymentId = document.createElement('input');
                paymentId.type = 'hidden';
                paymentId.name = 'razorpay_payment_id';
                paymentId.value = response.razorpay_payment_id;
                form.appendChild(paymentId);

                const orderId = document.createElement('input');
                orderId.type = 'hidden';
                orderId.name = 'razorpay_order_id';
                orderId.value = response.razorpay_order_id;
                form.appendChild(orderId);

                const signature = document.createElement('input');
                signature.type = 'hidden';
                signature.name = 'razorpay_signature';
                signature.value = response.razorpay_signature;
                form.appendChild(signature);

                document.body.appendChild(form);
                form.submit();
            },
            theme: {
                color: '#3399cc'
            }
        };
        
        const rzp = new Razorpay(options);
        rzp.open();
        button.disabled = false;
        button.textContent = 'Pay Now';
    })
    .catch(error => {
        console.error('Error:', error);
        button.disabled = false;
        button.textContent = 'Pay Now';
        alert('Payment failed. Please try again.');
    });
});
</script>
@endsection