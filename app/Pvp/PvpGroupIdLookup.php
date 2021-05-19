<?php

namespace App\Pvp;

use App\Connector\EveAPI\Universe\ResourceLookupService;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * App\Pvp\PvpGroupIdLookup
 *
 * @method static Builder|PvpGroupIdLookup newModelQuery()
 * @method static Builder|PvpGroupIdLookup newQuery()
 * @method static Builder|PvpGroupIdLookup query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @method static Builder|PvpGroupIdLookup whereId($value)
 * @method static Builder|PvpGroupIdLookup whereName($value)
 */
class PvpGroupIdLookup extends Model
{
    protected $fillable = ['id', 'name'];
    protected $table = 'pvp_group_id_lookup';

    /**
     * @param int $groupId
     */
    public static function populate(int $groupId) {
        if (self::whereId($groupId)->exists()) {
            return;
        }

        /** @var ResourceLookupService $resourceService */
        $resourceService = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');

        try {
            $type = $resourceService->getGroupInfo($groupId);
        }
        catch (\Exception $e) {
            Log::warning('Could not get item info for '.$groupId.': '.$e->getMessage());
            return;
        }
        self::create([
            'id' => $groupId, 'name' => $type['name']
        ]);
        Log::channel('pvp')->debug('Saved group '.$type['name'].' to PVP item database. (group_id='.$groupId.')');
    }

    use HasFactory;
}
