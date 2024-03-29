<?php

namespace App\Services\Api;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Class MusicBrainzService.
 */
class MusicBrainzService
{
    private string $api_url = 'https://musicbrainz.org/ws/2';

    private function getHttp(): PendingRequest
    {
        sleep(1); // sleep 1 second to avoid exceeding the rate limit of the API

        return Http::withHeaders(['User-Agent' => 'Spotifynt/dev (hello@vicho.dev)']);
    }

    public function getTrack(string $releaseId, string $trackId): array|false
    {
        $cache = Cache::get('mb_track_'.$trackId);

        if ($cache) {
            return $cache;
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
            return $cache;
        }

        $response = $this->getHttp()->get($this->api_url.'/recording/'.$id.'?inc=artist-credits+isrcs+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();

        Cache::put('mb_recording_'.$id, $json);

        return $json;
    }

    public function getRelease(string $id): array
    {
        $cache = Cache::get('mb_release_'.$id);

        if ($cache) {
            return $cache;
        }

        $response = $this->getHttp()->get($this->api_url.'/release/'.$id.'?inc=artist-credits+labels+recordings+release-groups+media+discids+isrcs+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();

        Cache::put('mb_release_'.$id, $json);

        return $json;
    }

    public function getReleaseGroup(string $id): array
    {
        $cache = Cache::get('mb_releasegroup_'.$id);

        if ($cache) {
            return $cache;
        }

        $response = $this->getHttp()->get($this->api_url.'/release-group/'.$id.'?inc=artist-credits+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();

        Cache::put('mb_releasegroup_'.$id, $json);

        return $json;
    }

    public function getArtist(string $id): array
    {
        $cache = Cache::get('mb_artist_'.$id);

        if ($cache) {
            return $cache;
        }

        $response = $this->getHttp()->get($this->api_url.'/artist/'.$id.'?inc=aliases+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();

        Cache::put('mb_artist_'.$id, $json);

        return $json;
    }
}
