<?php

namespace App\Models;

use App\Events\UserPlayingStatusUpdatedEvent;
use Illuminate\Database\Eloquent\BroadcastableModelEventOccurred;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BroadcastsEvents;

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

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'saved' => UserPlayingStatusUpdatedEvent::class,
    ];
}
