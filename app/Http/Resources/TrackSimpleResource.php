<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackSimpleResource extends JsonResource
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
            'album' => [
                'id' => $this->album->id,
                'name' => $this->album->name,
            ],
            'artist' => [
                'id' => $this->artist()->id,
                'name' => $this->artist()->name,
            ],
        ];
    }
}
