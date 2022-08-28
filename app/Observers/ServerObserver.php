<?php

namespace App\Observers;

use App\Models\Server;
use App\Services\SynchronizationService;

class ServerObserver
{
    /**
     * Handle the Server "created" event.
     *
     * @param  \App\Models\Server  $server
     * @return void
     */
    public function created(Server $server)
    {
        (new SynchronizationService)->syncServer($server);
    }

    /**
     * Handle the Server "updated" event.
     *
     * @param  \App\Models\Server  $server
     * @return void
     */
    public function updated(Server $server)
    {
        (new SynchronizationService)->syncServer($server);
    }

    /**
     * Handle the Server "deleted" event.
     *
     * @param  \App\Models\Server  $server
     * @return void
     */
    public function deleted(Server $server)
    {
        //
    }

    /**
     * Handle the Server "restored" event.
     *
     * @param  \App\Models\Server  $server
     * @return void
     */
    public function restored(Server $server)
    {
        //
    }

    /**
     * Handle the Server "force deleted" event.
     *
     * @param  \App\Models\Server  $server
     * @return void
     */
    public function forceDeleted(Server $server)
    {
        //
    }
}
