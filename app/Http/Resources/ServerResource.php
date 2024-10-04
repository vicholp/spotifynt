<?php

namespace App\Http\Resources;

use App\Models\Server;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Server */
class ServerResource extends JsonResource
{
    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'path' => $this->path,
            'owner' => $this->owner,
            'artists_count' => $this->whenCounted('artists'),
            'releases_count' => $this->whenCounted('releases'),
            'tracks_count' => $this->whenCounted('tracks'),
        ];
    }
}
