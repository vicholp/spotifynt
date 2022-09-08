<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SkippedTrackStat.
 *
 * @property int                             $id
 * @property int                             $track_id
 * @property int                             $user_id
 * @property int                             $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\SkippedTrackStatFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SkippedTrackStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkippedTrackStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkippedTrackStat query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkippedTrackStat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkippedTrackStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkippedTrackStat whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkippedTrackStat whereTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkippedTrackStat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkippedTrackStat whereUserId($value)
 * @mixin \Eloquent
 */
class SkippedTrackStat extends Model
{
    use HasFactory;
}
