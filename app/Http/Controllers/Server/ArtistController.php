<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArtistCollection;
use App\Models\Artist;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Server $server): ArtistCollection
    {
        return ArtistCollection::make($server->artists);
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
    public function show(Server $server, Artist $artist): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Server $server, Artist $artist): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Server $server, Artist $artist): Response
    {
        return response('Not implemented', 501);
    }
}
