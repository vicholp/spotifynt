<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServerCollection;
use App\Models\Server;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user): ServerCollection
    {
        return new ServerCollection($user->servers()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Server $server): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, Server $server): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Server $server): Response
    {
        return response('Not implemented', 501);
    }
}
