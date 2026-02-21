<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrackResource;
use App\Models\Recording;
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

        $tracks = collect($album['tracks'])->map(fn ($track) => [
            ...$track,
            'spotifynt_track' => TrackResource::make(Recording::where('alpha_id', $track['videoId'])->first()?->tracks()->first()),
        ]);

        $album['tracks'] = $tracks;

        return response()->json($album);
    }

    public function downloadAlbum(Request $request, AlphaPlugin $alphaPlugin, string $id)
    {
        $album = $alphaPlugin->downloadAlbum($id);

        return response()->json($album);
    }

    public function downloadTrack(Request $request, AlphaPlugin $alphaPlugin, string $albumId, string $trackId)
    {
        $track = $alphaPlugin->downloadTrack(albumId: $albumId, trackId: $trackId);

        return response()->json($track);
    }
}
