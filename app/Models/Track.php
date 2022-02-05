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
 * @property string|null $mb_id
 * @property int $beets_id
 * @property string $name
 * @property string $path
 * @property int $album_id
 * @property int|null $track_position
 * @property int $length
 * @property string $format
 * @property int $bitrate
 * @property string $bit_depht
 * @property string $sample_rate
 * @property float|null $average_loudness
 * @property int|null $bpm
 * @property float|null $danceable
 * @property string|null $genre_rosamerica
 * @property string|null $language
 * @property float|null $mood_acoustic
 * @property float|null $mood_aggressive
 * @property float|null $mood_electronic
 * @property float|null $mood_happy
 * @property float|null $mood_party
 * @property float|null $mood_relaxed
 * @property float|null $mood_sad
 * @property string|null $moods_mirex
 * @property string|null $voice_instrumental
 * @property array|null $beets_tags
 * @property-read \App\Models\Album $album
 * @property-read \App\Models\Artist|null $artist
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlayedTrackStat[] $playedTrackStats
 * @property-read int|null $played_track_stats_count
 * @method static \Database\Factories\TrackFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Track newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Track newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Track query()
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereAverageLoudness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereBeetsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereBeetsTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereBitDepht($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereBitrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereBpm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereDanceable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereGenreRosamerica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodAcoustic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodAggressive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodElectronic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodHappy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodParty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodRelaxed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodSad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodsMirex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereSampleRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereTrackPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereVoiceInstrumental($value)
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
        'mb_id',
        'beets_id',
        'name',
        'path',
        'album_id',
        'track_position',

        'length',
        'format',
        'bitrate',
        'bit_depht',
        'sample_rate',

        'average_loudness',
        'bpm',
        'danceable',
        'genre_rosamerica',
        'language',
        'mood_acoustic',
        'mood_aggressive',
        'mood_electronic',
        'mood_happy',
        'mood_party',
        'mood_relaxed',
        'mood_sad',
        'moods_mirex',
        'voice_instrumental',

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
            'album_name' => $this->album->name,
            'artist_name' => $this->artist->name,
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

    public function getArtistAttribute()
    {
        return $this->album->artist;
    }
}
