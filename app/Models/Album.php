<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\Album
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $mb_id
 * @property int $beets_id
 * @property string $name
 * @property int $artist_id
 * @property int $year
 * @property array|null $beets_tags
 * @property-read \App\Models\Artist $artist
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlayedTrackStat[] $playedTrackStats
 * @property-read int|null $played_track_stats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Track[] $tracks
 * @property-read int|null $tracks_count
 * @method static \Database\Factories\AlbumFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Album newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album query()
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereBeetsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereBeetsTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereMbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereYear($value)
 * @mixin \Eloquent
 */
class Album extends Model
{
    use HasFactory, Searchable;

    public $asYouType = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'mb_id',
        'beets_id',
        'name',
        'artist_id',
        'year',

        'beets_tags',
    ];

    protected $casts = [
        'beets_tags' => 'array',
    ];

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
            'artist_name' => $this->artist->name,
            'artist_country' => $this->artist->country,
        ];
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function playedTrackStats()
    {
        return $this->hasManyThrough(PlayedTrackStat::class, Track::class);
    }

}
