<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 */
class Fit extends Model
{
    protected $primaryKey = 'ID';

    public function char() {
        return $this->hasOne('App\Char', 'CHAR_ID');
    }
}
