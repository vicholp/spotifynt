<?php

namespace App\Services;

use App\Models\Server;
use Illuminate\Support\Facades\Http;

/**
 * Class BeetsService.
 */
class BeetsService
{
    private Server $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function getAlbums(): array
    {
        return Http::get($this->server->path.'/album')->json()['albums'];
    }

    public function getTracksFromAlbum(string $id): array
    {
        return Http::get($this->server->path.'/item/query/album_id:'.$id)->json()['results'];
    }
}
