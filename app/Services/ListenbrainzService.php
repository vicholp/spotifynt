<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Track;
use Illuminate\Support\Facades\Http;

/**
 * Class ListenbrainzService
 * @package App\Services
 */
class ListenbrainzService
{
    public const BASE_URL = 'https://api.listenbrainz.org';

    static public function submitListens(Track $track)
    {
        $token = config('services.listenbrainz.key');

        self::request($token)->post(self::BASE_URL."/1/submit-listens", [
            'listen_type' => 'single',
            'payload' => [
                [
                    "listened_at" => time(),
                    "track_metadata" => [
                        "artist_name"=> $track->artist()->name,
                        "track_name"=> $track->name,
                    ],
                ],
            ],
        ])->object();
    }

    static public function nowPlaying(Track $track)
    {
        $token = config('services.listenbrainz.key');

        self::request($token)->post(self::BASE_URL."/1/submit-listens", [
            'listen_type' => 'playing_now',
            'payload' => [
                [
                    "track_metadata" => [
                        "artist_name"=> $track->artist()->name,
                        "track_name"=> $track->name,
                    ],
                ],
            ],
        ])->object();
    }

    static public function validateToken(string $token)
    {
        self::getRequest($token, "/1/validate-token")->object();
    }

    static private function getRequest(string $token, string $endpoint)
    {
        return self::request($token)->get(self::BASE_URL.$endpoint);
    }

    static private function postRequest(string $token, string $endpoint)
    {
        return self::request($token)->post(self::BASE_URL.$endpoint);
    }

    static private function request($token)
    {
        return Http::withHeaders(['Authorization' => "Token {$token}"]);
    }
}
