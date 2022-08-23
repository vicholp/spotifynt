<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * App\Models\Release.
 *
 * @property int                                                          $id
 * @property string                                                       $title
 * @property string|null                                                  $date
 * @property string                                                       $country
 * @property int                                                          $release_group_id
 * @property string                                                       $mb_release_id
 * @property mixed                                                        $mb_data
 * @property \Illuminate\Support\Carbon|null                              $created_at
 * @property \Illuminate\Support\Carbon|null                              $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Track[] $tracks
 * @property int|null                                                     $tracks_count
 *
 * @method static \Database\Factories\ReleaseFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Release newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Release newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Release query()
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereMbData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereMbReleaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereReleaseGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Release extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'release_group_id',
        'mb_release_id',
        'title',
        'year',
        'country',
        'mb_data',
    ];

    /**
     * @return HasMany<Track>
     */
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
