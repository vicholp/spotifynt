<?php

namespace App\Jobs;

use App\Jobs\Art\SyncArtJob;
use App\Models\Artist;
use App\Models\File;
use App\Models\Release;
use App\Models\ReleaseGroup;
use App\Models\Track;
use App\Services\Api\MusicBrainzService;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NewFileJob implements ShouldQueue
{
    use Batchable;
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected File $file,
        protected string $recordingMbId,
        protected string $releaseMbId,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MusicBrainzService $musicBrainzService): void
    {
        if ($this->batch()?->cancelled()) {
            // The batch has been cancelled...

            return;
        }

        $recordingMbId = $this->recordingMbId;
        $recording = $this->file->recording;
        $releaseMbId = $this->releaseMbId;

        $mbRelease = $musicBrainzService->getRelease($releaseMbId);

        $mbTrack = $musicBrainzService->getTrackFromRecording($releaseMbId, $recordingMbId);

        $mbReleaseGroup = $musicBrainzService->getReleaseGroup($mbRelease['release-group']['id']);

        $mbArtist = $musicBrainzService->getArtist($mbReleaseGroup['artist-credit'][0]['artist']['id']);

        $artist = Artist::updateOrCreate(
            ['mb_id' => $mbArtist['id']],
            [
                'name' => $mbArtist['name'],
            ]
        );

        $releaseGroup = ReleaseGroup::updateOrCreate(
            ['mb_id' => $mbReleaseGroup['id']],
            [
                'title' => $mbReleaseGroup['title'],
                'artist_id' => $artist->id,
            ]
        );

        $release = Release::updateOrCreate(
            ['mb_id' => $mbRelease['id']],
            [
                'title' => $mbRelease['title'],
                'release_group_id' => $releaseGroup->id,
            ]
        );

        Track::updateOrCreate(
            [
                'mb_id' => $mbTrack['id'],
            ],
            [
                'release_id' => $release->id,
                'recording_id' => $recording->id,
                'position' => $mbTrack['position'] ?? null,
                'title' => $mbTrack['title'] ?? null,
            ]
        );

        SyncArtJob::dispatch($release);
    }
}
