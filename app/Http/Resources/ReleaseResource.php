<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReleaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'artist' => $this->when($request->has('with_artist'), fn () => new ArtistResource($this->artist)),
            'arts' => $this->when($request->has('with_arts'), fn () => new ArtCollection($this->arts)),

            'art' => [
                'full' => $this->when($request->has('with_art_sizefull'), fn () => $this->artUrl()),
                '500x500' => $this->when($request->has('with_art_size500x500'), fn () => $this->artUrl(500)),
                '250x250' => $this->when($request->has('with_art_size250x250'), fn () => $this->artUrl(250)),
                '75x75' => $this->when($request->has('with_art_size75x75'), fn () => $this->artUrl(75)),
            ],
            'tracks' => $this->when($request->has('with_tracks'), fn () => new TrackCollection($this->tracks)),

            'source' => $this->source,
            'extensions' => $this->when($request->has('with_extensions'), fn () => $this->extensions),
        ];
    }
}
