<?php

namespace App\Pvp;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\PvpAttacker
 *
 * @property int $id
 * @property int $character_id
 * @property int $corporation_id
 * @property int|null $alliance_id
 * @property int $damage_done
 * @property int $final_blow
 * @property float $security_status
 * @property int $ship_type_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PvpAttacker newModelQuery()
 * @method static Builder|PvpAttacker newQuery()
 * @method static Builder|PvpAttacker query()
 * @method static Builder|PvpAttacker whereAllianceId($value)
 * @method static Builder|PvpAttacker whereCharacterId($value)
 * @method static Builder|PvpAttacker whereCorporationId($value)
 * @method static Builder|PvpAttacker whereCreatedAt($value)
 * @method static Builder|PvpAttacker whereDamageDone($value)
 * @method static Builder|PvpAttacker whereFinalBlow($value)
 * @method static Builder|PvpAttacker whereId($value)
 * @method static Builder|PvpAttacker whereSecurityStatus($value)
 * @method static Builder|PvpAttacker whereShipTypeId($value)
 * @method static Builder|PvpAttacker whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int                      $killmail_id
 * @method static Builder|PvpAttacker whereKillmailId($value)
 * @property-read PvpAlliance|null    $alliance
 * @property-read PvpCharacter|null   $character
 * @property-read PvpCorporation|null $corporation
 * @property-read PvpVictim           $victim
 * @property int $weapon_type_id
 * @method static Builder|PvpAttacker whereWeaponTypeId($value)
 */
class PvpAttacker extends Model
{
    use HasFactory;

    protected $fillable = ['killmail_id', 'character_id', 'corporation_id', 'alliance_id', 'damage_done', 'final_blow', 'security_status', 'ship_type_id', 'weapon_type_id'];

    public function character(): HasOne {
        return $this->hasOne('App\Pvp\PvpCharacter', 'id', 'character_id');
    }

    public function corporation(): HasOne {
        return $this->hasOne('App\Pvp\PvpCorporation', 'id', 'corporation_id');
    }

    public function alliance(): HasOne {
        return $this->hasOne('App\Pvp\PvpAlliance', 'id', 'alliance_id');
    }

    public function victim(): BelongsTo {
        return $this->belongsTo('App\Pvp\PvpVictim', 'killmail_id', 'killmail_id');
    }
}
