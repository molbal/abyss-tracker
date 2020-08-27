<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
