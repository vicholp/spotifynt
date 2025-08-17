<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleaseGroup extends Model
{
    /** @use HasFactory<\Database\Factories\ReleaseGroupFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'alpha_id',
        'primary_type',
        'secondary_types',
        'mb_id',
        'artist_id',
    ];

    protected $casts = [
        'secondary_types' => 'array',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

    public function releases()
    {
        return $this->hasMany(Release::class);
    }

    public function arts()
    {
        return $this->hasManyThrough(Art::class, Release::class);
    }
}
