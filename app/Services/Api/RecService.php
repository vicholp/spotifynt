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

    public function storeEvents(array $events): bool
    {
        try {
            Log::info('Rec service: storeEvents called', [
                'events' => $events,
            ]);

            $response = Http::timeout(1)->post($this->rec_service_url.'events/batch', [
                'events' => array_map(fn($e) => [...$e, 'payload' => $e['payload'] ?: new \stdClass()], $events),
            ]);

            if (!$response->ok()) {
                Log::error('Rec service: storeEvents failed response', [
                    'events' => $events,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Rec service: storeEvents error', [
                'events' => $events,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function createRecording(Recording $recording): array|false
    {
        try {
            $file = $recording->files()->latest()->first();

            Log::info('Rec service: createRecording called', [
                'recording_id' => $recording->id,
                'file_url' => $file->path,
            ]);

            $response = Http::timeout(240)->post($this->rec_service_url.'recordings', [
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

    public function getRecording(int $recordingId): array|false
    {
        try {
            Log::info('Rec service: getRecording called', [
                'recording_id' => $recordingId,
            ]);

            $response = Http::timeout(120)->get($this->rec_service_url.'recordings/'.$recordingId);

            if (!$response->ok()) {
                return false;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Rec service: getRecording error', [
                'recording_id' => $recordingId,
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
