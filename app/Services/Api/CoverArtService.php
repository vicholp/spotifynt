<?php

namespace App\Services\Api;

use App\Models\Release;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class CoverArtService.
 */
class CoverArtService
{
    private ?string $covers_service_url = null;

    public function __construct()
    {
        $this->covers_service_url = config('services.covers_service_url');
    }

    public function getArt(Release $release): \GdImage|false
    {
        Log::info('Cover art service: getArt', [
            'release_id' => $release->id,
        ]);

        $url = $this->getArtFromCoverService($release);

        if (!$url) {
            return false;
        }

        $image = Http::get($url)->body();

        if (!$image) {
            return false;
        }

        return imagecreatefromstring($image);
    }

    private function getArtFromCoverService(Release $release): string|false
    {
        Log::info('Cover art service: getArtFromCoverService', [
            'release_id' => $release->id,
        ]);

        try {
            $response = Http::post($this->covers_service_url.'covers/album',[
                'artist_name' => $release->artist?->name ?? '',
                'album_name' => $release->title,
                'release_group_mbid' => $release->releaseGroup?->mb_id,
                'alpha_id' => $release->alpha_id,
            ]);

            if (!$response->ok()) {
                Log::error('Cover art service: getArtFromCoverService error', [
                    'release_id' => $release->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return false;
            }

            return $response->json()['full_size'];
        } catch (\Exception $e) {
            Log::error('Cover art service: getArtFromCoverService error', [
                'release_id' => $release->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
