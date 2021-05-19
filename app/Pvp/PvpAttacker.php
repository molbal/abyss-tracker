<?php

namespace App\Pvp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker query()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereAllianceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereCorporationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereDamageDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereFinalBlow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereSecurityStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereShipTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $killmail_id
 * @method static \Illuminate\Database\Eloquent\Builder|PvpAttacker whereKillmailId($value)
 */
class PvpAttacker extends Model
{
    use HasFactory;
}
