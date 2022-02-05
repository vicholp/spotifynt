<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BeetsServer
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $ip
 * @method static \Database\Factories\BeetsServerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServer query()
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServer whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BeetsServer extends Model
{
    use HasFactory;
}
