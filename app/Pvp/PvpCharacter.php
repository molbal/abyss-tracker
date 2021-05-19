<?php

namespace App\Pvp;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Pvp\PvpCharacter
 *
 * @property int                           $id
 * @property string                        $name
 * @method static Builder|PvpCharacter newModelQuery()
 * @method static Builder|PvpCharacter newQuery()
 * @method static Builder|PvpCharacter query()
 * @method static Builder|PvpCharacter whereId($value)
 * @method static Builder|PvpCharacter whereName($value)
 * @mixin Eloquent
 * @property-read Collection|PvpAttacker[] $kills
 * @property-read int|null                 $kills_count
 * @property-read Collection|PvpVictim[]   $losses
 * @property-read int|null                 $losses_count
 */
class PvpCharacter extends Model
{
    use HasFactory;

    public function losses() : HasMany {
        return $this->hasMany('App\Pvp\PvpVictim', 'id', 'character_id');
    }
    public function kills() : HasMany {
        return $this->hasMany('App\Pvp\PvpAttacker', 'id', 'character_id');
    }
}
