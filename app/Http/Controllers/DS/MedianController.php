<?php


	namespace App\Http\Controllers\DS;


	use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class MedianController {

        /**
         * Gets loot at a distribution threshold
         *
         * @param int  $tier
         * @param int  $percent
         * @param bool $isCruiser
         *
         * @return mixed+
         */
        public static function getLootAtThreshold(int $tier, int $percent, bool $isCruiser) {

            return Cache::remember(sprintf("aft.loot-threshold-tier.%d.%d.%d", $tier, $percent, $isCruiser ? 1 : 0), now()->addHour(), function () use ($tier, $percent, $isCruiser) {

            DB::statement("SET SQL_MODE=''");
            $rank = DB::select("
            select count(*) as CNT from runs r WHERE
                          r.LOOT_ISK>0
                      and r.SURVIVED=1
    and r.SHIP_ID in (select ID from ship_lookup where IS_CRUISER=?)
                      and r.TIER=?;
            ",
                [$isCruiser ? 1 : 0, $tier])[0]->CNT;

            return DB::select("
SELECT a.LI FROM (
                      SELECT
                          r.LOOT_ISK as LI,
                          DENSE_RANK() OVER ( ORDER BY r.LOOT_ISK ) as RNK
                      FROM runs r
                      WHERE
                              r.LOOT_ISK>0 and
                              r.SURVIVED=1 and
                              r.SHIP_ID in (select ID from ship_lookup where IS_CRUISER=?)
                        and r.TIER=?) a
 WHERE a.RNK=?;

",
                [$isCruiser ? 1 : 0, $tier, round($rank*$percent*0.01)])[0]->LI ?? 0;
            });
        }

        /**
         * Gets median for a
         * @param int  $tier
         * @param bool $isCruiser
         *
         * @return int
         */
        public static function getTierMedian(int $tier, bool $isCruiser):int {

            return Cache::remember(sprintf("aft.loot-median-tier.%d.%d", $tier, $isCruiser ? 1 : 0), now()->addHour(), function () use ($tier, $isCruiser) {
                return DB::select("
             SELECT AVG(dd.LOOT_ISK) as MEDIAN_ISK
                FROM (
                SELECT d.LOOT_ISK, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
                  FROM runs d, (SELECT @rownum:=0) r
                  WHERE d.LOOT_ISK is NOT NULL
                and d.SURVIVED=1
                and d.TIER=?
                and d.SHIP_ID in (select ID from ship_lookup where IS_CRUISER=?)
                  ORDER BY d.LOOT_ISK
                ) as dd
                WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );
            ", [$tier, $isCruiser ? 1 : 0])[0]->MEDIAN_ISK ?? 0;
            });
        }

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
                try {
                    return intval(DB::select("select MEDIAN_FOR_FIT_TYPE_TIER(?, ?, ?) as `MEDIAN`;", [$fitId, $tier, $type])[0]->MEDIAN);
                }
                catch (\Exception $e) {
                    return 0;
                }
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
