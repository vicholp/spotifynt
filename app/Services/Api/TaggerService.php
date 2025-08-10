<?php

namespace App\Services\Api;

use App\Models\File;
use App\Models\Release;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class TaggerService.
 */
class TaggerService
{
    private ?string $tagger_service_url = null;

    public function __construct()
    {
        $this->tagger_service_url = config('services.tagger_service_url');
    }

    public function getTags(string $url): array|false
    {
        try {

            $response = Http::post($this->tagger_service_url.'files/tags', [
                'file_url' => $url,
            ]);

            if (!$response->ok()) {
                return false;
            }

            $tags = $response->json()['tags'] ?? [];

            return $tags;
        } catch (\Exception $e) {
            Log::error('TaggerService: getTags error', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);


            return false;
        }
    }

    public function getArt(Release $release): \GdImage|false
    {
        $url = Cache::remember('ca_'.$release->mb_id, $this->cache_time, function () use ($release) {
            $url = $this->getArtFromCoverService($release);

            if ($url) {
                return $url;
            }

            return false;
        });

        if (!$url) {
            return false;
        }

        $image = false;

        try {
            $image = Http::get($url)->body();
        } catch (ConnectionException $e) {
            Cache::forget('ca_'.$release->mb_id.'');
        }

        if (!$image) {
            return false;
        }

        return imagecreatefromstring($image);
    }

    private function getArtFromCoverService(Release $release): string|false
    {
        try {
            $response = Http::post($this->tagger_service_url.'covers/album',[
                'artist_name' => $release->artist?->name ?? '',
                'album_name' => $release->title,
                'release_group_mbid' => $release->releaseGroup->mb_id,
            ]);

            if (!$response->ok()) {
                return false;
            }

            return $response->json()['full_size'];
        } catch (\Exception $e) {
            return false;
        }
    }
}
