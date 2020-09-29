<?php


	namespace App\Http\Controllers\DS;


    use App\Http\Controllers\HelperController;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;


	class FitBreakEvenCalculator {

        public static function getMaxTiers(int $fitId): Collection {
            return collect(Cache::remember(sprintf("aft.median.max-tiers.%s", $fitId,), now()->addMinute(), function () use ($fitId) {
                return DB::select("select MAX(TIER) as `MAX_TIER`, TYPE from runs where FIT_ID=? and SURVIVED=1 and LOOT_ISK>0 group by TYPE order by 1 desc limit 1;", [$fitId]);
            }));
	    }

        /**
         * @param int                            $id
         * @param \Illuminate\Support\Collection $maxTiers
         * @param                                $fit
         *
         * @return \Illuminate\Support\Collection
         */
        public static function breaksEvenCalculation(int $id, \Illuminate\Support\Collection $maxTiers, $fit) : \Illuminate\Support\Collection {
            $breaksEven = collect([]);
            foreach ($maxTiers as $i => $maxTier) {
                $meanLootIsk = MedianController::getFitMedian($id, $maxTier->MAX_TIER, $maxTier->TYPE);

                if ($meanLootIsk == 0) {
                    continue;
                }

                $meanRuntimeSeconds = MedianController::getFitMedianRuntime($id, $maxTier->MAX_TIER, $maxTier->TYPE);
                if ($meanRuntimeSeconds < 1) {
                    $meanRuntimeSeconds = 60 * 20;
                }

                $breakEvenRuns = HelperController::clamp(ceil($fit->PRICE / $meanLootIsk), 0, 9999); //max(0, min(9999, floor($fit->PRICE / $meanLootIsk)));
                $breakEvenSeconds = $breakEvenRuns * $meanRuntimeSeconds;
                $breaksEven->add([
                    "info" => $maxTier,
                    "medianRuntime" => $meanRuntimeSeconds ?? 60 * 20,
                    "medianRuntimeFormatted" =>  gmdate("i:s",$meanRuntimeSeconds ?? 60 * 20),
                    "medianISK" => $meanLootIsk,
                    "breakEvenRuns" => $breakEvenRuns,
                    "breakEvenTimeSeconds" => $breakEvenSeconds,
                    "breakEvenTimeFormatted" => gmdate("H:i:s", $breakEvenSeconds),
                    "iskPerHour" => (3600 / $meanRuntimeSeconds) * $meanLootIsk]);
            }

            return $breaksEven;
        }
	}
