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
        $artistConstrain = Artist::whereRelation('servers', 'servers.id', $server->id);
        $releaseConstrain = Release::whereRelation('servers', 'servers.id', $server->id);
        $trackConstrain = Track::whereRelation('servers', 'servers.id', $server->id);

        StatsService::newSearchedTerm(Auth::user(), $request->q); // @phpstan-ignore-line

        return [
            'artists' => new ArtistSimpleCollection(
                Artist::search($request->q)->constrain($artistConstrain)->get()
            ),
            'albums' => new ReleaseSimpleCollection(
                Release::search($request->q)->constrain($releaseConstrain)->get()
            ),
            'tracks' => new TrackSimpleCollection(
                Track::search($request->q)->constrain($trackConstrain)->get()
            ),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $server = Server::create([
            ...$request->all(),
            'owner_id' => Auth::user()?->id,
        ]);

        return $server;
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
