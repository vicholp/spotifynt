<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [...parent::toArray($request),
            'release_groups' => $this->when($request->has('with_release_groups'), fn () => new ReleaseGroupCollection($this->releaseGroups)),
                        'release_group_count' => $this->when(
                $request->has('with_release_group_count'),
                fn () => $this->releaseGroups->count()
            ),
            'releases' => $this->when($request->has('with_releases'), fn () => new ReleaseCollection($this->releases)),
            'release_count' => $this->when(
                $request->has('with_release_count'),
                fn () => $this->releases->count()
            ),
            'art' => [
                'full' => $this->when($request->has('with_art_sizefull'), fn () => $this->releases->map(fn ($release) => $release->artUrl())),
                '500x500' => $this->when($request->has('with_art_size500x500'), fn () => $this->releases->map(fn ($release) => $release->artUrl(500))),
                '250x250' => $this->when($request->has('with_art_size250x250'), fn () => $this->releases->map(fn ($release) => $release->artUrl(250))),
                '75x75' => $this->when($request->has('with_art_size75x75'), fn () => $this->releases->map(fn ($release) => $release->artUrl(75))),
            ],
        ];
    }
}
