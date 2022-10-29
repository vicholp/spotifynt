<?php

namespace App\Jobs\Stats;

use App\Models\Release;
use App\Models\Server;
use App\Models\Track;
use App\Models\User;
use App\Services\StatsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StorePlayedTrackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private int $user,
        private int $server,
        private int $track,
        private int $release,
        private int $time
    ){
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new StatsService)->storePlayedTrack(
            User::findOrFail($this->user),
            Server::findOrFail($this->server),
            Track::findOrFail($this->track),
            Release::findOrFail($this->release),
            $this->time
        );
    }
}
