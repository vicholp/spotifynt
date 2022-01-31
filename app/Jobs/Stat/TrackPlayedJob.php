<?php

namespace App\Jobs\Stat;

use App\Models\PlayedTrackStat;
use App\Models\Track;
use App\Services\ListenbrainzService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackPlayedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $track_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $track_id)
    {
        $this->track_id = $track_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        PlayedTrackStat::create([
            'track_id' => $this->track_id,
        ]);

        ListenbrainzService::submitListens(Track::find($this->track_id));
    }
}
