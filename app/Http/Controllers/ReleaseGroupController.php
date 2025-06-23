<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReleaseGroupRequest;
use App\Http\Requests\UpdateReleaseGroupRequest;
use App\Http\Resources\ReleaseGroupCollection;
use App\Http\Resources\ReleaseGroupResource;
use App\Models\ReleaseGroup;

class ReleaseGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ReleaseGroupCollection(ReleaseGroup::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReleaseGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ReleaseGroup $releaseGroup)
    {
        return new ReleaseGroupResource($releaseGroup);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReleaseGroupRequest $request, ReleaseGroup $releaseGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReleaseGroup $releaseGroup)
    {
        //
    }
}
