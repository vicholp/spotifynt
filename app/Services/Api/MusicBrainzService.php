<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Class MusicBrainzService.
 */
class MusicBrainzService
{
    private int $cache_time = 60 * 60 * 24 * 28; // 28 [days]
    private string $api_url = 'https://musicbrainz.org/ws/2';

    public function getRecording(string $id): array
    {
        $cache = Cache::get('mb_recording_'.$id);

        if ($cache) {
            return $cache;
        }

        $response = Http::get($this->api_url . '/recording/'.$id.'?inc=artist-credits+isrcs+annotation+tags+genres&fmt=json');

        if (!$response->ok())
        {
            throw new \Exception("Error Processing Request");
        }

        $json = $response->json();

        Cache::put('mb_recording_'.$id, $json, $this->cache_time);

        return $json;
    }

    public function getRelease(string $id): array
    {
        $cache = Cache::get('mb_release_'.$id);

        if ($cache) return $cache;

        $response = Http::get($this->api_url . '/release/'.$id.'?inc=artist-credits+labels+recordings+release-groups+media+discids+isrcs+annotation+tags+genres&fmt=json')->json();

        if (!$response->ok()) throw new \Exception("Error Processing Request");

        $json = $response->json();

        Cache::put('mb_release_'.$id, $json, $this->cache_time);

        return $json;
    }

    public function getReleaseGroup(string $id): array
    {
        $cache = Cache::get('mb_releasegroup_'.$id);

        if ($cache) {
            return $cache;
        }

        $response = Http::get($this->api_url . '/release-group/'.$id.'?inc=artist-credits+annotation+tags+genres&fmt=json')->json();

        if ($response->ok())
        {
            $json = $response->json();

            Cache::put('mb_releasegroup_'.$id, $json, $this->cache_time);

            return $json;
        }

        throw new \Exception("Error Processing Request");
    }

    public function getArtist(string $id): array
    {
        $cache = Cache::get('mb_artist_'.$id);

        if($cache){
            return $cache;
        }

        $response = Http::get($this->api_url . '/artist/'.$id.'?inc=aliases+annotation+tags+genres&fmt=json')->json();

        if ($response->ok())
        {
            $json = $response->json();

            Cache::put('mb_artist_'.$id, $json, $this->cache_time);

            return $json;
        }

        throw new \Exception("Error Processing Request");
    }
}
