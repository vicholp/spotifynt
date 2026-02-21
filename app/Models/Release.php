<?php

namespace App\Models;

use App\Services\ArtService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Release extends Model
{
    /** @use HasFactory<\Database\Factories\ReleaseFactory> */
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'alpha_id',
        'mb_id',
        'release_group_id',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'created_at' => $this->created_at?->timestamp,
            'title' => $this->title,
            'alpha_id' => $this->alpha_id ?? '',
            'mb_id' => $this->mb_id ?? '',
            'release_group_name' => $this->releaseGroup?->name ?? '',
            'artist_name' => $this->releaseGroup->artist->name ?? '',
        ];
    }

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

    public function getExtensionsAttribute(): array
    {
        $extensions = $this->tracks()->with('recording.files')->get()->flatMap(fn ($track) => $track->files->pluck('extension'))->unique()->values();
        return $extensions->isNotEmpty() ? $extensions->toArray() : [];
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
