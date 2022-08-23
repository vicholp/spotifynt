<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Class MusicBrainzService.
 */
class MusicBrainzService
{
    public function getRecording(string $id): array
    {
        return Cache::remember('mb_recording_'.$id, 60 * 60 * 24, function () use ($id) {
            dump(''.$id);
            sleep(1);

            return Http::get('https://musicbrainz.org/ws/2/recording/'.$id.'?inc=artist-credits+isrcs+annotation+tags+genres&fmt=json')->json();
        });
    }

    public function getRelese(string $id): array
    {
        return Cache::remember('mb_release_'.$id, 60 * 60 * 24, function () use ($id) {
            dump('.');

            return Http::get('https://musicbrainz.org/ws/2/release/'.$id.'?inc=artist-credits+labels+recordings+release-groups+media+discids+isrcs+annotation+tags+genres&fmt=json')->json();
        });
    }

    public function getReleaseGroup(string $id): array
    {
        return Cache::remember('mb_releasegroup_'.$id, 60 * 60 * 24, function () use ($id) {
            dump('.');

            return Http::get('https://musicbrainz.org/ws/2/release-group/'.$id.'?inc=artist-credits+annotation+tags+genres&fmt=json')->json();
        });
    }

    public function getArtist(string $id): array
    {
        return Cache::remember('mb_artist_'.$id, 60 * 60 * 24, function () use ($id) {
            dump('.');

            return Http::get('https://musicbrainz.org/ws/2/artist/'.$id.'?inc=aliases+annotation+tags+genres&fmt=json')->json();
        });
    }

    public function getArea(string $id): array
    {
        return Cache::remember('mb_area_'.$id, 60 * 60 * 24, function () use ($id) {
            dump('.');

            return Http::get('https://musicbrainz.org/ws/2/area/'.$id.'?inc=aliases+annotation+tags+genres&fmt=json')->json();
        });
    }
}
