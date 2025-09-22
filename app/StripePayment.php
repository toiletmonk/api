<?php

namespace App;

use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePayment
{

    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }
    public function createIntent(int $amount, string $currency = 'USD', array $metadata = []): \Stripe\PaymentIntent
    {
        return PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency,
            'metadata' => $metadata,
        ]);
    }
}
