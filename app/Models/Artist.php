<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Artist
 *
 * @property int $id
 * @property string $mb_artist_id
 * @property string $name
 * @property string $type
 * @property string $country
 * @property mixed $mb_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ArtistFactory factory(...$parameters)
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
 * @mixin \Eloquent
 */
class Artist extends Model
{
    use HasFactory;
}
