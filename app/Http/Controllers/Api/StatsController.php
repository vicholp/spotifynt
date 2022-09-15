<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlayedTrackStat;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function playedTrack(Request $request): string
    {
        $track = $request->track_id;
        $server = $request->server_id;
        $user = $request->user_id;

        PlayedTrackStat::create([
            'track_id' => $track,
            'server_id' => $server,
            'user_id' => $user,
        ]);

        return 'OK';
    }

    public function skippedTrack(Request $request): string
    {
        $track = $request->track_id;
        $server = $request->server_id;
        $user = $request->user_id;

        PlayedTrackStat::create([
            'track_id' => $track,
            'server_id' => $server,
            'user_id' => $user,
        ]);

        return 'OK';
    }
}
