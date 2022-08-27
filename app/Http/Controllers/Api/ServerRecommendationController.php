<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArtistSimpleCollection;
use App\Http\Resources\ReleaseSimpleCollection;
use App\Models\Artist;
use App\Models\Release;
use App\Models\Server;
use App\Services\StatsService;
use Illuminate\Support\Facades\Auth;

class ServerRecommendationController extends Controller
{
    public function random(Server $server): array
    {
        $albums = Release::limit(20)->inRandomOrder()->get();
        $artists = Artist::limit(20)->inRandomOrder()->get();

        StatsService::newShowedReleases(Auth::user(), $albums);

        return [
            'artists' => new ArtistSimpleCollection($artists),
            'albums' => new ReleaseSimpleCollection($albums),
        ];
    }
}
