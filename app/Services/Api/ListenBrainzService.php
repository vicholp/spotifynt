<?php

namespace App\Services\Api;

use App\Models\Release;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * Class ListenBrainzService.
 */
class ListenBrainzService
{
    public string $base_url = 'https://api.listenbrainz.org';

    public function __construct(
        private User $user
    ) {
        //
    }

    private function getHttp(): PendingRequest
    {
        return Http::withHeaders(['Authorization' => "Token {$this->user->listenbrainz_token}"]);
    }

    public function submitListens(Track $track, Release $release, int $time): void
    {
        $token = config('services.listenbrainz.key');

        $this->getHttp()->post($this->base_url.'/1/submit-listens', [
            'listen_type' => 'single',
            'payload' => [
                [
                    'listened_at' => $time,
                    'track_metadata' => [
                        'artist_name' => $release->artist?->name,
                        'track_name' => $track->title,
                    ],
                ],
            ],
        ]);
    }
}
