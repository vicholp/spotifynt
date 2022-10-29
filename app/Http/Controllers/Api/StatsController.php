<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Stats\StorePlayedTrackRequest;
use App\Jobs\Stats\StorePlayedTrackJob;

class StatsController extends Controller
{
    public function storePlayedTrack(StorePlayedTrackRequest $request): string
    {
        $track = $request->track_id;
        $server = $request->server_id;
        $user = $request->user_id;
        $release = $request->release_id;

        StorePlayedTrackJob::dispatch($user, $server, $track, $release, time());

        return 'OK';
    }
}
