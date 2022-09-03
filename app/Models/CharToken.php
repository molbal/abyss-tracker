<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CharToken
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CharToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CharToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CharToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|CharToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharToken whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CharToken extends Model
{
    use HasFactory;
}
