<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Item
 *
 * @property int $ITEM_ID
 * @property int $PRICE_BUY
 * @property int $PRICE_SELL
 * @property string $PRICE_LAST_UPDATED
 * @property string $DESCRIPTION
 * @property int $GROUP_ID
 * @property string $GROUP_NAME
 * @property string $NAME
 * @method static Builder|Item newModelQuery()
 * @method static Builder|Item newQuery()
 * @method static Builder|Item query()
 * @method static Builder|Item whereDESCRIPTION($value)
 * @method static Builder|Item whereGROUPID($value)
 * @method static Builder|Item whereGROUPNAME($value)
 * @method static Builder|Item whereITEMID($value)
 * @method static Builder|Item whereNAME($value)
 * @method static Builder|Item wherePRICEBUY($value)
 * @method static Builder|Item wherePRICELASTUPDATED($value)
 * @method static Builder|Item wherePRICESELL($value)
 * @mixin Eloquent
 */
class Item extends Model
{
    use HasFactory;

    protected $table = 'item_prices';

    protected $primaryKey='ITEM_ID';


    public static function getAll() : Collection {
        return self::whereIn('GROUP_ID', config('tracker.items.group_whitelist', []))
            ->whereNotIn('ITEM_ID', config('tracker.items.items_blacklist', []))->get();
    }
}
