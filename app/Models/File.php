<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    protected $fillable = [
        'path',
        'recording_id',
    ];

    public function recording()
    {
        return $this->belongsTo(Recording::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }
}
