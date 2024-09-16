<?php

namespace App\Services\Api;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class MusicBrainzService.
 */
class MusicBrainzService
{
    private string $apiUrl = 'https://musicbrainz.org/ws/2';

    public function __construct()
    {
        //
    }

    public function getTrack(string $releaseId, string $trackId): array|false
    {
        $cache = Cache::get('mb_track_'.$trackId);

        if ($cache) {
            return $cache; // @phpstan-ignore return.type
        }

        $release = $this->getRelease($releaseId);

        $medias = $release['media'];

        foreach ($medias as $media) {
            $tracks = $media['tracks'];

            foreach ($tracks as $track) {
                if ($track['id'] == $trackId) {
                    Cache::put('mb_track_'.$trackId, $track);

                    return $track;
                }
            }
        }

        return false;
    }

    public function getRecording(string $id): array
    {
        $cache = Cache::get('mb_recording_'.$id);

        if ($cache) {
            return $cache; // @phpstan-ignore return.type
        }

        Log::debug("🔒 Querying to MusicBrainz recording {$id}");

        $response = $this->getHttp()->get($this->apiUrl.'/recording/'.$id.'?inc=artist-credits+isrcs+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();

        Cache::put('mb_recording_'.$id, $json);

        return $json; // @phpstan-ignore return.type
    }

    public function getRelease(string $id): array
    {
        $cache = Cache::get('mb_release_'.$id);

        if ($cache) {
            return $cache; // @phpstan-ignore return.type
        }

        Log::debug("🔒 Querying to MusicBrainz release {$id}");

        $response = $this->getHttp()->get($this->apiUrl.'/release/'.$id.'?inc=artist-credits+labels+recordings+release-groups+media+discids+isrcs+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();

        Cache::put('mb_release_'.$id, $json);

        return $json; // @phpstan-ignore return.type
    }

    public function getReleaseGroup(string $id): array
    {
        $cache = Cache::get('mb_releasegroup_'.$id);

        if ($cache) {
            return $cache; // @phpstan-ignore return.type
        }

        Log::debug("🔒 Querying to MusicBrainz release group {$id}");

        $response = $this->getHttp()->get($this->apiUrl.'/release-group/'.$id.'?inc=artist-credits+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();

        Cache::put('mb_releasegroup_'.$id, $json);

        return $json; // @phpstan-ignore return.type
    }

    public function getArtist(string $id): array
    {
        $cache = Cache::get('mb_artist_'.$id);

        if ($cache) {
            return $cache; // @phpstan-ignore return.type
        }

        Log::debug("🔒 Querying to MusicBrainz artist {$id}");

        $response = $this->getHttp()->get($this->apiUrl.'/artist/'.$id.'?inc=aliases+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();

        Cache::put('mb_artist_'.$id, $json);

        return $json; // @phpstan-ignore return.type
    }

    private function getHttp(): PendingRequest
    {
        Log::debug('🔒 Querying to MusicBrainz. Sleeping for 1 second');

        sleep(1);

        return Http::withHeaders(['User-Agent' => 'Spotifynt/dev (hello@vicho.dev)']);
    }
}
