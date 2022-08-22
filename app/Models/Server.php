<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Server
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $last_sync
 * @property string $last_full_sync
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ServerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereLastFullSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereLastSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Server extends Model
{
    use HasFactory;
}
