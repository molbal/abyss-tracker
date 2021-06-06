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
 * App\Pvp\PvpCharacter
 *
 * @property int                           $id
 * @property string                        $name
 * @method static Builder|PvpCharacter newModelQuery()
 * @method static Builder|PvpCharacter newQuery()
 * @method static Builder|PvpCharacter query()
 * @method static Builder|PvpCharacter whereId($value)
 * @method static Builder|PvpCharacter whereName($value)
 * @mixin Eloquent
 * @property-read Collection|PvpAttacker[] $kills
 * @property-read int|null                 $kills_count
 * @property-read Collection|PvpVictim[]   $losses
 * @property-read int|null                 $losses_count
 */
class PvpCharacter extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name'];
    public $timestamps = false;

    public function losses() : HasMany {
        return $this->hasMany('App\Pvp\PvpVictim', 'id', 'character_id');
    }
    public function kills() : HasMany {
        return $this->hasMany('App\Pvp\PvpAttacker', 'id', 'character_id');
    }


    public static function populate(?int $id) {
        if(!$id) return;

        if (self::whereId($id)->exists()) {
            return;
        }

        Log::channel('pvp')->debug('Populating non existing char: '.$id);

        /** @var ResourceLookupService $resourceService */
        $resourceService = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');

        $name = $resourceService->getCharacterName($id);

        $entity = (new PvpCharacter)->fill([
            'id' => $id, 'name' => $name
        ]);

        $entity->save();
        Log::channel('pvp')->debug('Saved character '.$name.' to the PVP database. (id='.$id.')');

    }
}
