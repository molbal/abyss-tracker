<?php

namespace App\Pvp;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Pvp\PvpCorporation
 *
 * @property int                           $id
 * @property string                        $name
 * @method static Builder|PvpCorporation newModelQuery()
 * @method static Builder|PvpCorporation newQuery()
 * @method static Builder|PvpCorporation query()
 * @method static Builder|PvpCorporation whereId($value)
 * @method static Builder|PvpCorporation whereName($value)
 * @mixin Eloquent
 * @property-read Collection|PvpAttacker[] $kills
 * @property-read int|null                 $kills_count
 * @property-read Collection|PvpVictim[]   $losses
 * @property-read int|null                 $losses_count
 */
class PvpCorporation extends Model
{
    use HasFactory;

    public function losses() : HasMany {
        return $this->hasMany('App\Pvp\PvpVictim', 'id', 'corporation_id');
    }
    public function kills() : HasMany {
        return $this->hasMany('App\Pvp\PvpAttacker', 'id', 'corporation_id');
    }

}
