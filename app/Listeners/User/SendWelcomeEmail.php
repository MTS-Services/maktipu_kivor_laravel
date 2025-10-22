<?php

namespace App\Listeners\User;

use App\Events\User\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(UserCreated $event): void
    {
        // Send welcome email logic here
        Log::info('Welcome email sent to: ' . $event->user->email);
        
        // Example:
        // Mail::to($event->user->email)->send(new WelcomeEmail($event->user));
    }

    public function failed(UserCreated $event, \Throwable $exception): void
    {
        Log::error('Failed to send welcome email: ' . $exception->getMessage());
    }
}