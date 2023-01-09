<?php


	namespace App\Http\Controllers\DS;


    use App\Http\Controllers\HelperController;
    use App\Http\Controllers\TimeHelper;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;


	class FitBreakEvenCalculator {
        /**
        * Retrieve the maximum tiers for a given fit ID.
         *
         * @param int $fitId The fit ID to get the maximum tiers for.
         *
         * @return Collection A collection of the maximum tiers for the given fit ID.
        */

        public static function getMaxTiers(int $fitId) : Collection {
            return collect(Cache::remember(sprintf("aft.median.max-tiers.%s", $fitId,), now()->addMinute(), function () use ($fitId) {
                return DB::select("select MAX(inn.MAX_TIER) as MAX_TIER, inn.TYPE
                    from (select MAX(TIER) as `MAX_TIER`, TYPE
                          from runs
                          where FIT_ID = ? and SURVIVED = 1 and LOOT_ISK > 0
                          group by TYPE) inn
                    where inn.MAX_TIER=(select MAX(TIER) from runs where FIT_ID = ? and SURVIVED = 1 and LOOT_ISK > 0)
                    group by inn.TYPE limit 1;", [$fitId, $fitId]);
            }));
        }
        /**
        * Calculates the break-even point for a given fit.
         * 
         * @param int $id The ID of the fit.
         * @param Collection $maxTiers The collection of maximum tiers.
         * @param $fit The fit object.
         * 
         * @return Collection The collection of break-even points.
        */

        public static function breaksEvenCalculation(int $id, Collection $maxTiers, $fit) : Collection
        {
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
                    "medianRuntimeFormatted" =>  TimeHelper::formatSecondsToMMSS($meanRuntimeSeconds),
                    "medianISK" => $meanLootIsk,
                    "breakEvenRuns" => $breakEvenRuns,
                    "breakEvenTimeSeconds" => $breakEvenSeconds,
                    "breakEvenTimeFormatted" => TimeHelper::formatSecondsToHHMMSS($breakEvenSeconds),
                    "iskPerHour" => (3600 / $meanRuntimeSeconds) * $meanLootIsk]);
            }

            return $breaksEven;
        }
	}
