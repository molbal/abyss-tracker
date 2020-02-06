<?php


    namespace App\Http\Controllers;


    use App\Charts\DailyAdds;
    use App\Charts\LootTierChart;
    use App\Charts\LootTypesChart;
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
    }
