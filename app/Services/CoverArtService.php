<?php

namespace App\Services;

use CoverArtArchive\Client;
use CoverArtArchive\Repository\ReleaseRepository;
use Illuminate\Support\Facades\Cache;

/**
 * Class CoverArtService.
 */
class CoverArtService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getFront(string $id): int
    {
        return Cache::remember('ca_'.$id.'_front', 60 * 60 * 24, function () use ($id) {
            return (new ReleaseRepository($this->client))->coverArtFront($id);
        });
    }
}
