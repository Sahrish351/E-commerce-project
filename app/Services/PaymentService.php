<?php

namespace App\Services;

class PaymentService
{
    public function processCOD($order)
    {
        // Cash on Delivery logic
        return [
            'success' => true,
            'message' => 'Order placed successfully. Pay on delivery.'
        ];
    }

    public function processOnline($order)
    {
        // Integrate with Razorpay/Stripe/PayPal
        // For now, return mock response
        return [
            'success' => true,
            'payment_url' => route('payment.process', $order),
            'message' => 'Redirect to payment gateway'
        ];
    }
}