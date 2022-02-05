<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\BeetsServerUser
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $beets_server_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServerUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServerUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServerUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServerUser whereBeetsServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServerUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServerUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServerUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BeetsServerUser whereUserId($value)
 * @mixin \Eloquent
 */
class BeetsServerUser extends Pivot
{
    //
}
