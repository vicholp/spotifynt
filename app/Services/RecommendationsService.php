<?php

namespace App\Services;

use App\Http\Resources\AlbumSimpleResource;
use App\Models\Album;

/**
 * Class RecommendationsService
 * @package App\Services
 */
class RecommendationsService
{
    static public function getAlbums()
    {
        return [
            'newly' => AlbumSimpleResource::collection(Album::orderBy('created_at', 'DESC')->with('artist')->limit(12)->get()),
            'mostListened' => [],
            'lessListened' => [],
            'random' => AlbumSimpleResource::collection(Album::inRandomOrder()->with('artist')->limit(12)->get()),
        ];
    }
}
