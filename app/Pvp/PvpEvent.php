<?php

    namespace App\Pvp;

use App\Exceptions\BusinessLogicException;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\PvpEvent
 *
 * @method static Builder|PvpEvent newModelQuery()
 * @method static Builder|PvpEvent newQuery()
 * @method static Builder|PvpEvent query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $is_current
 * @property string                                                    $published_at
 * @property Carbon|null                                               $created_at
 * @property Carbon|null                                               $updated_at
 * @method static Builder|PvpEvent whereCreatedAt($value)
 * @method static Builder|PvpEvent whereId($value)
 * @method static Builder|PvpEvent whereIsCurrent($value)
 * @method static Builder|PvpEvent whereName($value)
 * @method static Builder|PvpEvent wherePublishedAt($value)
 * @method static Builder|PvpEvent whereSlug($value)
 * @method static Builder|PvpEvent whereUpdatedAt($value)
 * @property-read Collection|PvpVictim[] $kills
 * @property-read int|null                                             $kills_count
 * @property string $display_component
 * @method static Builder|PvpEvent whereDisplayComponent($value)
 */
class PvpEvent extends Model
{
    use HasFactory;

    protected $table = 'pvp_events';
    public $timestamps = false;

    public function kills() {
        return $this->hasMany('App\Pvp\PvpVictim', 'pvp_event_id', 'id');
    }
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return PvpEvent
     */
    public static function getCurrentEvent(): PvpEvent {
        try {
            return Cache::remember('pvp.events.current', now()->addHour(), function () {return PvpEvent::whereIsCurrent(true)->firstOrFail();});
        } catch (ModelNotFoundException $e) {
            throw new BusinessLogicException("No current event.");
        }
    }
}
