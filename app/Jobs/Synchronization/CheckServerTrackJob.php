<?php

namespace App\Jobs\Synchronization;

use App\Models\ServerTrack;
use App\Services\SynchronizationService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckServerTrackJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Batchable;
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
        private ServerTrack $serverTrack,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new SynchronizationService())->checkServerTrack($this->serverTrack);
    }
}
