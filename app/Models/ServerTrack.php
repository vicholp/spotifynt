<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ServerTrack.
 *
 * @property int                             $id
 * @property int                             $server_id
 * @property int                             $track_id
 * @property string                          $path
 * @property int                             $beets_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereBeetsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereUpdatedAt($value)
 * @mixin \Eloquent
 */
/**
 * App\Models\ServerTrack.
 *
 * @property int                             $id
 * @property int                             $server_id
 * @property int                             $track_id
 * @property string                          $path
 * @property int                             $beets_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereBeetsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrack whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServerTrack extends Pivot
{
    //
}
