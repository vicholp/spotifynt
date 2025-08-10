<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    /** @use HasFactory<\Database\Factories\ArtistFactory> */
    use HasFactory;

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
