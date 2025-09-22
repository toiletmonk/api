<?php

namespace App\Http\Controllers;

use App\Events\PurchaseMade;
use App\StripePayment;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{

    protected $stripe;
    public function __construct(StripePayment $stripe)
    {
        $this->stripe = $stripe;
    }

    public function createIntent(Request $request)
    {
        $validated = $request->validated();

        $amount = (int) $validated['amount'];

        $intent = $this->stripe->createIntent(
            amount: $amount,
            currency: 'usd',
            metadata: [
                'user_id'=>auth()->id(),
            ]
        );

        $user = auth()->user();

        if ($user) {
            event(new PurchaseMade($user, $amount));
        }

        return response()->json([
            'client_secret' => $intent->client_secret,
        ]);
    }
}
