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

        'size_bytes',
        'checksum_md5',
        'mime_type',
        'extension',
        'bitrate_bps',
        'sample_rate_hz',
        'length_s',
        'source',
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
