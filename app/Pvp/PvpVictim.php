<?php

    namespace App\Pvp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\PvpVictim
 *
 * @property int $killmail_id
 * @property int $character_id
 * @property int $corporation_id
 * @property int|null $alliance_id
 * @property int $damage_taken
 * @property int $ship_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim query()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim whereAllianceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim whereCorporationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim whereDamageTaken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim whereKillmailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim whereShipTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpVictim whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PvpVictim extends Model
{
    use HasFactory;
}
