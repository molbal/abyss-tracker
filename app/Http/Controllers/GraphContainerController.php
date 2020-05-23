<?php


    namespace App\Http\Controllers;


    use App\Charts\AbyssSurvivalType;
    use App\Charts\DailyAdds;
    use App\Charts\IskPerHourChart;
    use App\Charts\LootTierChart;
    use App\Charts\LootTypesChart;
    use App\Charts\PersonalDaily;
    use App\Charts\RunBetter;
    use App\Charts\SurvivalLevelChart;
    use App\Charts\TierLevelsChart;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class GraphContainerController
    {


        public function getLootBellGraphs(int $tier, bool $isCruiser = true, int $thisRun = 0): RunBetter {

            $chart = new RunBetter();

            $chart->export(true, "Download");
//            $chart->height("400px");
            $chart->theme(ThemeController::getChartTheme());
            $chart->load(route("chart.run.averages", [
                "tier" => $tier, "isCruiser"=>$isCruiser, "thisRun" => $thisRun
            ]));
            $options = $chart->options;
            $options["xAxis"] = [];
            $chart->options($options, true);
            $chart->options(['tooltip' => ['trigger' => 'axis', 'formatter' => "function(params) {return params.name;}"]]);

            return $chart;
        }


        /**
         * @return LootTypesChart
         */
        public function getHomeLootTypesChart() : LootTypesChart
        {
            $lootTypesChart = new LootTypesChart();
            $lootTypesChart->load(route("chart.home.type"));
            $lootTypesChart->displayAxes(false);
            $lootTypesChart->displayLegend(false);
            $lootTypesChart->export(true, "Download");
            $lootTypesChart->height("400");
            $lootTypesChart->theme(ThemeController::getChartTheme());

            return $lootTypesChart;
        }

        /**
         * @return TierLevelsChart
         */
        public function getHomeLootTierLevels() : TierLevelsChart
        {
            $tierLevelsChart = new TierLevelsChart();
            $tierLevelsChart->load(route("chart.home.tier"));
            $tierLevelsChart->displayAxes(false);
            $tierLevelsChart->displayLegend(false);
            $tierLevelsChart->export(true, "Download");
            $tierLevelsChart->height("400");
            $tierLevelsChart->theme(ThemeController::getChartTheme());

            return $tierLevelsChart;
        }

        /**
         * @return SurvivalLevelChart
         */
        public function getHomeSurvivalLevels() : SurvivalLevelChart
        {
            $survival_chart = new SurvivalLevelChart();
            $survival_chart->load(route("chart.home.survival"));
            $survival_chart->export(true, "Download");
            $survival_chart->displayAxes(false);
            $survival_chart->height(400);
            $survival_chart->theme(ThemeController::getChartTheme());
            $survival_chart->displayLegend(false);

            return $survival_chart;
        }

        /**
         * @return RunBetter
         */
        public function getHomeLootAverages() : RunBetter
        {
//            $loot_tier_chart = new LootTierChart();
//            $loot_tier_chart->load(route("chart.home.tier_averages"));
//            $loot_tier_chart->export(true, "Download");
//            $loot_tier_chart->displayAxes(true);
//            $loot_tier_chart->height(400);
//            $loot_tier_chart->labels(["Tier 1", "Tier 2", "Tier 3", "Tier 4", "Tier 5"]);
//            $loot_tier_chart->theme(ThemeController::getChartTheme());
//            $loot_tier_chart->displayLegend(true);
//
//            return $loot_tier_chart;
            $chart = new RunBetter();

            $chart->export(true, "Download");
//            $chart->height("400px");
            $chart->theme(ThemeController::getChartTheme());
            $chart->load(route("chart.home.distribution"));
            $options = $chart->options;
            $options["xAxis"] = [];
            $chart->options($options, true);
            $chart->options(['tooltip' => ['trigger' => 'axis', 'formatter' => "function(params) {return params.name;}"]]);

            return $chart;
        }

        /**
         * @return array
         */
        public function getHomeDailyRunCounts() : object
        {

            [$run_date, $count_unknown, $count_cruiser, $count_frigate, $rolling_avg_week, $rolling_avg_month] = Cache::remember("chart.daily_run_count", now()->addMinutes(15), function () {

            $run_date = [];
            $count_unknown = [];
            $count_cruiser = [];
            $count_frigate = [];
            $rolling_avg_week = [];
            $rolling_avg_month = [];
            for ($days = -60; $days<=0; $days++) {

                $timestamp = strtotime("now $days days");
                $timestamp_week_older = strtotime("now ".($days-7)." days");
                $timestamp_month_older = strtotime("now ".($days-30)." days");
                $run_date[] = date("m. d.", $timestamp);
                $count_unknown[] = DB::table("runs")
                    ->whereNull("SHIP_ID")
                    ->where("RUN_DATE", date("Y-m-d", $timestamp))
                    ->groupBy("RUN_DATE")
                    ->count();

                $count_cruiser[] = DB::table("runs")
                    ->whereNotNull("runs.SHIP_ID")
                    ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                    ->where("ship_lookup.IS_CRUISER", "1")
                    ->where("RUN_DATE", date("Y-m-d", $timestamp))
                    ->groupBy("RUN_DATE")
                    ->count();

                $count_frigate[] = DB::table("runs")
                    ->whereNotNull("runs.SHIP_ID")
                    ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                    ->where("ship_lookup.IS_CRUISER", "0")
                    ->where("RUN_DATE", date("Y-m-d", $timestamp))
                    ->groupBy("RUN_DATE")
                    ->count();

                $rolling_avg_week[] = round(DB::table("runs")
                                         ->where("RUN_DATE", '<=', date("Y-m-d", $timestamp))
                                         ->where("RUN_DATE", '>', date("Y-m-d", $timestamp_week_older))
                                         ->count()/7,2);
                $rolling_avg_month[] = round(DB::table("runs")
                                         ->where("RUN_DATE", '<=', date("Y-m-d", $timestamp))
                                         ->where("RUN_DATE", '>', date("Y-m-d", $timestamp_month_older))
                                         ->count()/30,2);
            }

            return [$run_date, $count_unknown, $count_cruiser, $count_frigate, $rolling_avg_week, $rolling_avg_month];
            });

            $daily_add_chart = new DailyAdds();
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date)->dataset("Unspecified runs", "bar", $count_unknown)->options(["stack" => "1"]);
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date)->dataset("Cruiser runs", "bar", $count_cruiser)->options(["stack" => "1"]);
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date)->dataset("Frigate runs", "bar", $count_frigate)->options(["stack" => "1"]);
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date)->dataset("7 day avg", "line", $rolling_avg_week)->options(['smooth' => true]);
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date)->dataset("30 day avg", "line", $rolling_avg_month)->options(['smooth' => true]);
            $daily_add_chart->theme(ThemeController::getChartTheme());
            $daily_add_chart->displayLegend(true);
            $daily_add_chart->options([
                'smooth'         => true,
                'symbolSize'     => 0,
                'smoothMonotone' => 'x',
                'tooltip'        => [
                    'trigger' => "axis"
                ]
            ]);

            return $daily_add_chart;
        }


        /**
         * Returns charts for the Personal Stats screen
         * @param array $labels
         * @return array
         */
        public function getPersonalStatsCharts(array $labels): array {
            $personalDaily = new PersonalDaily();
            $personalDaily->load(route("chart.personal.loot"));
            $personalDaily->displayAxes(true);
            $personalDaily->displayLegend(true);
            $personalDaily->export(true, "Download");
            $personalDaily->height("400");
            $personalDaily->theme(ThemeController::getChartTheme());
            $personalDaily->labels($labels);

            $iskPerHour = new IskPerHourChart();
            $iskPerHour->load(route("chart.personal.ihp"));
            $iskPerHour->displayAxes(true);
            $iskPerHour->displayLegend(true);
            $iskPerHour->export(true, "Download");
            $iskPerHour->height("400");
            $iskPerHour->theme(ThemeController::getChartTheme());
            $iskPerHour->labels($labels);
            return [$personalDaily, $iskPerHour];
        }


        /**
         * Gets single run graphs
         * @param $data
         * @return array
         */
        public function getRunGraphs($data): array {
            $isCruiser = DB::table("ship_lookup")
                       ->where("ID", $data->SHIP_ID ?? 17715)
                       ->value("IS_CRUISER");
            $otherCharts = new PersonalDaily();
            $averageLootForTierType = DB::table("runs")
                ->where("TIER", $data->TIER)
                ->where("TYPE", $data->TYPE)
                ->where("SURVIVED", true)
                ->avg("LOOT_ISK");


            $medianLootForTier = DB::select("SELECT AVG(dd.LOOT_ISK) as MEDIAN
FROM (
SELECT d.LOOT_ISK, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
  FROM runs d, (SELECT @rownum:=0) r
  WHERE d.LOOT_ISK is NOT NULL
  and d.TIER=? and d.SURVIVED=1 and d.SHIP_ID in (select ID from ship_lookup where IS_CRUISER=?)
  ORDER BY d.LOOT_ISK
) as dd
WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );", [$data->TIER, $isCruiser])[0]->MEDIAN;


            $averageLootForTierTypeCruiser = DB::table("runs")
                ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                ->whereNotNull("runs.SHIP_ID")
                ->where("ship_lookup.IS_CRUISER", "1")
                ->where("runs.TIER", $data->TIER)
                ->where("runs.TYPE", $data->TYPE)
                ->where("runs.SURVIVED", true)
                ->avg("LOOT_ISK");


            $averageLootForTierTypeFrigate = DB::table("runs")
                ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                ->whereNotNull("runs.SHIP_ID")
                ->where("ship_lookup.IS_CRUISER", "0")
                ->where("runs.TIER", $data->TIER)
                ->where("runs.TYPE", $data->TYPE)
                ->where("runs.SURVIVED", true)
                ->avg("LOOT_ISK");

            $medianLootForTierCruiser =  DB::select("SELECT AVG(dd.LOOT_ISK) as MEDIAN
FROM (
SELECT d.LOOT_ISK, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
  FROM runs d, (SELECT @rownum:=0) r
  WHERE d.LOOT_ISK is NOT NULL
  and d.TIER=? and d.SURVIVED=1 and d.SHIP_ID in (select ID from ship_lookup where IS_CRUISER=?)
  ORDER BY d.LOOT_ISK
) as dd
WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );", [$data->TIER, 1])[0]->MEDIAN;


            $medianLootForTierFrigate =  DB::select("SELECT AVG(dd.LOOT_ISK) as MEDIAN
FROM (
SELECT d.LOOT_ISK, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
  FROM runs d, (SELECT @rownum:=0) r
  WHERE d.LOOT_ISK is NOT NULL
  and d.TIER=? and d.SURVIVED=1 and d.SHIP_ID in (select ID from ship_lookup where IS_CRUISER=?)
  ORDER BY d.LOOT_ISK
) as dd
WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );", [$data->TIER, 0])[0]->MEDIAN;

            if ($data->SHIP_NAME) {
                $averageLootForTierTypeShip = DB::table("v_runall")
                    ->where("TIER", $data->TIER)
                    ->where("TYPE", $data->TYPE)
                    ->where("SURVIVED", true)
                    ->where("SHIP_NAME", $data->SHIP_NAME)
                    ->avg("LOOT_ISK");
                $averageLootForTierShip = DB::table("v_runall")
                    ->where("TIER", $data->TIER)
                    ->where("SURVIVED", true)
                    ->where("SHIP_NAME", $data->SHIP_NAME)
                    ->avg("LOOT_ISK");
                $otherCharts->dataset(sprintf("%s tier %s ".$data->SHIP_NAME, $data->TYPE, $data->TIER), 'bar', [round($averageLootForTierTypeShip / 1000000, 2)]);
                $otherCharts->dataset(sprintf("Tier %s ".$data->SHIP_NAME, $data->TIER), 'bar', [round($averageLootForTierShip / 1000000, 2)]);
            }

            if ($data->PUBLIC) {
                $averageLootForTierTypeChar = DB::table("v_runall")
                    ->where("TIER", $data->TIER)
                    ->where("TYPE", $data->TYPE)
                    ->where("SURVIVED", true)
                    ->where("CHAR_ID", $data->CHAR_ID)
                    ->avg("LOOT_ISK");
                $averageLootForTierChar = DB::table("v_runall")
                    ->where("TIER", $data->TIER)
                    ->where("SURVIVED", true)
                    ->where("CHAR_ID", $data->CHAR_ID)
                    ->avg("LOOT_ISK");
                $otherCharts->dataset(sprintf("%s tier %s (%s)", $data->TYPE, $data->TIER, $data->NAME), 'bar', [round($averageLootForTierTypeChar / 1000000, 2)]);
                $otherCharts->dataset(sprintf("Tier %s (%s)", $data->TIER, $data->NAME), 'bar', [round($averageLootForTierChar / 1000000, 2)]);
            }

            $otherCharts->dataset(sprintf("%s tier %s all", $data->TYPE, $data->TIER), 'bar', [round($averageLootForTierType / 1000000, 2)]);
            $otherCharts->dataset(sprintf("%s tier %s cruiser", $data->TYPE, $data->TIER), 'bar', [round($averageLootForTierTypeCruiser/ 1000000, 2)]);
            $otherCharts->dataset(sprintf("%s tier %s frigates", $data->TYPE, $data->TIER), 'bar', [round($averageLootForTierTypeFrigate/ 1000000, 2)]);
            $otherCharts->dataset(sprintf("%s tier cruiser (median)",  $data->TIER), 'bar', [round($medianLootForTierCruiser/ 1000000, 2)]);
            $otherCharts->dataset(sprintf("%s tier frigates (median)",  $data->TIER), 'bar', [round($medianLootForTierFrigate/ 1000000, 2)]);
            $otherCharts->dataset(sprintf("Tier %s (median)", $data->TIER), 'bar', [round($medianLootForTier / 1000000, 2)]);
            $otherCharts->dataset(sprintf("This run"), 'bar', [round($data->LOOT_ISK / 1000000, 2)]);
            $otherCharts->theme(ThemeController::getChartTheme());
            $otherCharts->displayAxes(true);
            $otherCharts->displayLegend(true);
            $otherCharts->export(true, "Download");


            if ($data->SHIP_NAME) {
                $group = DB::table("ship_lookup")->where("NAME", $data->SHIP_NAME)->value("IS_CRUISER");
                switch ($group) {
                    case 1:
                        $medianLootForTier = $medianLootForTierCruiser;
                        break;
                    case 0:
                        $medianLootForTier = $medianLootForTierFrigate;
                        break;

                }
            }

            return [$otherCharts, $medianLootForTier];

        }
    }
