<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServerCollection;
use App\Models\Server;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function store(Request $request, User $user): string
    {
        $user->servers()->attach($request->server_id);

        return 'OK';
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Server $server)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Server $server)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Server $server)
    {
        //
    }
}
