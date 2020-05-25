<?php


	namespace App\Http\Controllers\DS;


    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;


	class FitBreakEvenCalculator {

        public static function getMaxTiers(int $fitId): Collection {
            return collect(Cache::remember(sprintf("aft.median.max-tiers.%s", $fitId,), now()->addMinute(), function () use ($fitId) {
                return DB::select("select MAX(TIER) as `MAX_TIER`, TYPE from runs where FIT_ID=? group by TYPE;", [$fitId]);
            }));
	    }

        public static function findBreakEvenForFitTypeTier() {

        }
	}
