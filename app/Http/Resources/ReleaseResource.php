<?php

namespace App\Http\Resources;

use App\Models\Release;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Release */
class ReleaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist' => [
                'id' => $this->artist?->id,
                'name' => $this->artist?->name,
            ],
            'tracks' => $this->whenLoaded('tracks', function () {
                return new TrackCollection($this->tracks->load('release')->sortBy('track_position'));
            }),
            'art' => [
                'full' => $this->when($request->has('with_art_sizefull'), fn () => $this->artUrl()),
                '250x250' => $this->when($request->has('with_art_size250x250'), fn () => $this->artUrl(250)),
                '75x75' => $this->when($request->has('with_art_size75x75'), fn () => $this->artUrl(75)),
            ],
        ];
    }
}
