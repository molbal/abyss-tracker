<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Run
 *
 * @property int $ID
 * @property int $CHAR_ID
 * @property int $PUBLIC
 * @property string $TIER
 * @property string $TYPE
 * @property int $LOOT_ISK
 * @property int $SURVIVED
 * @property string $RUN_DATE
 * @property int|null $SHIP_ID
 * @property string|null $DEATH_REASON
 * @property int|null $PVP_CONDUIT_USED
 * @property int|null $PVP_CONDUIT_SPAWN
 * @property int|null $FILAMENT_PRICE
 * @property string|null $LOOT_TYPE
 * @property string|null $KILLMAIL
 * @property string|null $CREATED_AT
 * @property int|null $RUNTIME_SECONDS
 * @property int|null $FIT_ID
 * @property int|null $IS_BONUS
 * @method static \Illuminate\Database\Eloquent\Builder|Run newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Run newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Run query()
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereCHARID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereCREATEDAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereDEATHREASON($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereFILAMENTPRICE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereFITID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereISBONUS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereKILLMAIL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereLOOTISK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereLOOTTYPE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run wherePUBLIC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run wherePVPCONDUITSPAWN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run wherePVPCONDUITUSED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereRUNDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereRUNTIMESECONDS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereSHIPID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereSURVIVED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereTIER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereTYPE($value)
 * @mixin \Eloquent
 */
class Run extends Model
{
    protected $primaryKey = 'ID';
}
