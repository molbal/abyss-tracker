<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\PatreonDonorDisplay
 *
 * @property int $id
 * @property string $name
 * @property float $monthly_donation
 * @property \Illuminate\Support\Carbon $joined
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PatreonDonorDisplay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatreonDonorDisplay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatreonDonorDisplay query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatreonDonorDisplay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatreonDonorDisplay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatreonDonorDisplay whereJoined($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatreonDonorDisplay whereMonthlyDonation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatreonDonorDisplay whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatreonDonorDisplay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatreonDonorDisplay extends Model
{

    protected $casts = [
        'joined' => 'date'
    ];

    public static function getLatestDonorForHomepage() {
        return Cache::remember("aft.patreon.last", now()->addMinutes(15), function () {
            return PatreonDonorDisplay::orderBy("joined", 'DESC')->limit(1)->first();
        });
    }
}
