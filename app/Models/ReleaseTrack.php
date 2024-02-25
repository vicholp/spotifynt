<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ReleaseTrack.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseTrack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseTrack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseTrack query()
 *
 * @mixin \Eloquent
 */
class ReleaseTrack extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'release_id',
        'track_id',
    ];
}
