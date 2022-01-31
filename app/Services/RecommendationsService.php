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
            'newly' => AlbumSimpleResource::collection(Album::orderBy('created_at', 'ASC')->limit(10)->get()),
            'mostListened' => '',
            'lessListened' => '',
            'random' => AlbumSimpleResource::collection(Album::inRandomOrder()->limit(10)->get()),
        ];
    }
}
