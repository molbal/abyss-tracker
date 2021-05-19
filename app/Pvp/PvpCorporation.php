<?php

namespace App\Pvp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Pvp\PvpCorporation
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCorporation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCorporation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCorporation query()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCorporation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCorporation whereName($value)
 * @mixin \Eloquent
 */
class PvpCorporation extends Model
{
    use HasFactory;
}
