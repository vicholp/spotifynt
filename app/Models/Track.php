<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

/**
 * App\Models\Track.
 *
 * @property int                                                               $id
 * @property string                                                            $title
 * @property int                                                               $release_id
 * @property int|null                                                          $track_position
 * @property int|null                                                          $length
 * @property float|null                                                        $average_loudness
 * @property int|null                                                          $bpm
 * @property float|null                                                        $danceable
 * @property string|null                                                       $genre_rosamerica
 * @property string|null                                                       $language
 * @property float|null                                                        $mood_acoustic
 * @property float|null                                                        $mood_aggressive
 * @property float|null                                                        $mood_electronic
 * @property float|null                                                        $mood_happy
 * @property float|null                                                        $mood_party
 * @property float|null                                                        $mood_relaxed
 * @property float|null                                                        $mood_sad
 * @property string|null                                                       $moods_mirex
 * @property string|null                                                       $voice_instrumental
 * @property string|null                                                       $mb_track_id
 * @property string                                                            $mb_recording_id
 * @property mixed                                                             $mb_data
 * @property \Illuminate\Support\Carbon|null                                   $created_at
 * @property \Illuminate\Support\Carbon|null                                   $updated_at
 * @property Release                                                           $release
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Server> $servers
 * @property int|null                                                          $servers_count
 *
 * @method static \Database\Factories\TrackFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Track newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Track newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Track query()
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereAverageLoudness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereBpm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereDanceable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereGenreRosamerica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMbData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMbRecordingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMbTrackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodAcoustic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodAggressive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodElectronic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodHappy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodParty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodRelaxed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodSad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMoodsMirex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereReleaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereTrackPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereVoiceInstrumental($value)
 *
 * @mixin \Eloquent
 */
class Track extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'release_id',
        'mb_recording_id',
        'title',
        'mb_data',
        'track_position',
        'mb_track_id',
    ];

    /**
     * @return BelongsToMany<Server>
     */
    public function servers()
    {
        return $this->belongsToMany(Server::class)
            ->withPivot([
                'id',
                'path',
                'beets_id',
            ])
            ->using(ServerTrack::class);
    }

    /**
     * @return BelongsTo<Release, Track>
     */
    public function release()
    {
        return $this->belongsTo(Release::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'created_at' => $this->created_at->timestamp,
            'title' => $this->title,
        ];
    }
}
