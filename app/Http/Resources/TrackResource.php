<?php

namespace App\Http\Resources;

use App\Models\Track;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Track */
class TrackResource extends JsonResource
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
            'release' => $this->whenLoaded('release', function () {
                return new ReleaseResource($this->release);
            }),
            'server_track' => $this->whenPivotLoaded('server_track', function () {
                return $this->pivot; // @phpstan-ignore-line
            }),
        ];
    }
}
