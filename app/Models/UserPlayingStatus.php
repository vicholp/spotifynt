<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlayingStatus extends Model
{
    protected $fillable = [
        'user_id',
        'player_state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'player_state' => 'array',
    ];

}
