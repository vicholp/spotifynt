<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReleaseGroup
 *
 * @property int $id
 * @property string $mb_releasegroup_id
 * @property string $title
 * @property string $type
 * @property int $artist_id
 * @property mixed $mb_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ReleaseGroupFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup whereArtistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup whereMbData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup whereMbReleasegroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReleaseGroup extends Model
{
    use HasFactory;
}
