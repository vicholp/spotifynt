<?php

namespace App\Jobs\Synchronization;

use App\Models\Server;
use App\Services\Api\BeetsService;
use App\Services\SynchronizationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncAlbumFromBeetsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private array $album,
        private Server $server,
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $beetsService = new BeetsService($this->server);

        (new SynchronizationService())->syncAlbumFromBeets($beetsService, $this->album, $this->server);
    }
}
