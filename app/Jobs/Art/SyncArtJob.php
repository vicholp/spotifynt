<?php

namespace App\Jobs\Art;

use App\Models\Release;
use App\Models\Server;
use App\Services\Api\BeetsService;
use App\Services\ArtService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncArtJob implements ShouldQueue
{
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
        private Release $release,
        private ?Server $server
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
        $beetsService = null;

        if ($this->server) {
            $beetsService = new BeetsService($this->server);
        }

        (new ArtService())->syncArt($this->release, $beetsService);
    }
}
