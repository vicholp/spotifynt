<?php

namespace App\Services;

use App\Jobs\Art\SyncArtJob;
use App\Jobs\Synchronization\SyncAlbumFromBeetsJob;
use App\Models\Artist;
use App\Models\Release;
use App\Models\ReleaseGroup;
use App\Models\Server;
use App\Models\Track;
use App\Services\Api\BeetsService;
use App\Services\Api\MusicBrainzService;

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

    public function syncServer(Server $server): void
    {
        $beets = new BeetsService($server);
        $beets_albums = $beets->getAlbums();

        foreach ($beets_albums as $album) {
            SyncAlbumFromBeetsJob::dispatch($album, $server);
        }
    }

    public function syncAlbumFromBeets(BeetsService $beets, array $album, Server $server): void
    {
        $release = $this->syncRelease($album['mb_albumid']);

        $beets_tracks = $beets->getTracksFromAlbum($album['id']);

        SyncArtJob::dispatch($release, $server)->onQueue('low');

        foreach ($beets_tracks as $beets_track) {
            $track = $this->syncTrack($release, $beets_track['mb_trackid']);
            $server->tracks()->attach($track, [
                'path' => $beets_track['path'],
                'beets_id' => $beets_track['id'],
            ]);
        }
    }

    public function syncTrack(Release $release, string $id): Track
    {
        $recording = $this->musicBrainzService->getRecording($id);

        return Track::updateOrCreate([
            'mb_recording_id' => $recording['id'],
        ], [
            'title' => $recording['title'],
            'release_id' => $release->id,
            'mb_data' => json_encode($recording),
        ]);
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
