<?php

namespace App\Providers;

use App\Events\CompanyCreated;
use App\Events\DatabaseCreated;
use App\Listeners\CreateCompanyDatabase;
use App\Listeners\RunMigrationsTenant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CompanyCreated::class => [
            CreateCompanyDatabase::class,
        ],
        DatabaseCreated::class => [
            RunMigrationsTenant::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
