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
            'tracks' => new TrackCollection($this->tracks->load('release')->sortBy('track_position')),
            'art' => $this->artUrl(),
        ];
    }
}
