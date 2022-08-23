<?php

namespace App\Http\Resources;

use App\Models\Track;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Track */
class TrackSimpleResource extends JsonResource
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
            'release' => [
                'id' => $this->release->id,
                'title' => $this->release->title,
            ],
        ];
    }
}
