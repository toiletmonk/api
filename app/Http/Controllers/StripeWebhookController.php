<?php

namespace App\Http\Controllers;

use App\Events\PaymentFailed;
use App\Events\PaymentSucceded;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch(\UnexpectedValueException $e) {
            Log::error($e->getMessage());
            return response('Invalid payload.', 400);
        }

        $intent = $event->data->object;
        $user = User::find($intent->metadata->user_id ?? null);

        switch ($event->type) {
            case 'payment_intent.succeeded':
                event(new PaymentSucceded($user, $intent));
                break;
            case 'payment_intent.failed':
                event(new PaymentFailed($user, $intent));
                break;

            default:
                Log::error("Unsupported event type: " . $event->type);
        }
        return response('Webhook handled', 200);
    }
}
