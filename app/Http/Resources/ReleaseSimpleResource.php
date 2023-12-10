<?php

namespace App\Http\Resources;

use App\Models\Release;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Release */
class ReleaseSimpleResource extends JsonResource
{
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
            'title' => $this->title,
            'art' => [
                'full' => $this->artUrl(),
                '250' => $this->artUrl(250),
                '75' => $this->artUrl(75),
            ],
        ];
    }
}
