<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = [
        'resource_type',
        'resource_id',
        'comment',
    ];

    public function resource()
    {
        return $this->morphTo();
    }
}
