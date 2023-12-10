<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * App\Models\Artist.
 *
 * @property int                                                                 $id
 * @property string                                                              $name
 * @property string                                                              $type
 * @property string                                                              $country
 * @property string                                                              $mb_artist_id
 * @property mixed                                                               $mb_data
 * @property \Illuminate\Support\Carbon|null                                     $created_at
 * @property \Illuminate\Support\Carbon|null                                     $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\ReleaseGroup[] $releaseGroups
 * @property int|null                                                            $release_groups_count
 *
 * @method static \Database\Factories\ArtistFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereMbArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereMbData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artist whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Artist extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'mb_artist_id',
        'name',
        'type',
        'country',
        'mb_data',
    ];

    /**
     * @return HasMany<ReleaseGroup>
     */
    public function releaseGroups()
    {
        return $this->hasMany(ReleaseGroup::class);
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
            'name' => $this->name,
        ];
    }
}
