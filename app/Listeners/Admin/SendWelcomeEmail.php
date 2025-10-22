<?php

namespace App\Listeners\Admin;

use App\Events\Admin\AdminCreated;
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

    public function handle(AdminCreated $event): void
    {
        // Send welcome email logic here
        Log::info('Welcome email sent to: ' . $event->admin->email);

        // Example:
        // Mail::to($event->admin->email)->send(new WelcomeEmail($event->Admin));
    }

    public function failed(AdminCreated $event, \Throwable $exception): void
    {
        Log::error('Failed to send welcome email: ' . $exception->getMessage());
    }
}
