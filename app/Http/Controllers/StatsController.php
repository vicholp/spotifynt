<?php

namespace App\Http\Controllers;

use App\Jobs\Stats\StorePlayedTrackJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatsController extends Controller
{
    public function storePlayedTrack(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|integer',
            'server_id' => 'required|integer',
            'track_id' => 'required|integer',
        ]);

        StorePlayedTrackJob::dispatch(
            $request->integer('user_id'),
            $request->integer('server_id'),
            $request->integer('track_id'),
            Carbon::now(),
        )->onQueue('low');

        return response()->json([
            'status' => 'OK',
        ]);
    }
}
