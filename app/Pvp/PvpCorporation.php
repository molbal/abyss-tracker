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
 * App\Pvp\PvpCorporation
 *
 * @property int                           $id
 * @property string                        $name
 * @method static Builder|PvpCorporation newModelQuery()
 * @method static Builder|PvpCorporation newQuery()
 * @method static Builder|PvpCorporation query()
 * @method static Builder|PvpCorporation whereId($value)
 * @method static Builder|PvpCorporation whereName($value)
 * @mixin Eloquent
 * @property-read Collection|PvpAttacker[] $kills
 * @property-read int|null                 $kills_count
 * @property-read Collection|PvpVictim[]   $losses
 * @property-read int|null                 $losses_count
 */
class PvpCorporation extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name'];
    public $timestamps = false;

    public function losses() : HasMany {
        return $this->hasMany('App\Pvp\PvpVictim', 'id', 'corporation_id');
    }
    public function kills() : HasMany {
        return $this->hasMany('App\Pvp\PvpAttacker', 'id', 'corporation_id');
    }


    public static function populate(?int $id) {
        if(!$id) return;
        if (self::whereId($id)->exists()) {
            return;
        }
        Log::channel('pvp')->debug('Populating non existing corporation: '.$id);

        /** @var ResourceLookupService $resourceService */
        $resourceService = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');

        $corporation = $resourceService->getCorporation($id);
        $entity = (new PvpCorporation())->fill([
            'id' => $id, 'name' => $corporation['name'] ?? '[unknown corporation name]'
        ]);

        try {
            $entity->save();
        }
        catch (\Exception $e) {
            Log::warning("Could not save pvp corporation: possible race condition. ".$e->getMessage());
        }
        Log::channel('pvp')->debug('Saved corporation '.$corporation['name'].' to the PVP database. (id='.$id.')');

    }
}
