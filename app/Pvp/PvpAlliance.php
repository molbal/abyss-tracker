<?php

namespace App\Pvp;

use App\Connector\EveAPI\Universe\ResourceLookupService;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

/**
 * App\Pvp\PvpAlliance
 *
 * @property int                           $id
 * @property string                        $name
 * @method static Builder|PvpAlliance newModelQuery()
 * @method static Builder|PvpAlliance newQuery()
 * @method static Builder|PvpAlliance query()
 * @method static Builder|PvpAlliance whereId($value)
 * @method static Builder|PvpAlliance whereName($value)
 * @mixin Eloquent
 * @property-read Collection|PvpAttacker[] $kills
 * @property-read int|null                 $kills_count
 * @property-read Collection|PvpVictim[]   $losses
 * @property-read int|null                 $losses_count
 */
class PvpAlliance extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];
    public $timestamps = false;

    public function losses() : HasMany {
        return $this->hasMany('App\Pvp\PvpVictim', 'id', 'alliance_id');
    }
    public function kills() : HasMany {
        return $this->hasMany('App\Pvp\PvpAttacker', 'id', 'alliance_id');
    }

    public static function populate(?int $id) {
        if (!$id) {
            return;
        }
        if (self::whereId($id)->exists()) {
            return;
        }

        Log::channel('pvp')->debug('Populating non existing alliance: '.$id);

        /** @var ResourceLookupService $resourceService */
        $resourceService = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');

        $alliance = $resourceService->getAlliance($id);

        $entity = (new PvpAlliance)->fill([
            'id' => $id, 'name' => $alliance['name'] ?? '[unknown alliance name]'
        ]);

        $entity->save();
        Log::channel('pvp')->debug('Saved alliance '.$alliance['name'].' to the PVP database. (id='.$id.')');

    }
}
