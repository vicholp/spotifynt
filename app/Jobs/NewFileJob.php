<?php

namespace App\Jobs;

use App\Jobs\Art\SyncArtJob;
use App\Models\Artist;
use App\Models\File;
use App\Models\Recording;
use App\Models\Release;
use App\Models\ReleaseGroup;
use App\Models\Track;
use App\Services\Api\MusicBrainzService;
use App\Services\Api\TaggerService;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NewFileJob implements ShouldQueue
{
    use Batchable;
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected File $file,
        protected ?string $recordingMbId,
        protected string $releaseMbId,
        protected ?string $trackId,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MusicBrainzService $musicBrainzService, TaggerService $taggerService): void
    {
        if ($this->batch()?->cancelled()) {
            // The batch has been cancelled...

            return;
        }

        $recordingMbId = $this->recordingMbId;
        $releaseMbId = $this->releaseMbId;
        $trackId = $this->trackId;

        $mbRelease = $musicBrainzService->getRelease($releaseMbId);

        if ($trackId) {
            $mbTrack = $musicBrainzService->getTrackFromRelease($releaseMbId, $trackId);
            $mbRecording = $musicBrainzService->getRecording($mbTrack['recording']['id']);
        } else {
            $mbTrack = $musicBrainzService->getTrackFromRecording($releaseMbId, $recordingMbId);
            $mbRecording = $musicBrainzService->getRecording($recordingMbId);
        }

        if (empty($mbTrack) || empty($mbRecording)) {
            Log::error('NewFileJob: No track or recording found for release ID: '.$releaseMbId);

            return;
        }

        $mbReleaseGroup = $musicBrainzService->getReleaseGroup($mbRelease['release-group']['id']);

        $mbArtist = $musicBrainzService->getArtist($mbReleaseGroup['artist-credit'][0]['artist']['id']);

        $recording = Recording::updateOrCreate(
            ['mb_id' => $mbRecording['id']],
            ['title' => $mbRecording['title']]
        );

        $this->file->update([
            'recording_id' => $recording->id,
        ]);

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

        LoadFileInfoJob::dispatch($this->file);

        LoadArtistInfoJob::dispatch($artist);

        LoadReleaseInfoJob::dispatch($release);

        LoadRecordingLyricsJob::dispatch($recording);

        LoadRecordingRecJob::dispatch($recording);
    }
}
