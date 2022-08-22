<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Track
 *
 * @property int $id
 * @property string|null $mb_release_id
 * @property string $title
 * @property int $release_id
 * @property int|null $track_position
 * @property int $length
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
 * @property mixed $mb_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TrackFactory factory(...$parameters)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Track whereMbReleaseId($value)
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
 * @mixin \Eloquent
 */
class Track extends Model
{
    use HasFactory;
}
