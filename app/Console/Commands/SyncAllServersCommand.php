<?php

namespace App\Console\Commands;

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
            (new SynchronizationService())->syncServer($server);
        }

        return 0;
    }
}
