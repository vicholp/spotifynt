<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
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
            'files' => $this->when($request->has('with_files'), fn () => new FileCollection($this?->files ?? [])),
            'release' => $this->when($request->has('with_release'), fn () => new ReleaseResource($this?->release)),
        ];
    }
}
