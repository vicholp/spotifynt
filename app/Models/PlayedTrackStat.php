<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PlayedTrackStat
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $track_id
 * @property-read \App\Models\Track $track
 * @method static \Database\Factories\PlayedTrackStatFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlayedTrackStat whereUpdatedAt($value)
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
        'track_id',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
