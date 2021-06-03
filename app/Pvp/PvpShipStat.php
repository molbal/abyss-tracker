<?php

namespace App\Pvp;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Pvp\PvpShipStat
 *
 * @property int $id
 * @property int $killmail_id
 * @property mixed|null $stats
 * @property string|null $error_text
 * @property string|null $eft
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PvpShipStat newModelQuery()
 * @method static Builder|PvpShipStat newQuery()
 * @method static Builder|PvpShipStat query()
 * @method static Builder|PvpShipStat whereCreatedAt($value)
 * @method static Builder|PvpShipStat whereErrorText($value)
 * @method static Builder|PvpShipStat whereId($value)
 * @method static Builder|PvpShipStat whereKillmailId($value)
 * @method static Builder|PvpShipStat whereStats($value)
 * @method static Builder|PvpShipStat whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read PvpVictim $victim
 * @method static Builder|PvpShipStat whereEft($value)
 */
class PvpShipStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'error_text',
        'stats',
        'eft',
        'killmail_id',
    ];

    protected $casts = [
//        'stats' => 'json'
    ];

    public function victim(): BelongsTo {
        return $this->belongsTo('App\Pvp\PvpVictim', 'killmail_id', 'killmail_id');
    }

    public function isFailed() : bool {
        return Str::of($this->error_text)->isNotEmpty() || Str::of($this->stats)->isEmpty();
    }

}
