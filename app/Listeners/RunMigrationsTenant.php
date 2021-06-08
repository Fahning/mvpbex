<?php

namespace App\Listeners;

use App\Events\DatabaseCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class RunMigrationsTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return bool
     */
    public function handle(DatabaseCreated $event)
    {
        $company = $event->company();

        $migrations = Artisan::call('tenants:migrations', [
            'id' => $company->id,
        ]);

        return $migrations === 0;
    }
}
