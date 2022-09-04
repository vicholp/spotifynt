<?php

namespace App\Console\Commands;

use App\Jobs\Synchronization\SyncServerJob;
use App\Models\Server;
use App\Services\SynchronizationService;
use Illuminate\Console\Command;

class SyncAllServersCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'sync:all';

    /**
     * The console command description.
     */
    protected $description = 'Synchronize all servers';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $servers = Server::get();

        foreach ($servers as $server) {
            SyncServerJob::dispatch($server);
        }

        return 0;
    }
}
