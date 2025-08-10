<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    /** @use HasFactory<\Database\Factories\TrackFactory> */
    use HasFactory;

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
