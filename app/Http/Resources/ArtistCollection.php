<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

<<<<<<<< HEAD:app/Http/Resources/ArtistCollection.php
class ArtistCollection extends ResourceCollection
========
class ReleaseCollection extends ResourceCollection
>>>>>>>> 6c190f9 (wip):app/Http/Resources/ReleaseCollection.php
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
