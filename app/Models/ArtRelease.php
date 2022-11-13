<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ArtRelease.
 *
 * @property int                             $id
 * @property int                             $art_id
 * @property int                             $release_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ArtRelease newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArtRelease newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArtRelease query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArtRelease whereArtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArtRelease whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArtRelease whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArtRelease whereReleaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArtRelease whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ArtRelease extends Pivot
{
    //
}
