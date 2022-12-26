<?php

namespace App\Models;

use App\Services\ArtService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * App\Models\Release
 *
 * @property int $id
 * @property string $title
 * @property string|null $date
 * @property string $country
 * @property int $release_group_id
 * @property string|null $main_color
 * @property string $mb_release_id
 * @property mixed $mb_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Artist|null $artist
 * @property-read \App\Models\ReleaseGroup $releaseGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShowedReleaseStat[] $showedReleaseStats
 * @property-read int|null $showed_release_stats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Track[] $tracks
 * @property-read int|null $tracks_count
 * @method static \Database\Factories\ReleaseFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Release newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Release newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Release query()
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Release whereMainColor($value)
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
     * Modify the query used to retrieve models when making all of the models searchable.
     *
     * @param \Illuminate\Database\Eloquent\Builder<Release> $query
     *
     * @return \Illuminate\Database\Eloquent\Builder<Release>
     */
    protected function makeAllSearchableUsing($query)
    {
        return $query->with('releaseGroup.artist');
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist_name' => $this->artist?->name,
        ];
    }

    /**
     * @return HasMany<Track>
     */
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    /**
     * @return BelongsTo<ReleaseGroup, Release>
     */
    public function releaseGroup()
    {
        return $this->belongsTo(ReleaseGroup::class);
    }

    /**
     * @return Artist|null
     */
    public function getArtistAttribute()
    {
        return $this->releaseGroup->artist;
    }

    public function artUrl(int $size = 0, string $format = 'webp'): string
    {
        return (new ArtService())->getUrl($this, $size, $format);
    }

    /**
     * @return HasMany<ShowedReleaseStat>
     */
    public function showedReleaseStats()
    {
        return $this->hasMany(ShowedReleaseStat::class);
    }
}
