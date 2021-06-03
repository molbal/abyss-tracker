<?php

    namespace App\Pvp;

use App\Events\PvpVictimSaved;
use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\EFT\FitHelper;
use App\Http\Controllers\FitsController;
use App\Http\Controllers\Partners\ZKillboard;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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
 * @property-read null|PvpShipStat $stats
 * @property-read \App\Pvp\PvpEvent|null $pvp_event
 * @property-read \App\Pvp\PvpTypeIdLookup|null $ship_type
 */
class PvpVictim extends Model
{

    protected $primaryKey = 'killmail_id';
    public $incrementing = false;

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

    public function stats(): HasOne {
        return $this->hasOne('App\Pvp\PvpShipStat', 'killmail_id', 'killmail_id');
    }

    public function hasWorkingStats(): bool {
        return !is_null($this->stats) && !$this->stats->isFailed();
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

    public static function requestStatsCalculation(PvpVictim $victim) : void {
//        Log::info(print_r($victim, 1));
        try {
            $eft = ZKillboard::getZKillboardFit($victim->getKillboardLink());

            /** @var FitHelper $fitHelper */
            $fitHelper = resolve('App\Http\Controllers\EFT\FitHelper');

            $shipId = FitsController::getShipIDFromEft($eft, true);

            if (PvpShipStat::whereKillmailId($victim->killmail_id)->exists()) {
                $stat = PvpShipStat::whereKillmailId($victim->killmail_id)->firstOrFail();
            }
            else {
                $stat = new PvpShipStat();
                $stat->fill([
                   'error_text' => 'In progress',
                   'killmail_id' => $victim->killmail_id,
                   'stats' => null
                ]);
            }
            $stat->eft = $eft;
            $stat->save();

            $fixedEft = $fitHelper->pyfaBugWorkaround($eft, $shipId);

            /** @var FitsController $fitsController */
            $fitsController = resolve('App\Http\Controllers\FitsController');

            if (!$fitsController->submitSvcFitService($fixedEft, $victim->killmail_id, config('fits.prefix.pvp'))) {
                throw new Exception('Could not submit fit to svcfitstat ('.$victim->killmail_id.')');
            }
            Log::debug('Killmail stats sent requested for ' . $victim->getKillboardLink());

            return;

        } catch (\Exception $e) {
            Log::channel("pvp")
               ->warning("requestStatsCalculation failed: [" . $e->getMessage() . '] ' . $e->getTraceAsString());
            throw $e;
        }
    }

}
