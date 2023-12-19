<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Art.
 *
 * @property int                             $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\ArtFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Art newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Art newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Art query()
 * @method static \Illuminate\Database\Eloquent\Builder|Art whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Art whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Art whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Art extends Model
{
    use HasFactory;
}
