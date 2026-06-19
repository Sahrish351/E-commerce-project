<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Show PayFast payment page
    public function payfast()
    {
        return view('frontend.payment.payfast');
    }

    // Process PayFast payment
    public function processPayfast(Request $request)
    {
        // PayFast integration logic here
        // For now, redirect to success
        return redirect()->route('payment.success')->with('success', 'Payment processed successfully!');
    }

    // Payment success
    public function success()
    {
        return view('frontend.payment.success');
    }

    // Payment cancel
    public function cancel()
    {
        return view('frontend.payment.cancel');
    }
}