<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ServerUser.
 *
 * @property int                             $id
 * @property int                             $server_id
 * @property int                             $user_id
 * @property string                          $permissions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereUserId($value)
 * @mixin \Eloquent
 */
/**
 * App\Models\ServerUser.
 *
 * @property int                             $id
 * @property int                             $server_id
 * @property int                             $user_id
 * @property string                          $permissions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerUser whereUserId($value)
 * @mixin \Eloquent
 */
class ServerUser extends Pivot
{
    //
}
