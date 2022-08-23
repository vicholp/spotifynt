<?php

namespace App\Services;

use App\Models\Artist;
use App\Models\Release;
use App\Models\ReleaseGroup;
use App\Models\Server;
use App\Models\Track;

/**
 * Class SynchronizationService.
 */
class SynchronizationService
{
    public function syncServer(Server $server): void
    {
        $beets = new BeetsService($server);
        $albums = $beets->getAlbums();

        foreach ($albums as $album) {
            $release = $this->syncRelease($album['mb_albumid']);

            $tracks = $beets->getTracksFromAlbum($album['id']);

            foreach ($tracks as $track_s) {
                $track = $this->syncTrack($release, $track_s['mb_trackid']);
                $server->tracks()->attach($track, [
                    'path' => $track_s['path'],
                    'beets_id' => $track_s['id'],
                ]);
            }
        }
    }

    public function syncArt(Release $release): void
    {
        $image = (new CoverArtService())->getFront($release->mb_release_id);
    }

    public function syncTrack(Release $release, string $id): Track
    {
        $recording = (new MusicBrainzService())->getRecording($id);

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
        $release = (new MusicBrainzService())->getRelese($id);

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
        $releaseGroup = (new MusicBrainzService())->getReleaseGroup($id);

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
        $artist = (new MusicBrainzService())->getArtist($id);

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
