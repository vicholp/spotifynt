<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TrackResource;
use App\Models\Server;
use App\Models\ServerTrack;
use App\Models\Track;
use Illuminate\Http\Request;

class ServerTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Server $server)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Server $server)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Server $server, Track $track): TrackResource
    {
        $serverTrack = ServerTrack::whereServerId($server->id)->whereTrackId($track->id)->first();

        $track->pivot = $serverTrack; // @phpstan-ignore-line - i;m not sure if there is another way to do this.

        return new TrackResource($track);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server, Track $track)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server, Track $track)
    {
        //
    }
}
