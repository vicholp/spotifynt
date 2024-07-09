<?php

<<<<<<<< HEAD:app/Http/Controllers/Server/ServerTrackController.php
namespace App\Http\Controllers\Api\Server;
========
namespace App\Http\Controllers\Server;
>>>>>>>> 6c190f9 (wip):app/Http/Controllers/Server/TrackController.php

use App\Http\Controllers\Controller;
use App\Http\Resources\TrackResource;
use App\Models\Server;
use App\Models\ServerTrack;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Server $server): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Server $server): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Display the specified resource.
     */
    public function show(Server $server, Track $track): TrackResource
    {
        $serverTrack = ServerTrack::whereServerId($server->id)->whereTrackId($track->id)->first();

        if (!$serverTrack) {
            abort(404);
        }

        $track->pivot = $serverTrack; // @phpstan-ignore-line - i;m not sure if there is another way to do this.

<<<<<<<< HEAD:app/Http/Controllers/Server/ServerTrackController.php
        $track = $track->load('release');

        return new TrackResource($track);
========
        return new TrackResource($track->load('release'));
>>>>>>>> 6c190f9 (wip):app/Http/Controllers/Server/TrackController.php
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Server $server, Track $track): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Server $server, Track $track): Response
    {
        return response('Not implemented', 501);
    }
}
