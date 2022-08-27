<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArtistSimpleCollection;
use App\Http\Resources\ReleaseSimpleCollection;
use App\Http\Resources\ServerCollection;
use App\Http\Resources\ServerResource;
use App\Http\Resources\TrackSimpleCollection;
use App\Models\Artist;
use App\Models\Release;
use App\Models\Server;
use App\Models\Track;
use App\Services\StatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ServerCollection
    {
        return new ServerCollection(Server::get()->keyBy->id);
    }

    public function searchContent(Request $request, Server $server): array
    {
        $artist_constrain = Artist::with([]);
        $album_constrain = Release::with([]);
        $track_constrain = Track::with([]);

        StatsService::newSearchedTerm(Auth::user(), $request->q);

        return [
            'artists' => new ArtistSimpleCollection(Artist::search($request->q)->constrain($artist_constrain)->get()),
            'albums' => new ReleaseSimpleCollection(Release::search($request->q)->constrain($album_constrain)->get()),
            'tracks' => new TrackSimpleCollection(Track::search($request->q)->constrain($track_constrain)->get()),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Server $server): ServerResource
    {
        return new ServerResource($server);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {
        //
    }
}
