<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ReleaseServer
 *
 * @property int $id
 * @property int $server_id
 * @property int $release_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Release $release
 * @property-read \App\Models\Server $server
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseServer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseServer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseServer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseServer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseServer whereReleaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseServer whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseServer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReleaseServer extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function release()
    {
        return $this->belongsTo(Release::class);
    }
}
