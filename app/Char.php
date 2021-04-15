<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Char
 *
 * @property int $CHAR_ID
 * @property string $NAME
 * @property string $REFRESH_TOKEN Eve OAuth2 Refresh Token
 * @method static \Illuminate\Database\Eloquent\Builder|Char newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Char newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Char query()
 * @method static \Illuminate\Database\Eloquent\Builder|Char whereCHARID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Char whereNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Char whereREFRESHTOKEN($value)
 * @mixin \Eloquent
 */
class Char extends Model
{

    protected $primaryKey = 'CHAR_ID';

    public static function loadName(int $id):string {
        return Cache::remember('char-id.'.$id, now()->addMinutes(10), function () use ($id) {
            return Char::where('CHAR_ID',$id)->firstOrFail()->NAME;
        });
    }
}
