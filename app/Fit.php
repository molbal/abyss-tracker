<?php

namespace App;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
 * @method static \Illuminate\Database\Eloquent\Builder|Fit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereCHARID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereCREATEDAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereDESCRIPTION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereFFH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereLASTPATCH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit wherePRICE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit wherePRIVACY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereRAWEFT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereREVISIONNUMBER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereROOTID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereSHIPID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereSTATS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereSTATUS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereSUBMITTED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fit whereVIDEOLINK($value)
 * @mixin \Eloquent
 * @property-read \App\Char|null $char
 * @property-read \App\Ship|null $ship
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

    public static function getForApi(int $charId): Collection {
        DB::enableQueryLog();
        return Fit::with(['ship', 'char'])
                  ->whereRaw("fits.ID in (SELECT MAX(ID) as ID FROM fits where ROOT_ID is not null GROUP BY ROOT_ID UNION SELECT ID from fits where ROOT_ID is null) and (fits.PRIVACY != 'private' OR fits.CHAR_ID=".$charId.")")
                    ->orderBy('fits.NAME')
            ->get()->map(fn ($a) => $a->shortForm());
    }

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
}
