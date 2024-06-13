<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ReleaseGroupServer
 *
 * @property int $id
 * @property int $server_id
 * @property int $release_group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ReleaseGroup $releaseGroup
 * @property-read \App\Models\Server $server
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroupServer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroupServer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroupServer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroupServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroupServer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroupServer whereReleaseGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroupServer whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroupServer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReleaseGroupServer extends Pivot
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

    public function releaseGroup()
    {
        return $this->belongsTo(ReleaseGroup::class);
    }
}
