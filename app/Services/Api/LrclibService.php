<?php

namespace App\Services\Api;

use App\Models\Recording;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class RecService.
 */
class LrclibService
{
    private ?string $lrclib_service_url = null;

    public function __construct()
    {
        $this->lrclib_service_url = config('services.lrclib_service_url');
    }

    public function getLyrics(Recording $recording): array|false
    {
        try {
            $artistName = $recording->tracks()->first()->release->artist->name;
            $trackName = $recording->tracks()->first()->title;

            Log::info('Lrclib service: getLyrics called', [
                'recording_id' => $recording->id,
                'artist_name' => $artistName,
                'track_name' => $trackName,
            ]);

            $response = Http::get('https://lrclib.net/api/get', [
                'artist_name' => $artistName,
                'track_name' => $trackName,
            ]);

            Log::info('Lrclib service: getLyrics response', [
                'recording_id' => $recording->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $lyrics = $response->json();

            return [
                'plainLyrics' => $lyrics['plainLyrics'] ?? null,
                'syncedLyrics' => $lyrics['syncedLyrics'] ?? null,
                'instrumental' => $lyrics['instrumental'] ?? false,
            ];
        } catch (\Exception $e) {
            Log::error('Lrclib service: getLyrics error', [
                'recording' => $recording,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
