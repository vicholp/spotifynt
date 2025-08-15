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

    public function getInfo(string $url): array|false
    {
        try {

            $response = Http::post($this->tagger_service_url.'files/info', [
                'file_url' => $url,
            ]);

            if (!$response->ok()) {
                return false;
            }

            $info = $response->json() ?? [];

            return $info;
        } catch (\Exception $e) {
            Log::error('TaggerService: getInfo error', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);


            return false;
        }
    }
}
