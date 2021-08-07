<?php

namespace App;

use App\Exceptions\ConduitSecurityViolationException;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FitSearchController;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Fit
 *
 * @property int $ID
 * @property int $CHAR_ID Fit owner
 * @property int $SHIP_ID
 * @property string $NAME
 * @property string $DESCRIPTION
 * @property string $STATS
 * @property string $STATUS
 * @property int $PRICE
 * @property string $RAW_EFT
 * @property string $SUBMITTED
 * @property string|null $VIDEO_LINK
 * @property string|null $PRIVACY
 * @property string|null $FFH
 * @property int|null $ROOT_ID
 * @property int $REVISION_NUMBER
 * @property string $LAST_PATCH
 * @property string|null $CREATED_AT
 * @method static Builder|Fit newModelQuery()
 * @method static Builder|Fit newQuery()
 * @method static Builder|Fit query()
 * @method static Builder|Fit whereCHARID($value)
 * @method static Builder|Fit whereCREATEDAT($value)
 * @method static Builder|Fit whereDESCRIPTION($value)
 * @method static Builder|Fit whereFFH($value)
 * @method static Builder|Fit whereID($value)
 * @method static Builder|Fit whereLASTPATCH($value)
 * @method static Builder|Fit whereNAME($value)
 * @method static Builder|Fit wherePRICE($value)
 * @method static Builder|Fit wherePRIVACY($value)
 * @method static Builder|Fit whereRAWEFT($value)
 * @method static Builder|Fit whereREVISIONNUMBER($value)
 * @method static Builder|Fit whereROOTID($value)
 * @method static Builder|Fit whereSHIPID($value)
 * @method static Builder|Fit whereSTATS($value)
 * @method static Builder|Fit whereSTATUS($value)
 * @method static Builder|Fit whereSUBMITTED($value)
 * @method static Builder|Fit whereVIDEOLINK($value)
 * @mixin Eloquent
 * @property-read Char|null $char
 * @property-read Ship|null $ship
 */
class Fit extends Model
{
    protected $primaryKey = 'ID';

    protected $casts = [
      'STATS' => 'array'
    ];

    public function char() {
        return $this->hasOne('App\Char', 'CHAR_ID', 'CHAR_ID');
    }

    public function ship() {
        return $this->hasOne('App\Ship', 'ID', 'SHIP_ID');
    }

    public static function listForApi(int $charId, ?string $ffh = null, ?int $revision = null): Collection {
        $builder = Fit::with(['ship', 'char'])
            ->joinSub('SELECT MAX(ID) as ID FROM fits where ROOT_ID is not null GROUP BY ROOT_ID UNION SELECT ID from fits where ROOT_ID is null', 'lastrevs', 'fits.ID', '=', 'lastrevs.ID');
        if ($ffh) {
            $builder->where('fits.FFH', '=', $ffh);
        }
        if ($revision) {
            $revisions = collect([$revision]);
            if (Fit::where('ID', $revision)->exists()) {
                $rootId = Fit::where('ID', $revision)->firstOrFail()->ROOT_ID;
                if ($rootId) {
                    $revisions->add($rootId);
                }
            }
//            return $revisions;
            $builder->where(function ($builder) use ($revisions) {
                return $builder->whereIn('fits.ID', '=', $revisions)->orWhereIn('fits.ROOT_ID',$revisions);
            });
        }
        return $builder
                  ->orderByDesc('fits.ID')
                  ->get()->map(fn ($a) => $a->shortForm());
    }

    /**
     * @throws ConduitSecurityViolationException
     */
    #[ArrayShape(['id' => "int", 'name' => "string", 'uploader' => "array", 'ship' => "array", 'eft' => "string", 'tags' => "\Illuminate\Support\Collection", 'stats' => "string", 'status' => "string", 'price' => "int"])]
    public static function getForApi(int $charId, int $fitId) : array {
        /** @var Fit $fit */
        $fit = Fit::with(['ship', 'char'])
            ->where('ID', $fitId)->firstOrFail();
        if ($fit->PRIVACY == 'private' && $fit->CHAR_ID != $charId) {
            throw new ConduitSecurityViolationException('You are not allowed to access this fit.');
        }
        return $fit->longForm();
    }

    #[ArrayShape(['id' => "int", 'name' => "string", 'uploader' => "array", 'ship' => "array"])]
    public function shortForm(): array {
        return [
            'id' => $this->ID,
            'name' => trim($this->NAME),
            'uploader' => [
                'privacy' => $this->PRIVACY,
                'char' => AuthController::isItMe($this->char->CHAR_ID) || $this->PRIVACY=='public' ? [
                    'id' => $this->char->CHAR_ID,
                    'name' => $this->char->NAME,
                ] : ['id' => null, 'name' => null]
            ],
            'ship'=> [
                'id'=>$this->ship->ID ?? null,
                'name'=>$this->ship->NAME ?? null,
                'size'=>$this->ship->HULL_SIZE ?? null,
            ]
        ];
    }

    #[ArrayShape(['id' => "int", 'name' => "string", 'uploader' => "array", 'ship' => "array", 'eft' => "string", 'tags' => "\Illuminate\Support\Collection", 'stats' => "string", 'status' => "string", 'price' => "int"])]
    public function longForm(): array {
        return [
            'id' => $this->ID,
            'name' => trim($this->NAME),
            'uploader' => [
                'privacy' => $this->PRIVACY,
                'char' => AuthController::isItMe($this->char->CHAR_ID) || $this->PRIVACY=='public' ? [
                    'id' => $this->char->CHAR_ID,
                    'name' => $this->char->NAME,
                ] : ['id' => null, 'name' => null]
            ],
            'ship'=> [
                'id'=>$this->ship->ID ?? null,
                'name'=>$this->ship->NAME ?? null,
                'size'=>$this->ship->HULL_SIZE ?? null,
            ],
            'eft' => $this->RAW_EFT,
            'flexibleFitHash' => $this->FFH,
            'tags' => FitSearchController::getInstance()->getFitTags($this->ID)->where('TAG_VALUE', 1)->pluck('TAG_NAME')->map(fn ($tag) => __('tags.'.$tag)),
            'stats' => $this->STATS,
            'status' => $this->LAST_PATCH,
            'price' => intval($this->PRICE)
        ];
    }
}
