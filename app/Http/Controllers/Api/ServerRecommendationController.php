<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReleaseSimpleCollection;
use App\Models\Server;
use App\Services\StatsService;
use Illuminate\Support\Facades\Auth;

class ServerRecommendationController extends Controller
{
    public function random(Server $server): array
    {
        $albums = $server->releases()->limit(6)->inRandomOrder()->get();

        StatsService::newShowedReleases(Auth::user(), $albums, 'random');  // @phpstan-ignore-line

        return [
            'albums' => new ReleaseSimpleCollection($albums),
        ];
    }
}
