<?php

namespace App\Services;

use App\Jobs\Art\SyncArtJob;
use App\Jobs\Synchronization\CheckServerTracksJob;
use App\Jobs\Synchronization\SyncAlbumFromBeetsJob;
use App\Models\Artist;
use App\Models\Release;
use App\Models\ReleaseGroup;
use App\Models\Server;
use App\Models\ServerTrack;
use App\Models\Track;
use App\Services\Api\BeetsService;
use App\Services\Api\MusicBrainzService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;

/**
 * Class SynchronizationService.
 */
class SynchronizationService
{
    public function __construct(
        private MusicBrainzService $musicBrainzService = new MusicBrainzService()
    ) {
        //
    }

    private function getMissingTracks(Server $server): Collection
    {
        $beets = new BeetsService($server);
        $tracks = $server->tracks()->get();

        $missingTracks = collect();

        foreach ($tracks as $track) {
            if (!$beets->checkTrack($track->pivot->beets_id)) {
                $missingTracks->push($track->pivot->beets_id);
            }
        }

        return $missingTracks;
    }

    public function checkServerTracks(Server $server): void
    {
        $missingTracks = $this->getMissingTracks($server);

        foreach ($missingTracks->unique() as $trackId) {
            ServerTrack::whereBeetsId($trackId)->delete();
        }
    }

    public function recreateIndex(): void
    {
        Artist::removeAllFromSearch();
        Artist::makeAllSearchable();

        Release::removeAllFromSearch();
        Release::makeAllSearchable();

        Track::removeAllFromSearch();
        Track::makeAllSearchable();
    }

    public function syncServer(Server $server): void
    {
        $beets = new BeetsService($server);
        $beetsAlbums = $beets->getAlbums();

        $batch = [];

        foreach ($beetsAlbums as $album) {
            array_push($batch, new SyncAlbumFromBeetsJob($server, $album['mb_albumid'], $album['id']));
        }

        array_push($batch, new CheckServerTracksJob($server));

        Bus::batch($batch)->allowFailures()
            ->finally(function () {
                $this->recreateIndex();
            })
            ->dispatch();
    }

    public function syncAlbumFromBeets(BeetsService $beets, Server $server, string $mbReleaseId, string $beetsAlbumId): void
    {
        if (empty($mbReleaseId)) {
            return;
        }

        $release = $this->syncRelease($mbReleaseId);

        $beetsTracks = $beets->getTracksFromAlbum($beetsAlbumId);

        SyncArtJob::dispatch($release, $server)->onQueue('low');

        foreach ($beetsTracks as $beetsTrack) {
            $track = $this->syncTrack($release, $beetsTrack['mb_releasetrackid']);

            $this->attachTrackToServer($server, $track, $beetsTrack['path'], $beetsTrack['id']);
        }
    }

    private function attachTrackToServer(Server $server, Track $track, string $path, string $beetsId): void
    {
        // Migration purposes, a server can not have the same track twice
        if ($server->tracks()->where('track_id', $track->id)->count() > 1) {
            $server->tracks()->detach($track);
        }

        $server->tracks()->detach($track);

        $server->tracks()->attach($track, [
            'path' => $path,
            'beets_id' => $beetsId,
        ]);
    }

    public function syncTrack(Release $release, string $trackId): Track
    {
        $mbTrack = $this->musicBrainzService->getTrack($release->mb_release_id, $trackId);
        $recordingId = $mbTrack['recording']['id'];

        $recording = $this->musicBrainzService->getRecording($recordingId);

        $track = Track::whereMbRecordingId($recordingId)
            ->whereMbTrackId(null)->first();

        if ($track) {
            $track->update([
                'mb_track_id' => $mbTrack['id'],
                'mb_data' => json_encode($mbTrack),
            ]);


            return $track;
        }

        $track = Track::updateOrCreate([
            'mb_track_id' => $mbTrack['id'],
        ], [
            'title' => $recording['title'],
            'track_position' => $mbTrack['position'],
            'release_id' => $release->id,
            'mb_recording_id' => $recordingId,
            'mb_data' => json_encode($mbTrack),
        ]);

        return $track;
    }

    public function syncRelease(string $id): Release
    {
        $release = $this->musicBrainzService->getRelease($id);

        $releaseGroup = $this->syncReleaseGroup($release['release-group']['id']);

        return Release::updateOrCreate([
            'mb_release_id' => $release['id'],
        ], [
            'release_group_id' => $releaseGroup->id,
            'country' => $release['country'] ?? 'n/a',
            'title' => $release['title'],
            'mb_data' => json_encode($release),
        ]);
    }

    public function syncReleaseGroup(string $id): ReleaseGroup
    {
        $releaseGroup = $this->musicBrainzService->getReleaseGroup($id);

        $artist = $this->syncArtist($releaseGroup['artist-credit'][0]['artist']['id']);

        return ReleaseGroup::updateOrCreate([
            'mb_releasegroup_id' => $releaseGroup['id'],
        ], [
            'artist_id' => $artist->id,
            'title' => $releaseGroup['title'],
            'type' => $releaseGroup['primary-type'],
            'mb_data' => json_encode($releaseGroup),
        ]);
    }

    public function syncArtist(string $id): Artist
    {
        $artist = $this->musicBrainzService->getArtist($id);

        return Artist::updateOrCreate([
            'mb_artist_id' => $artist['id'],
        ], [
            'name' => $artist['name'],
            'type' => $artist['type'],
            'country' => $artist['area']['iso-3166-1-codes'][0][0] ?? 'n/a',
            'mb_data' => json_encode($artist),
        ]);
    }
}
