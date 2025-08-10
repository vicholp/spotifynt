<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReleaseCollection;
use App\Http\Resources\TrackCollection;
use App\Models\Artist;
use App\Models\Release;
use App\Models\Track;
use App\Services\Api\AlphaPlugin;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, AlphaPlugin $alphaPlugin)
    {
        $request->validate(['q' => 'required|string|max:255']);

        $query = $request->input('q');

        return response()->json(
            ['alpha' => $alphaPlugin->query($query)]
        );
    }
}
