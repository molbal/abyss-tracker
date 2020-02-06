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
            $loot_tier_chart->displayLegend(false);

            return $loot_tier_chart;
        }

        /**
         * @return array
         */
        public function getHomeDailyRunCounts() : array
        {
            $adds = DB::table("runs")->selectRaw("count(ID) as CNT")->selectRaw('RUN_DATE')->whereRaw("RUN_DATE > NOW() - INTERVAL 2 WEEK")->orderBy("RUN_DATE", "ASC")->groupBy("RUN_DATE")->get();


            $count = [];
            $run_date = [];
            foreach ($adds as $add) {
                $run_date[] = date("m. d", strtotime($add->RUN_DATE));
                $count[] = $add->CNT;
            }
            $daily_add_chart = new DailyAdds();
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date)->dataset("Daily abyss run count", "bar", $count);
            $daily_add_chart->theme(ThemeController::getChartTheme());
            $daily_add_chart->displayLegend(false);

            return [$count, $daily_add_chart];
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
            $explodeCharts = new AbyssSurvivalType();
            $explodeCharts->labels(["Failures", "Successes"]);
            $explodeCharts->dataset(sprintf("%s tier %s survival ratio", $data->TYPE, $data->TIER), 'pie', [
                DB::table("runs")->where("TIER", $data->TIER)->where("TYPE", $data->TYPE)->where("SURVIVED", false)->count(),
                DB::table("runs")->where("TIER", $data->TIER)->where("TYPE", $data->TYPE)->where("SURVIVED", true)->count()]);
            $explodeCharts->theme(ThemeController::getChartTheme());
            $explodeCharts->displayAxes(false);
            $explodeCharts->displayLegend(false);

            $otherCharts = new RunBetter();
            $averageLootForTierType = DB::table("runs")->where("TIER", $data->TIER)->where("TYPE", $data->TYPE)->where("SURVIVED", true)->avg("LOOT_ISK");
            $averageLootForTier = DB::table("runs")->where("TIER", $data->TIER)->where("SURVIVED", true)->avg("LOOT_ISK");
            $otherCharts->dataset(sprintf("%s tier %s avg. loot (" . round($averageLootForTierType / 1000000, 2) . "M ISK)", $data->TYPE, $data->TIER), 'bar', [round($averageLootForTierType / 1000000, 2)]);
            $otherCharts->dataset(sprintf("Tier %s avg. loot (" . round($averageLootForTier / 1000000, 2) . "M ISK)", $data->TIER), 'bar', [round($averageLootForTier / 1000000, 2)]);
            $otherCharts->dataset(sprintf("This run's loot (" . round($data->LOOT_ISK / 1000000, 2) . "M ISK)"), 'bar', [round($data->LOOT_ISK / 1000000, 2)]);
            $otherCharts->theme(ThemeController::getChartTheme());
            $otherCharts->displayAxes(true);
            $otherCharts->displayLegend(true);
            return [$explodeCharts, $otherCharts, $averageLootForTier];
        }
    }
