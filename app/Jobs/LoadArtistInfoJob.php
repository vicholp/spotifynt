<?php

namespace App\Jobs;

use App\Models\Artist;
use App\Models\File;
use App\Services\Api\MusicBrainzService;
use App\Services\Api\TaggerService;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LoadArtistInfoJob implements ShouldQueue
{
    use Batchable;
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Artist $artist,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MusicBrainzService $musicBrainzService): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        if ($this->artist->mb_id === null) {
            Log::warning("Artist {$this->artist->name} has no MB ID, skipping LoadArtistInfoJob.");

            return;
        }

        $artistData = $musicBrainzService->getArtist($this->artist->mb_id, ['release-groups']);

        $this->artist->update([
            'country' => $artistData['area']['name'] ?? null,
        ]);

        foreach ($artistData['release-groups'] as $releaseGroupData) {
            $this->artist->releaseGroups()->updateOrCreate([
                'mb_id' => $releaseGroupData['id'],
            ], [
                'title' => $releaseGroupData['title'],
                'primary_type' => $releaseGroupData['primary-type'] ?? null,
                'secondary_types' => $releaseGroupData['secondary-types'] ?? null,
            ]);
        }
    }
}
