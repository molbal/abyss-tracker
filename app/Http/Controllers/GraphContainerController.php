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
         * @return LootTierChart
         */
        public function getHomeLootAverages() : LootTierChart
        {
            $loot_tier_chart = new LootTierChart();
            $loot_tier_chart->load(route("chart.home.tier_averages"));
            $loot_tier_chart->export(true, "Download");
            $loot_tier_chart->displayAxes(true);
            $loot_tier_chart->height(400);
            $loot_tier_chart->labels(["Tier 1", "Tier 2", "Tier 3", "Tier 4", "Tier 5"]);
            $loot_tier_chart->theme(ThemeController::getChartTheme());
            $loot_tier_chart->displayLegend(true);

            return $loot_tier_chart;
        }

        /**
         * @return array
         */
        public function getHomeDailyRunCounts() : object
        {

            [$run_date, $count_unknown, $count_cruiser, $count_frigate] = Cache::remember("chart.daily_run_counts", 15, function () {

            $run_date = [];
            $count_unknown = [];
            $count_cruiser = [];
            $count_frigate = [];
            for ($days = -10; $days<=0; $days++) {

                $timestamp = strtotime("now $days days");
                $run_date[] = date("m. y.", $timestamp);
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
            }

            return [$run_date, $count_unknown, $count_cruiser, $count_frigate];
            });

            $daily_add_chart = new DailyAdds();
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date)->dataset("Unknown runs", "bar", $count_unknown)->options(["stack" => "1"]);
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date)->dataset("Cruiser runs", "bar", $count_cruiser)->options(["stack" => "1"]);
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date)->dataset("Frigate runs", "bar", $count_frigate)->options(["stack" => "1"]);
            $daily_add_chart->theme(ThemeController::getChartTheme());
            $daily_add_chart->displayLegend(true);

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
            $otherCharts = new RunBetter();
            $averageLootForTierType = DB::table("runs")
                ->where("TIER", $data->TIER)
                ->where("TYPE", $data->TYPE)
                ->where("SURVIVED", true)
                ->avg("LOOT_ISK");
            $averageLootForTier = DB::table("runs")
                ->where("TIER", $data->TIER)
                ->where("SURVIVED", true)
                ->avg("LOOT_ISK");

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

            $averageLootForTierCruiser = DB::table("runs")
                ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                ->whereNotNull("runs.SHIP_ID")
                ->where("ship_lookup.IS_CRUISER", "1")
                ->where("runs.TIER", $data->TIER)
                ->where("runs.SURVIVED", true)
                ->avg("LOOT_ISK");


            $averageLootForTierFrigate = DB::table("runs")
                ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                ->whereNotNull("runs.SHIP_ID")
                ->where("ship_lookup.IS_CRUISER", "0")
                ->where("runs.TIER", $data->TIER)
                ->where("runs.SURVIVED", true)
                ->avg("LOOT_ISK");

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
            $otherCharts->dataset(sprintf("%s tier cruiser",  $data->TIER), 'bar', [round($averageLootForTierCruiser/ 1000000, 2)]);
            $otherCharts->dataset(sprintf("%s tier frigates",  $data->TIER), 'bar', [round($averageLootForTierFrigate/ 1000000, 2)]);
            $otherCharts->dataset(sprintf("Tier %s all", $data->TIER), 'bar', [round($averageLootForTier / 1000000, 2)]);
            $otherCharts->dataset(sprintf("This run"), 'bar', [round($data->LOOT_ISK / 1000000, 2)]);
            $otherCharts->theme(ThemeController::getChartTheme());
            $otherCharts->displayAxes(true);
            $otherCharts->displayLegend(true);
            $otherCharts->export(true, "Download");
            return [$otherCharts, $averageLootForTier];
        }
    }
