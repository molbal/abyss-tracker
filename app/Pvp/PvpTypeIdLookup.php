<?php

namespace App\Pvp;

use App\Connector\EveAPI\Universe\ResourceLookupService;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;

/**
 * App\Pvp\PvpTypeIdLookup
 *
 * @method static Builder|PvpTypeIdLookup newModelQuery()
 * @method static Builder|PvpTypeIdLookup newQuery()
 * @method static Builder|PvpTypeIdLookup query()
 * @mixin Eloquent
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @method static Builder|PvpTypeIdLookup whereGroupId($value)
 * @method static Builder|PvpTypeIdLookup whereId($value)
 * @method static Builder|PvpTypeIdLookup whereName($value)
 * @property-read \App\Pvp\PvpGroupIdLookup|null $group_type
 */
class PvpTypeIdLookup extends Model
{
    protected $fillable = ['id', 'group_id', 'name'];
    protected $table = 'pvp_type_id_lookup';
    public $timestamps = false;
    use HasFactory;

    public function group_type():HasOne {
        return  $this->hasOne('App\Pvp\PvpGroupIdLookup', 'id', 'group_id');
    }

    public static function populate(?int $typeId) {
        if (!$typeId) {
            return;
        }
        if (self::whereId($typeId)->exists()) {
            return;
        }

        /** @var ResourceLookupService $resourceService */
        $resourceService = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');

        try {
            $type = $resourceService->getItemInformation($typeId);
        }
        catch (\Exception $e) {
            Log::warning('Could not get item info for '.$typeId.': '.$e->getMessage());
            return;
        }
        PvpGroupIdLookup::populate($type['group_id']);
        self::create([
            'id' => $typeId, 'group_id' => $type['group_id'], 'name' => $type['name']
        ]);
        Log::channel('pvp')->debug('Saved type '.$type['name'].' to PVP item database. (type_id='.$typeId.')');

    }
}
