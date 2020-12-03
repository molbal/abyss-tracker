<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
