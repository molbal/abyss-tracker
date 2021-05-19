<?php

namespace App\Pvp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Pvp\PvpAlliance
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAlliance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAlliance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAlliance query()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAlliance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAlliance whereName($value)
 * @mixin \Eloquent
 */
class PvpAlliance extends Model
{
    use HasFactory;
}
