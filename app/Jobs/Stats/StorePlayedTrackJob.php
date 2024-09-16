<?php

namespace App\Jobs\Stats;

use App\Models\Server;
use App\Models\Track;
use App\Models\User;
use App\Services\StatsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class StorePlayedTrackJob implements ShouldQueue
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
        public int $userId,
        public int $serverId,
        public int $trackId,
        public Carbon $time
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        StatsService $statsService
    ) {
        $statsService->storePlayedTrack(
            User::findOrFail($this->userId),
            Server::findOrFail($this->serverId),
            Track::findOrFail($this->trackId),
            $this->time
        );
    }
}
