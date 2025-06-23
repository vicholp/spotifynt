<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrackRequest;
use App\Http\Requests\UpdateTrackRequest;
use App\Http\Resources\TrackCollection;
use App\Http\Resources\TrackResource;
use App\Models\Track;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new TrackCollection(Track::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrackRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Track $track)
    {
        return new TrackResource($track);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrackRequest $request, Track $track)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Track $track)
    {
        //
    }
}
