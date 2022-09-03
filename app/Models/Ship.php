<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ship
 *
 * @property int $ID
 * @property string $NAME
 * @property string $GROUP
 * @property string|null $HULL_SIZE
 * @method static \Illuminate\Database\Eloquent\Builder|Ship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ship query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ship whereGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ship whereHULLSIZE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ship whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ship whereNAME($value)
 * @mixin \Eloquent
 */
class Ship extends Model
{
    protected $table = 'ship_lookup';

    protected $primaryKey = 'ID';

    public $timestamps = false;
}
