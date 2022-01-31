<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\Track
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $mb_id
 * @property int $beets_id
 * @property string $name
 * @property string $path
 * @property int $album_id
 * @property array|null $beets_tags
 * @property-read \App\Models\Album $album
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlayedTrackStat[] $playedTrackStats
 * @property-read int|null $played_track_stats_count
 * @method static \Database\Factories\TrackFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Track newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Track newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Track query()
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereBeetsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereBeetsTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Track extends Model
{
    use HasFactory, Searchable;

    public $asYouType = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'beets_tags',
        'album_id',
        'beets_id',
        'mb_id',
        'path',
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
            'album_name' => $this->album->name,
            'artist_name' => $this->artist()->name,
            'artist_country' => $this->artist()->country,
            'year' => $this->album->year,
        ];
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function playedTrackStats()
    {
        return $this->hasMany(PlayedTrackStat::class);
    }

    public function artist()
    {
        return $this->album->artist;
    }
}
