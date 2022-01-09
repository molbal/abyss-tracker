<?php

namespace App\Pvp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Pvp\PvpEventShip
 *
 * @property int $id
 * @property int $event_id
 * @property int $type_id
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEventShip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEventShip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEventShip query()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEventShip whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEventShip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpEventShip whereTypeId($value)
 * @mixin \Eloquent
 */
class PvpEventShip extends Model
{
    use HasFactory;

    public $timestamps = false;
}
