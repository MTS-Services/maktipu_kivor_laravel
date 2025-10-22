<?php

namespace App\Listeners\Admin;

use App\Events\Admin\AdminUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogAdminActivity implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(AdminUpdated $event): void
    {
        Log::info('Admin updated', [
            'admin_id' => $event->admin->id,
            'changes' => $event->changes,
            'updated_at' => now(),
        ]);
    }
}