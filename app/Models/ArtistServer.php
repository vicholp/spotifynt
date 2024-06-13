<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ArtistServer
 *
 * @property int $id
 * @property int $server_id
 * @property int $artist_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Artist $artist
 * @property-read \App\Models\Server $server
 * @method static \Illuminate\Database\Eloquent\Builder|ArtistServer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArtistServer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArtistServer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArtistServer whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArtistServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArtistServer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArtistServer whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArtistServer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArtistServer extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
