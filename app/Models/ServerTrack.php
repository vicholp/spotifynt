<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ServerTrack
 *
 * @property int $id
 * @property int $server_id
 * @property int $track_id
 * @property string|null $format
 * @property int|null $bitrate
 * @property int|null $length
 * @property int|null $sample_rate
 * @property int|null $bit_depth
 * @property int|null $channels
 * @property int|null $size
 * @property string $path
 * @property int $beets_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Track $track
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereBeetsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereBitDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereBitrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereChannels($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereSampleRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServerTrack extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * @return BelongsTo<Track, ServerTrack>
     */
    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    /**
     * @return BelongsTo<Server, ServerTrack>
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
