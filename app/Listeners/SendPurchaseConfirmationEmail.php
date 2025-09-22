<?php

namespace App\Listeners;

use App\Events\PurchaseMade;
use App\Mail\ConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPurchaseConfirmationEmail implements ShouldQueue
{
    use InteractsWithQueue;
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(PurchaseMade $event): void
    {
        Mail::to($event->user->email)->send(new ConfirmationMail($event->user, $event->amount));
    }
}
