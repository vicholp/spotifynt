<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShowedReleaseStat.
 *
 * @property int                             $id
 * @property int                             $release_id
 * @property string                          $where
 * @property int                             $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\ShowedReleaseStatFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ShowedReleaseStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShowedReleaseStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShowedReleaseStat query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShowedReleaseStat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShowedReleaseStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShowedReleaseStat whereReleaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShowedReleaseStat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShowedReleaseStat whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShowedReleaseStat whereWhere($value)
 * @mixin \Eloquent
 */
class ShowedReleaseStat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'where',
        'user_id',
    ];
}
