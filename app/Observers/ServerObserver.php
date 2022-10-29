<?php

namespace App\Observers;

use App\Models\Server;
use App\Services\SynchronizationService;

class ServerObserver
{
    /**
     * Handle the Server "created" event.
     *
     * @return void
     */
    public function created(Server $server)
    {
        // (new SynchronizationService())->syncServer($server);

        $server->users()->attach($server->owner_id);
    }

    /**
     * Handle the Server "updated" event.
     *
     * @return void
     */
    public function updated(Server $server)
    {
        // (new SynchronizationService())->syncServer($server);
    }

    /**
     * Handle the Server "deleted" event.
     *
     * @return void
     */
    public function deleted(Server $server)
    {
        //
    }

    /**
     * Handle the Server "restored" event.
     *
     * @return void
     */
    public function restored(Server $server)
    {
        //
    }

    /**
     * Handle the Server "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Server $server)
    {
        //
    }
}
