<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReleaseResource;
use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReleaseController extends Controller
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
    public function show(Release $release, Request $request): ReleaseResource
    {
        if ($request->has('with_tracks')) {
            $release->load('tracks');
        }

        return new ReleaseResource($release);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Release $release): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Release $release): Response
    {
        return response('Not implemented', 501);
    }
}
