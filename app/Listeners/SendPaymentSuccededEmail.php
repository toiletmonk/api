<?php

namespace App\Listeners;

use App\Events\PaymentSucceded;
use App\Mail\PaymentSuccededEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPaymentSuccededEmail implements ShouldQueue
{
    use InteractsWithQueue;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentSucceded $event): void
    {
        Mail::to($event->user->email)->send(new PaymentSuccededEmail($event->user, $event->intent));
    }
}
