<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArtistSimpleCollection;
use App\Http\Resources\ReleaseSimpleCollection;
use App\Models\Artist;
use App\Models\Release;
use App\Models\Server;

class ServerRecommendationController extends Controller
{
    public function random(Server $server): array
    {
        $album_constrain = Release::with([]);

        return [
            'artists' => new ArtistSimpleCollection(Artist::limit(4)->inRandomOrder()->get()),
            'albums' => new ReleaseSimpleCollection(Release::limit(4)->inRandomOrder()->get()),
        ];
    }
}
