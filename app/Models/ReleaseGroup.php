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
        'mb_id',
        'artist_id',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

    public function arts()
    {
        return $this->hasManyThrough(Art::class, Release::class);
    }
}
