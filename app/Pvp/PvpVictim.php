<?php

    namespace App\Pvp;

use App\Events\PvpVictimSaved;
use App\Exceptions\BusinessLogicException;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\PvpVictim
 *
 * @property int $killmail_id
 * @property int $character_id
 * @property int $corporation_id
 * @property int|null $alliance_id
 * @property int $damage_taken
 * @property int $ship_type_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PvpVictim newModelQuery()
 * @method static Builder|PvpVictim newQuery()
 * @method static Builder|PvpVictim query()
 * @method static Builder|PvpVictim whereAllianceId($value)
 * @method static Builder|PvpVictim whereCharacterId($value)
 * @method static Builder|PvpVictim whereCorporationId($value)
 * @method static Builder|PvpVictim whereCreatedAt($value)
 * @method static Builder|PvpVictim whereDamageTaken($value)
 * @method static Builder|PvpVictim whereKillmailId($value)
 * @method static Builder|PvpVictim whereShipTypeId($value)
 * @method static Builder|PvpVictim whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int                           $pvp_event_id
 * @method static Builder|PvpVictim wherePvpEventId($value)
 * @property-read PvpAlliance|null         $alliance
 * @property-read Collection|PvpAttacker[] $attackers
 * @property-read int|null                 $attackers_count
 * @property-read PvpCharacter|null        $character
 * @property-read PvpCorporation|null      $corporation
 * @property string|array $littlekill
 * @property string $fullkill
 * @method static Builder|PvpVictim whereFullkill($value)
 * @method static Builder|PvpVictim whereLittlekill($value)
 */
class PvpVictim extends Model
{

    protected $primaryKey = 'killmail_id';

//    protected $dispatchesEvents = [
//        'saved' => PvpVictimSaved::class
//    ];

    protected $with = [
        'attackers',
        'character',
        'corporation',
        'alliance'
    ];
    protected $fillable = ['killmail_id', 'character_id', 'corporation_id', 'alliance_id', 'damage_taken', 'ship_type_id', 'littlekill', 'fullkill', 'created_at', 'pvp_event_id'];
    use HasFactory;

    protected $casts = [
        'littlekill' => 'json',
        'fullkill' => 'json',
    ];

    /**
     * @param PvpEvent $event
     *
     * @return PvpVictim|Builder
     */
    public static function wherePvpEvent(PvpEvent $event) : PvpVictim|Builder {
        return self::wherePvpEventId($event->id);
    }

    public function attackers() : HasMany {
        return $this->hasMany('App\Pvp\PvpAttacker', 'killmail_id', 'killmail_id');
    }

    public function character(): HasOne {
        return $this->hasOne('App\Pvp\PvpCharacter', 'id', 'character_id');
    }

    public function corporation(): HasOne {
        return $this->hasOne('App\Pvp\PvpCorporation', 'id', 'corporation_id');
    }

    public function alliance(): HasOne {
        return $this->hasOne('App\Pvp\PvpAlliance', 'id', 'alliance_id');
    }

    public function ship_type(): HasOne {
        return $this->hasOne('App\Pvp\PvpTypeIdLookup', 'id','ship_type_id');
    }

    public function pvp_event(): HasOne {
        return $this->hasOne('App\Pvp\PvpEvent', 'id','pvp_event_id');
    }

    public function firstAttacker(): PvpAttacker {
        return  $this->attackers->first();
    }

    public function hasAlliance():bool {
        return $this->alliance_id && !is_null($this->alliance);
    }


    /**
     * @return string
     * @throws BusinessLogicException
     */
    public function getKillboardLink(): string {
        return $this->littlekill['url'] ?? throw new BusinessLogicException('Malformed littlekill - no url value found in it ' - print_r($this->littlekill, true));
    }
}
