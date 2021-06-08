<?php

namespace App\Listeners;

use App\Events\CompanyCreated;
use App\Events\DatabaseCreated;
use App\Tenant\Database\DatabaseManager;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCompanyDatabase
{

    private $database;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     * @throws Exception
     */
    public function handle(CompanyCreated $event)
    {
        $company = $event->company();

        if(!$this->database->createDatabase($company)){
            throw new Exception('Error Create database');
        }

        event(new DatabaseCreated($company));
    }
}
