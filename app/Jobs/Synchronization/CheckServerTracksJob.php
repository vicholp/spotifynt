<?php

namespace App\Jobs\Synchronization;

use App\Models\Server;
use App\Services\SynchronizationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckServerTracksJob implements ShouldQueue
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
     */
    public function __construct(
        private Server $server
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new SynchronizationService())->checkServerTracks($this->server);
    }
}
