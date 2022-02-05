<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Stat\NowPlayingJob;
use App\Jobs\Stat\TrackPlayedJob;

use App\Models\Track;
use App\Services\ListenbrainzService;
use Illuminate\Http\Request;

class StatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function TrackPlayed(Request $request)
    {
        TrackPlayedJob::dispatch($request->track_id, time());

        return "OK";
    }

    public function NowPlaying(Request $request)
    {
        NowPlayingJob::dispatch($request->track_id);

        return "OK";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlayedTrackStat  $playedTrackStat
     * @return \Illuminate\Http\Response
     */
    public function show(PlayedTrackStat $playedTrackStat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlayedTrackStat  $playedTrackStat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlayedTrackStat $playedTrackStat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlayedTrackStat  $playedTrackStat
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlayedTrackStat $playedTrackStat)
    {
        //
    }
}
