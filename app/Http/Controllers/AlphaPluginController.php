<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReleaseCollection;
use App\Http\Resources\TrackCollection;
use App\Models\Artist;
use App\Models\Release;
use App\Models\Track;
use App\Services\Api\AlphaPlugin;
use Illuminate\Http\Request;

class AlphaPluginController extends Controller
{
    public function artist(Request $request, AlphaPlugin $alphaPlugin, string $id)
    {
        $artist = $alphaPlugin->getArtist($id);

        return response()->json($artist);

    }

    public function album(Request $request, AlphaPlugin $alphaPlugin, string $id)
    {
        $album = $alphaPlugin->getAlbum($id);

        return response()->json($album);
    }

    public function downloadAlbum(Request $request, AlphaPlugin $alphaPlugin, string $id)
    {
        $album = $alphaPlugin->downloadAlbum($id);

        return response()->json($album);
    }
}
