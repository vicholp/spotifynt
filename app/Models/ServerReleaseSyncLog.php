<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ServerReleaseSyncLog.
 *
 * @property int                             $id
 * @property int                             $server_sync_log_id
 * @property int                             $release_id
 * @property string                          $result
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ServerReleaseSyncLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerReleaseSyncLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerReleaseSyncLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerReleaseSyncLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerReleaseSyncLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerReleaseSyncLog whereReleaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerReleaseSyncLog whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerReleaseSyncLog whereServerSyncLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerReleaseSyncLog whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ServerReleaseSyncLog extends Model
{
    use HasFactory;
}
