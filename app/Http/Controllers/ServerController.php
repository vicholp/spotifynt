<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServerResource;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Display the specified resource.
     */
    public function show(Server $server): ServerResource
    {
        return ServerResource::make($server->load('owner')->loadCount(['artists', 'releases', 'tracks']));
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
