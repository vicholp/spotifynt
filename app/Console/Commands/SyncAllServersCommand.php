<?php

namespace App\Console\Commands;

use App\Jobs\Synchronization\SyncServerJob;
use App\Models\Server;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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

        Log::debug("Found {$servers->count()} servers to synchronize");

        foreach ($servers as $server) {
            Log::debug("Dispatching SyncServerJob for server {$server->id}");
            SyncServerJob::dispatch($server);
        }

        return 0;
    }
}
