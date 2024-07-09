<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrackCollection;
use App\Http\Resources\TrackResource;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): TrackCollection
    {
        return new TrackCollection(Track::get());
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
    public function show(Track $track): TrackResource
    {
        return new TrackResource($track);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Track $track): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Track $track): Response
    {
        return response('Not implemented', 501);
    }
}
