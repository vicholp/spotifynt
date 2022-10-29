<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Server.
 *
 * @property int                                                          $id
 * @property string                                                       $name
 * @property string                                                       $path
 * @property int                                                          $owner_id
 * @property string                                                       $visibility
 * @property string                                                       $access
 * @property string|null                                                  $last_sync
 * @property string|null                                                  $last_full_sync
 * @property \Illuminate\Support\Carbon|null                              $created_at
 * @property \Illuminate\Support\Carbon|null                              $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Track[] $tracks
 * @property int|null                                                     $tracks_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\User[]  $users
 * @property int|null                                                     $users_count
 *
 * @method static \Database\Factories\ServerFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereLastFullSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereLastSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereVisibility($value)
 * @mixin \Eloquent
 */
class Server extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'path',
        'owner_id',
    ];

    /**
     * @return BelongsToMany<Track>
     */
    public function tracks()
    {
        return $this->belongsToMany(Track::class)->withPivot(['path', 'beets_id']);
    }

    /**
     * @return BelongsToMany<User>
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return BelongsTo<User, Server>
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
