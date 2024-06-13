<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ServerSyncLog
 *
 * @property int $id
 * @property int $server_id
 * @property string $result
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ServerSyncLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerSyncLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerSyncLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerSyncLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerSyncLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerSyncLog whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerSyncLog whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerSyncLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServerSyncLog extends Model
{
    use HasFactory;
}
