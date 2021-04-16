<?php


    namespace App\Http\Controllers;


    use App\Charts\AverageLoot;
    use App\Charts\RunsCount;
    use App\Charts\SurvivalRatio;
    use App\Charts\TotalLoot;
    use App\Http\Controllers\Auth\AuthController;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;

    class HomeQueriesController
    {


        /**
         * @return \Illuminate\Support\Collection
         */
        public function getLastRuns() : \Illuminate\Support\Collection
        {
            return Cache::remember("aft.home.lastruns", now()->addMinutes(3), function () {
               return DB::table("v_runall")->orderBy("CREATED_AT", "DESC")->limit(20)->get();
            });
        }

        /**
         * @return array
         */
        public function getCommonDrops() : array
        {
            return Cache::remember("aft.home.lastdrops", now()->addMinutes(15), function () {
                $drops = DB::select("SELECT ip.ITEM_ID,
       MAX(ip.PRICE_BUY)  as     PRICE_BUY,
       MAX(ip.PRICE_SELL) as     PRICE_SELL,
       MAX(ip.NAME)       as     NAME,
       MAX(ip.GROUP_NAME) as     GROUP_NAME,
       (SELECT SUM(drci.DROPPED_COUNT) / SUM(drci.RUNS_COUNT)
        FROM droprates_cache drci
        WHERE drci.ITEM_ID = ip.ITEM_ID
          AND drci.TYPE = 'All') DROP_CHANCE
FROM item_prices ip
         LEFT JOIN droprates_cache drc ON ip.ITEM_ID = drc.ITEM_ID
WHERE drc.TYPE = 'ALL'
GROUP BY ip.ITEM_ID
ORDER BY 6 DESC
LIMIT 10;
    ");

            return $drops;
            });
        }


        /**
         * @return array
         */
        public static function getPersonalStats(?int $loginId = null): array {

            if(!$loginId) {
                $loginId = AuthController::getLoginId();
            }

            $my_runs = DB::table("runs")->where("CHAR_ID", $loginId)->count();
            $my_avg_loot = round(DB::table("runs")->where("CHAR_ID", $loginId)->avg('LOOT_ISK'));
            $my_sum_loot = DB::table("runs")->where("CHAR_ID", $loginId)->sum('LOOT_ISK');
            $my_survival_ratio = (DB::table("runs")->where("CHAR_ID", $loginId)->where("SURVIVED", '=', true)->count()) / max(1, $my_runs) * 100;

            return [$my_runs, $my_avg_loot, $my_sum_loot, $my_survival_ratio];
        }

        public static function getOverviewCharts(array $my_runs, array $my_avg_loot, array $my_sum_loot, array $my_survival_ratio): array {
            ksort($my_runs);
            ksort($my_avg_loot);
            ksort($my_sum_loot);
            ksort($my_survival_ratio);

            $my_avg_loot = array_map(function ($a) {return round($a/1000000, 2);}, $my_avg_loot);
            $my_sum_loot = array_map(function ($a) {return round($a/1000000, 2);}, $my_sum_loot);
            $my_survival_ratio = array_map(function ($a) {return round($a, 2);}, $my_survival_ratio);

            $ids = array_keys($my_runs);
            $labels = DB::table('chars')->whereIn('CHAR_ID', $ids)->orderBy('CHAR_ID')->get(['CHAR_ID as id', 'NAME as name']);

            $names = $labels->pluck("name")->map(function ($a) {return Str::limit($a, 8);});
            $runsCount = new RunsCount();
            $runsCount->displayAxes(false);
            $runsCount->displayLegend(false);
            $runsCount->export(true, "Download");
            $runsCount->height("300");
            $runsCount->labels($names);
            $runsCount->theme(ThemeController::getChartTheme());
            $runsCount->dataset('Run counts', 'pie', array_values($my_runs));
            $runsCount->options([
                'grid'=>[
                'left' => 50,
                'top' =>20,
                'right' => 10]
            ]);

            $avgLoot = new AverageLoot();
            $avgLoot->displayAxes(true);
            $avgLoot->displayLegend(false);
            $avgLoot->export(true, "Download");
            $avgLoot->height("300");
            $avgLoot->theme(ThemeController::getChartTheme());
            $avgLoot->labels($names);
            $avgLoot->dataset('Average loot', 'bar', array_values($my_avg_loot));
            $avgLoot->options([
                'grid'=>[
                    'left' => 50,
                    'top' =>20,
                    'right' => 10]
            ]);


            $survival = new SurvivalRatio();
            $survival->displayAxes(true);
            $survival->displayLegend(false);
            $survival->export(true, "Download");
            $survival->height("300");
            $survival->theme(ThemeController::getChartTheme());
            $survival->labels($names);
            $survival->dataset('Survival ratio', 'bar', array_values($my_survival_ratio));
            $survival->options([
                'grid'=>[
                    'left' => 50,
                    'top' =>20,
                    'right' => 10],
                'yAxis' => [
                    'min '=> 90
                ]
            ]);

            $sumLoot = new TotalLoot();
            $sumLoot->displayAxes(false);
            $sumLoot->displayLegend(false);
            $sumLoot->export(true, "Download");
            $sumLoot->height("300");
            $sumLoot->labels($names);
            $sumLoot->theme(ThemeController::getChartTheme());
            $sumLoot->dataset('All loot', 'pie', array_values($my_sum_loot));
            $sumLoot->options([
                'grid'=>[
                    'left' => 50,
                    'top' =>20,
                    'right' => 10]
            ]);


            return [$runsCount, $avgLoot, $survival, $sumLoot];

        }
    }
