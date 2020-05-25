<?php


	namespace App\Http\Controllers\DS;


	use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class MedianController {


        /**
         * Gets a median value for a ship (cached for up to a minute)
         * @param int $fitId fit ID
         * @param int $tier tier
         * @param int $type type
         *
         * @return int
         */
        public static function getFitMedian(int $fitId, int $tier, string $type): int {
            return Cache::remember(sprintf("aft.median.fit.%s.%d.%s", $fitId, $tier, $type), now()->addMinute(), function () use ($fitId, $tier, $type) {
                return intval(DB::select("select MEDIAN_FOR_FIT_TYPE_TIER(?, ?, ?) as `MEDIAN`;", [$fitId, $tier, $type])[0]->MEDIAN);
            });
        }


        /**
         * Gets a median runtime value for a ship (cached for up to a minute)
         * @param int $fitId fit ID
         * @param int $tier tier
         * @param int $type type
         *
         * @return int
         */
        public static function getFitMedianRuntime(int $fitId, int $tier, string $type): int {
            return Cache::remember(sprintf("aft.median.rutime.fit.%s.%d.%s", $fitId, $tier, $type), now()->addMinute(), function () use ($fitId, $tier, $type) {
                return intval(DB::select("select MEDIAN_FOR_FIT_TYPE_TIER_RUNTIME(?, ?, ?) as `MEDIAN`;", [$fitId, $tier, $type])[0]->MEDIAN);
            });
        }
	}
