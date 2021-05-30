<?php

namespace App\Pvp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * App\Pvp\PvpShipStat
 *
 * @property int $id
 * @property int $killmail_id
 * @property mixed|null $stats
 * @property string|null $error_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PvpShipStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpShipStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpShipStat query()
 * @method static \Illuminate\Database\Eloquent\Builder|PvpShipStat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpShipStat whereErrorText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpShipStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpShipStat whereKillmailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpShipStat whereStats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PvpShipStat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PvpShipStat extends Model
{
    use HasFactory;

    protected $casts = [
        'stats' => 'json'
    ];

    public function victim(): BelongsTo {
        return $this->belongsTo('App\Pvp\PvpVictim', 'killmail_id', 'killmail_id');
    }

    public function isFailed() : bool {
        return Str::of($this->error_text)->isNotEmpty();
    }

}
