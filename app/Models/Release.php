<?php

namespace App\Models;

use App\Services\ArtService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    /** @use HasFactory<\Database\Factories\ReleaseFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'alpha_id',
        'mb_id',
        'release_group_id',
    ];

    public function arts()
    {
        return $this->hasMany(Art::class);
    }

    public function artUrl(int $size = 0, string $format = 'webp'): string
    {
        return (new ArtService())->getUrl($this, $size, $format);
    }

    public function releaseGroup()
    {
        return $this->belongsTo(ReleaseGroup::class);
    }

    public function getArtistAttribute()
    {
        return $this->releaseGroup->artist;
    }

    public function getSourceAttribute()
    {
        if ($this->mb_id) {
            return 'musicbrainz';
        }
        if ($this->alpha_id) {
            return 'alpha';
        }
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
}
