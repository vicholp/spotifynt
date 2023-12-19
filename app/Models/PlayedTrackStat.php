<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PlayedTrackStat.
 *
 * @property int                             $id
 * @property int                             $track_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int                             $user_id
 * @property int                             $server_id
 *
 * @method static \Database\Factories\PlayedTrackStatFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereUserId($value)
 *
 * @mixin \Eloquent
 */
class PlayedTrackStat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'track_id',
        'server_id',
    ];
}
