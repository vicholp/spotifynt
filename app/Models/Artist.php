<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Artist extends Model
{
    /** @use HasFactory<\Database\Factories\ArtistFactory> */
    use HasFactory, Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'created_at' => $this->created_at->timestamp,
            'name' => $this->name ?? '',
            'alpha_id' => $this->alpha_id ?? '',
            'mb_id' => $this->mb_id ?? '',
        ];
    }

    protected $fillable = [
        'name',
        'mb_id',
        'alpha_id',
    ];

    public function releaseGroups()
    {
        return $this->hasMany(ReleaseGroup::class);
    }

    public function releases()
    {
        return $this->hasManyThrough(Release::class, ReleaseGroup::class);
    }
}
