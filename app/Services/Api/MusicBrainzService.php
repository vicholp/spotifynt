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
    private string $api_url = 'https://musicbrainz.org/ws/2/';

    public function getRecording(string $id): array
    {
        return Cache::remember('mb_recording_'.$id, $this->cache_time, function () use ($id) {
            sleep(1);

            return Http::get($this->api_url . '/recording/'.$id.'?inc=artist-credits+isrcs+annotation+tags+genres&fmt=json')->json();
        });
    }

    public function getRelease(string $id): array
    {
        return Cache::remember('mb_release_'.$id, $this->cache_time, function () use ($id) {
            return Http::get($this->api_url . '/release/'.$id.'?inc=artist-credits+labels+recordings+release-groups+media+discids+isrcs+annotation+tags+genres&fmt=json')->json();
        });
    }

    public function getReleaseGroup(string $id): array
    {
        return Cache::remember('mb_releasegroup_'.$id, $this->cache_time, function () use ($id) {
            return Http::get($this->api_url . '/release-group/'.$id.'?inc=artist-credits+annotation+tags+genres&fmt=json')->json();
        });
    }

    public function getArtist(string $id): array
    {
        return Cache::remember('mb_artist_'.$id, $this->cache_time, function () use ($id) {
            return Http::get($this->api_url . '/artist/'.$id.'?inc=aliases+annotation+tags+genres&fmt=json')->json();
        });
    }

    public function getArea(string $id): array
    {
        return Cache::remember('mb_area_'.$id, $this->cache_time, function () use ($id) {
            return Http::get($this->api_url . '/area/'.$id.'?inc=aliases+annotation+tags+genres&fmt=json')->json();
        });
    }
}
