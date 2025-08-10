<?php

namespace App\Services\Api;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class MusicBrainzService.
 */
class MusicBrainzService
{
    private ?string $apiUrl = null;

    public function __construct()
    {
        $this->apiUrl = config('services.mb_service_url');
    }

    public function getTrackFromRelease(string $releaseId, string $trackId): array|false
    {

        $release = $this->getRelease($releaseId);

        $medias = $release['media'];

        foreach ($medias as $media) {
            $tracks = $media['tracks'];

            foreach ($tracks as $track) {
                if ($track['id'] == $trackId) {

                    return $track;
                }
            }
        }

        return false;
    }

    public function getTrackFromRecording(string $releaseId, string $recordingId): array|false
    {

        $release = $this->getRelease($releaseId);

        $medias = $release['media'];

        foreach ($medias as $media) {
            $tracks = $media['tracks'];

            foreach ($tracks as $track) {
                if ($track['recording']['id'] == $recordingId) {

                    return $track;
                }
            }
        }

        return false;
    }

    public function getRecording(string $id): array
    {

        Log::debug("🔒 Querying to MusicBrainz recording {$id}");

        $response = $this->getHttp()->get($this->apiUrl.'ws/2/recording/'.$id.'?inc=artist-credits+isrcs+annotation+tags+genres+releases+release-groups&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();


        return $json; // @phpstan-ignore return.type
    }

    public function getRelease(string $id): array
    {


        Log::debug("🔒 Querying to MusicBrainz release {$id}");

        $response = $this->getHttp()->get($this->apiUrl.'ws/2/release/'.$id.'?inc=artist-credits+labels+recordings+release-groups+media+discids+isrcs+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();


        return $json; // @phpstan-ignore return.type
    }

    public function getReleaseGroup(string $id): array
    {


        Log::debug("🔒 Querying to MusicBrainz release group {$id}");

        $response = $this->getHttp()->get($this->apiUrl.'ws/2/release-group/'.$id.'?inc=artist-credits+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();


        return $json; // @phpstan-ignore return.type
    }

    public function getArtist(string $id): array
    {
        Log::debug("🔒 Querying to MusicBrainz artist {$id}");

        $response = $this->getHttp()->get($this->apiUrl.'ws/2/artist/'.$id.'?inc=aliases+annotation+tags+genres&fmt=json');

        if (!$response->ok()) {
            throw new \Exception('Error Processing Request'.$response->status());
        }

        $json = $response->json();


        return $json; // @phpstan-ignore return.type
    }

    private function getHttp(): PendingRequest
    {
        return Http::withHeaders(['User-Agent' => 'Spotifynt/dev (hello@vicho.dev)']);
    }
}
