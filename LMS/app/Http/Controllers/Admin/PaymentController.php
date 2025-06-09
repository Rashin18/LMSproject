<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        return view('admin.payments.create');
    }

    public function createOrder(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1|max:100000'
    ]);

    try {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $amountInPaise = $request->amount * 100;

        $order = $api->order->create([
            'receipt' => 'order_' . time(),
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'payment_capture' => 1,
            'transfers' => [
                [
                    'account' => 'acc_QdpKltwih1aHQW',
                    'amount' => $amountInPaise / 2,
                    'currency' => 'INR',
                    'notes' => [
                        'branch' => 'Acme Corp Bangalore North',
                        'name' => 'Gaurav Kumar'
                    ],
                    'linked_account_notes' => ['branch'],
                    'on_hold' => false,
                    'on_hold_until' => now()->addMinutes(10)->timestamp // Example hold time
                ]
                
            ]
        ]);

        Payment::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'status' => 'pending'
        ]);

        return response()->json([
            'id' => $order->id,
            'amount' => $order->amount,
            'currency' => $order->currency
        ]);

    } catch (\Exception $e) {
        Log::error('Order creation with transfers failed: ' . $e->getMessage());
        return response()->json(['error' => 'Payment failed'], 500);
    }
}


    public function verifyPayment(Request $request)
    {
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            Payment::where('order_id', $request->razorpay_order_id)->update([
                 
                'payment_id' => $request->razorpay_payment_id,
                'status' => 'completed'
            ]);

            return redirect()->route('admin.payments.index')
                   ->with('success', 'Payment successful!');

        } catch (\Exception $e) {
            Log::error('Payment verification failed: '.$e->getMessage());
            return back()->with('error', 'Payment verification failed');
        }
    }

    public function show(Payment $payment)
    {
        abort_if($payment->user_id !== auth()->id(), 403);
        return view('admin.payments.show', compact('payment'));
    }

    public function invoice(Payment $payment)
    {
        abort_if($payment->user_id !== auth()->id() || $payment->status !== 'completed', 403);
        return view('admin.payments.invoice', compact('payment'));
    }
}