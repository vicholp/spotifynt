<?php

namespace App\Jobs;

use App\Models\Release;
use App\Services\ArtService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ReloadArtJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Release $release)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ArtService $artService): void
    {
        $this->release->arts()->delete();

        $artService->syncArt($this->release);
    }
}
