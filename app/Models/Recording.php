<?php

namespace App\Models;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recording extends Model
{
    /** @use HasFactory<\Database\Factories\RecordingFactory> */
    use BroadcastsEvents;
    use HasFactory;

    protected $fillable = [
        'title',
        'alpha_id',
        'mb_id',
    ];

    /**
     * Get the channels that model events should broadcast on.
     *
     * @return array<string, array<int, \Illuminate\Broadcasting\Channel|Model>>
     */
    public function broadcastOn(string $event): array
    {
        return match ($event) {
            'created' => [new PrivateChannel('App.Models.Recording')],
            default => [$this],
        };
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function marks()
    {
        return $this->morphMany(Mark::class, 'resource');
    }
}
