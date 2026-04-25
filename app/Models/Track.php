<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Track extends Model
{
    /** @use HasFactory<\Database\Factories\TrackFactory> */
    use HasFactory;
    use Searchable;

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
            'title' => $this->title ?? '',
            'alpha_id' => $this->alpha_id ?? '',
            'mb_id' => $this->mb_id ?? '',
            'artist_name' => $this->release->releaseGroup->artist->name ?? '',
            'release_title' => $this->release->title ?? '',
            'release_group_name' => $this->release->releaseGroup?->name ?? '',
            'lyrics' => $this->recording->lyrics ?? '',
        ];
    }

    protected $fillable = [
        'recording_id',
        'release_id',
        'mb_id',
        'alpha_id',

        'position',
        'title',
    ];

    public function recording()
    {
        return $this->belongsTo(Recording::class);
    }

    public function getFilesAttribute()
    {
        return $this->recording->files;
    }

    public function release()
    {
        return $this->belongsTo(Release::class);
    }
}
