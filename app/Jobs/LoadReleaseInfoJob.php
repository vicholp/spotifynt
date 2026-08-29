<?php

namespace App\Jobs;

use App\Models\Release;
use App\Services\Api\MusicBrainzService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LoadReleaseInfoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Release $release,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MusicBrainzService $musicBrainzService): void
    {
        if (!$this->release->mb_id) {
            return;
        }

        $mbRelease = $musicBrainzService->getRelease($this->release->mb_id);

        $this->release->update([
            'date' => $mbRelease['date'] ?? null,
        ]);
    }
}
