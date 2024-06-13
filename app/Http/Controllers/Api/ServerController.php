<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServerCollection;
use App\Http\Resources\ServerResource;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
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
     */
    public function update(Request $request, Server $server): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Server $server): Response
    {
        return response('Not implemented', 501);
    }
}
