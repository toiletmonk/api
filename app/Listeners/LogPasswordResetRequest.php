<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogPasswordResetRequest implements ShouldQueue
{
    use InteractsWithQueue;
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(PasswordReset $event): void
    {
        Log::info('Password has been reset for user: ' . $event->user->email);
    }
}
