<?php

namespace App\Pvp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Pvp\PvpCharacter
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCharacter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCharacter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCharacter query()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCharacter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpCharacter whereName($value)
 * @mixin \Eloquent
 */
class PvpCharacter extends Model
{
    use HasFactory;
}
