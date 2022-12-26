<?php

namespace App\Services\Api;

use App\Models\Server;
use Illuminate\Http\Client\Response;
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

    public function getAlbumsByAddedDate(): array
    {
        return Http::get($this->server->path.'/album/query/added-')->json();
    }

    public function getAlbumQuery(string $q): array
    {
        return Http::get($this->server->path.'/album/query/'.$q)->json();
    }

    public function getTracksFromAlbum(string $id): array
    {
        return Http::get($this->server->path.'/item/query/album_id:'.$id)->json()['results'];
    }

    public function getArt(string $id): Response
    {
        return Http::get($this->server->path.'/album/'.$id.'/art');
    }
}
