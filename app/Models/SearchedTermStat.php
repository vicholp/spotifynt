<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SearchedTermStat.
 *
 * @property int                             $id
 * @property string                          $term
 * @property int                             $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\SearchedTermStatFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchedTermStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchedTermStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchedTermStat query()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchedTermStat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchedTermStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchedTermStat whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchedTermStat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchedTermStat whereUserId($value)
 *
 * @mixin \Eloquent
 */
class SearchedTermStat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'term',
        'user_id',
    ];
}
