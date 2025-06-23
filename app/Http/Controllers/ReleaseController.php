<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReleaseRequest;
use App\Http\Requests\UpdateReleaseRequest;
use App\Http\Resources\ReleaseCollection;
use App\Http\Resources\ReleaseResource;
use App\Models\Release;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ReleaseCollection(Release::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReleaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Release $release)
    {
        return new ReleaseResource($release);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReleaseRequest $request, Release $release)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Release $release)
    {
        //
    }
}
