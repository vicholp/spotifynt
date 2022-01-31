<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'beets_id' => $this->beets_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'played' => $this->playedTrackStats()->count(),
            'album' => $this->album,
            'artist' => $this->artist()->first(),
        ];
    }
}
