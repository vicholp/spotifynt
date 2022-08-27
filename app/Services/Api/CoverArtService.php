<?php

namespace App\Services\Api;

use App\Models\Release;
use GdImage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Class CoverArtService.
 */
class CoverArtService
{
    private string $itunes_url = 'http://itunes.apple.com/';
    private string $cover_art_archive_url = 'https://coverartarchive.org/';

    private int $cache_time = 60 * 60 * 24 * 28; // 28 [days]

    public function getArt(Release $release): GdImage|false
    {
        $url = Cache::remember('ca_'.$release->mb_release_id.'_url', $this->cache_time, function () use ($release) {
            $url = $this->getArtFromCoverArtArchive($release->mb_release_id);
            if ($url) {
                return $url;
            }

            $url = $this->getArtFromItunes($release->title, $release->artist?->name ?? '');
            if ($url) {
                return $url;
            }

            return false;
        });

        if (!$url) {
            return false;
        }

        $image = Http::get($url)->body();

        if (!$image) {
            return false;
        }

        return imagecreatefromstring($image);
    }

    private function getArtFromCoverArtArchive(string $id): string|false
    {
        $response = Http::get($this->cover_art_archive_url . 'release/'.$id);

        if (!$response->ok()) {
            return false;
        }

        return $response->json()['images'][0]['image'];
    }

    private function getArtFromItunes(string $release, string $artist): string|false
    {
        $response = Http::get($this->itunes_url . 'search?term=' . urlencode($release) . '+' . urlencode($artist));

        if (!$response->ok()) {
            return false;
        }

        return $response->json()['results'][0]['artworkUrl100'];

    }
}
