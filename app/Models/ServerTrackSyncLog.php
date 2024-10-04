<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ServerTrackSyncLog.
 *
 * @property int                             $id
 * @property int                             $server_sync_log_id
 * @property int                             $track_id
 * @property string                          $result
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrackSyncLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrackSyncLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrackSyncLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrackSyncLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrackSyncLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrackSyncLog whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrackSyncLog whereServerSyncLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrackSyncLog whereTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerTrackSyncLog whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ServerTrackSyncLog extends Model
{
    use HasFactory;
}
