<?php

namespace App\Services\Api;

use App\Models\File;
use App\Models\Release;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class AlphaPlugin.
 */
class AlphaPlugin
{
    private ?string $alpha_plugin_url = null;

    public function __construct()
    {
        $this->alpha_plugin_url = config('services.alpha_plugin_url');
    }

    public function query(string $query): array|false
    {
        try {
            $response = Http::post($this->alpha_plugin_url.'query', [
                'query' => $query,
                'exact' => false,
            ]);

            if (!$response->ok()) {
                return false;
            }

            $results = $response->json()['results'] ?? [];

            return $results;
        } catch (\Exception $e) {
            Log::error('Alpha plugin service: query error', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function getArtist(string $id): array|false
    {
        try {
            $response = Http::get($this->alpha_plugin_url.'artists/'.$id);

            if (!$response->ok()) {
                return false;
            }

            $artist = $response->json()['artist'] ?? [];

            return $artist;
        } catch (\Exception $e) {
            Log::error('Alpha plugin service: getArtist error', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function getAlbum(string $id): array|false
    {
        try {
            $response = Http::get($this->alpha_plugin_url.'albums/'.$id);

            if (!$response->ok()) {
                return false;
            }

            $album = $response->json()['album'] ?? [];

            return $album;
        } catch (\Exception $e) {
            Log::error('Alpha plugin service: getAlbum error', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function getSong(string $videoId): array|false
    {
        try {
            $response = Http::get($this->alpha_plugin_url.'songs/'.$videoId);

            if (!$response->ok()) {
                return false;
            }

            $song = $response->json()['song'] ?? [];

            return $song;
        } catch (\Exception $e) {
            Log::error('Alpha plugin service: getSong error', [
                'video_id' => $videoId,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function downloadAlbum(string $id): bool
    {
        try {
            $response = Http::post($this->alpha_plugin_url.'albums/'.$id.'/download', [
                'webhook_url' =>  "http://backend:8080/api/alpha/downloads/finish",
            ]);

            if (!$response->ok()) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Alpha plugin service: downloadAlbum error', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
