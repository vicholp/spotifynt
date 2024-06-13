<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReleaseArt
 *
 * @property int $id
 * @property int $release_id
 * @property string|null $url
 * @property string|null $type
 * @property int|null $width
 * @property int|null $height
 * @property string|null $mime_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Release $release
 * @method static \Database\Factories\ReleaseArtFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt whereReleaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseArt whereWidth($value)
 * @mixin \Eloquent
 */
class ReleaseArt extends Model
{
    use HasFactory;

    protected $fillable = [
        'release_id',
        'url',
        'type',
        'width',
        'height',
        'mime_type',
    ];

    public function release()
    {
        return $this->belongsTo(Release::class);
    }
}
