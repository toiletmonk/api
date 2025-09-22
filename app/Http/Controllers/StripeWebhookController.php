<?php

namespace App\Http\Controllers;

use App\Events\PaymentFailed;
use App\Events\PaymentSucceded;
use App\Models\User;
use App\Services\StripeWebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    protected $webhookService;
    public function __construct(StripeWebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }
    public function handleWebhook(Request $request)
    {
        $this->webhookService->process($request);

        return response('Webhook handled', 200);
    }
}
