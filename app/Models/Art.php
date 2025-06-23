<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Art extends Model
{
    use HasFactory;

    protected $fillable = [
        'release_id',
        'url',
        'type',
        'width',
        'height',
        'mime_type',
    ];

    public function release()
    {
        return $this->belongsTo(Release::class);
    }
}
