<?php

namespace App\Services;

use App\Jobs\Art\SyncArtJob;
use App\Jobs\Synchronization\CheckServerTrackJob;
use App\Jobs\Synchronization\CheckServerTracksJob;
use App\Jobs\Synchronization\SyncAlbumFromBeetsJob;
use App\Jobs\Synchronization\SyncServerTracksJob;
use App\Models\Artist;
use App\Models\ArtistServer;
use App\Models\Release;
use App\Models\ReleaseGroup;
use App\Models\ReleaseGroupServer;
use App\Models\ReleaseServer;
use App\Models\Server;
use App\Models\ServerTrack;
use App\Models\Track;
use App\Services\Api\BeetsService;
use App\Services\Api\MusicBrainzService;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

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

    /**
     * Check if a track still exists on the server.
     * If not, remove the relation.
     */
    public function checkServerTrack(ServerTrack $serverTrack): void
    {
        Log::info('🔍 Checking track '.$serverTrack->beets_id.' of server '.$serverTrack->server->name);

        $beets = new BeetsService($serverTrack->server);

        if (!$beets->checkTrack($serverTrack->beets_id)) {
            Log::info('🔍 Track not found, removing relation');

            ServerTrack::whereServerId($serverTrack->server_id)
                ->whereBeetsId($serverTrack->beets_id)
                ->delete();
        }

        Log::info('🔍 Track found');
    }

    public function syncServerTracks(Server $server): void
    {
        Log::info('🔍 Syncing tracks of server '.$server->name);

        ReleaseServer::whereServerId($server->id)->delete();
        ReleaseGroupServer::whereServerId($server->id)->delete();
        ArtistServer::whereServerId($server->id)->delete();

        $tracks = $server->tracks;

        Log::info('🔍 Syncing '.count($tracks).' tracks');

        foreach ($tracks as $track) {
            $server->releases()->syncWithoutDetaching($track->release);
            $server->releaseGroups()->syncWithoutDetaching($track->release->releaseGroup);
            $server->artists()->syncWithoutDetaching($track->release->releaseGroup->artist);
        }

        Log::info('🔍 Synced '.count($tracks).' tracks');
    }

    /**
     * Check if all tracks still exists on the server.
     */
    public function checkServerTracks(Server $server): void
    {
        Log::info('🔍 Checking tracks of server '.$server->name);
        $bus = collect();

        foreach ($server->tracks as $track) {
            $bus->push(new CheckServerTrackJob($track->pivot)); // @phpstan-ignore-line
        }

        $busCount = count($bus);

        Log::info("🔍 Checking {$busCount}' tracks");

        Bus::batch($bus)->allowFailures()->dispatch();
    }

    public function recreateIndex(): void
    {
        // Artist::removeAllFromSearch();
        // Artist::makeAllSearchable();

        // Release::removeAllFromSearch();
        // Release::makeAllSearchable();

        // Track::removeAllFromSearch();
        // Track::makeAllSearchable();
    }

    public function syncServer(Server $server): void
    {
        Log::info('🔍 Syncing server '.$server->id);

        $beets = new BeetsService($server);
        $beetsAlbums = $beets->getAlbums();

        $batch = [];

        foreach ($beetsAlbums as $album) {
            array_push($batch, new SyncAlbumFromBeetsJob($server, $album['mb_albumid'], $album['id']));
        }

        $batchCount = count($batch);

        Log::info("🔍 Syncing {$batchCount} albums from server");

        Bus::batch($batch)->allowFailures()->finally(function () use ($server) {
            Log::info("🔍 Ending sync of server {$server->id}");

            Bus::chain([
                new CheckServerTracksJob($server),
                new SyncServerTracksJob($server),
            ])->dispatch();
        })->dispatch();
    }

    public function syncAlbumFromBeets(
        BeetsService $beets,
        Server $server,
        string $mbReleaseId,
        string $beetsAlbumId
    ): void {
        if (empty($mbReleaseId)) {
            return;
        }

        Log::debug("🔍 Syncing album {$mbReleaseId} from server {$server->id}");

        $release = $this->syncRelease($mbReleaseId);

        $beetsTracks = $beets->getTracksFromAlbum($beetsAlbumId);

        SyncArtJob::dispatch($release, $server)->onQueue('low');

        Log::debug("🔍 Syncing {$release->title} with {$release->tracks->count()} tracks");

        foreach ($beetsTracks as $beetsTrack) {
            $track = $this->syncTrack($release, $beetsTrack['mb_releasetrackid']);

            if (!$track) {
                continue;
            }

            $this->attachTrackToServer($server, $track, $beetsTrack['path'], $beetsTrack['id']);
        }

        Log::debug("🔍 Synced {$release->title} with {$release->tracks->count()} tracks");
    }

    public function syncTrack(Release $release, string $trackId): Track|false
    {
        $mbTrack = $this->musicBrainzService->getTrack($release->mb_release_id, $trackId);

        if (!$mbTrack) {
            Log::error("🔥 Track not found {$trackId}");

            return false;
        }

        $recording = $this->musicBrainzService->getRecording($mbTrack['recording']['id']);

        $track = Track::updateOrCreate([
            'mb_track_id' => $mbTrack['id'],
        ], [
            'title' => $recording['title'],
            'track_position' => $mbTrack['position'],
            'release_id' => $release->id,
            'mb_recording_id' => $mbTrack['recording']['id'],
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

        Log::debug("🔍 Syncing release group {$releaseGroup['title']}");

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

        Log::debug("🔍 Syncing artist {$artist['name']}");

        return Artist::updateOrCreate([
            'mb_artist_id' => $artist['id'],
        ], [
            'name' => $artist['name'],
            'type' => $artist['type'],
            'country' => $artist['area']['iso-3166-1-codes'][0] ?? 'n/a',
            'mb_data' => json_encode($artist),
        ]);
    }

    private function attachTrackToServer(Server $server, Track $track, string $path, string $beetsId): void
    {
        $server->tracks()->detach($track);

        $server->tracks()->attach($track, [
            'path' => $path,
            'beets_id' => $beetsId,
        ]);
    }
}
