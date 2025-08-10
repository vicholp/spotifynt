<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recording extends Model
{
    /** @use HasFactory<\Database\Factories\RecordingFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'alpha_id',

        'mb_id',
    ];

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
