<?php

namespace App\Jobs\Synchronization;

use App\Models\Server;
use App\Services\Api\BeetsService;
use App\Services\SynchronizationService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncAlbumFromBeetsJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Server $server,
        private string $mbId,
        private string $beetsAlbumId,
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
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        $beetsService = new BeetsService($this->server);

        (new SynchronizationService())->syncAlbumFromBeets(
            $beetsService,
            $this->server,
            $this->mbId,
            $this->beetsAlbumId
        );
    }
}
