<?php

namespace App\Listeners\User;

use App\Events\User\UserUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogUserActivity implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(UserUpdated $event): void
    {
        Log::info('User updated', [
            'user_id' => $event->user->id,
            'changes' => $event->changes,
            'updated_at' => now(),
        ]);
    }
}