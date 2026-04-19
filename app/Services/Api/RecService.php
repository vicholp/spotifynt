<?php

namespace App\Services\Api;

use App\Models\Recording;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class RecService.
 */
class RecService
{
    private ?string $rec_service_url = null;

    public function __construct()
    {
        $this->rec_service_url = config('services.rec_service_url');
    }

    public function createRecording(Recording $recording): array|false
    {
        try {
            $file = $recording->files()->latest()->first();

            Log::info('Rec service: createRecording called', [
                'recording_id' => $recording->id,
                'file_url' => $file->path,
            ]);

            $response = Http::post($this->rec_service_url.'recordings', [
                'recording' => $recording->load('tracks', 'tracks.release'),
                'file_url' => $file->path,
            ]);

            if (!$response->ok()) {
                return false;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Rec service: createRecording error', [
                'recording' => $recording,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function recommendationForPlaylist(array $trackIds): array|false
    {
        try {
            Log::info('Rec service: recommendationForPlaylist called', [
                'track_ids' => $trackIds,
            ]);

            $response = Http::post($this->rec_service_url.'recommendations', [
                'track_ids' => $trackIds,
            ]);

            if (!$response->ok()) {
                return false;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Rec service: recommendationForPlaylist error', [
                'track_ids' => $trackIds,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
