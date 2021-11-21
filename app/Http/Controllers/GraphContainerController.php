<?php


    namespace App\Http\Controllers;


    use App\Charts\BellChart1;
    use App\Charts\DailyAdds;
    use App\Charts\HomeCruiserMedian;
    use App\Charts\HomePagePopularClasses;
    use App\Charts\HomePagePopularHulls;
    use App\Charts\PersonalDaily;
    use App\Charts\SurvivalLevelChart;
    use App\Charts\TierLevelsChart;
    use App\Http\Controllers\Misc\Enums\ShipHullSize;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class GraphContainerController
    {


        public function getLootBellGraphs(int $tier, bool $isCruiser = true, int $thisRun = 0): BellChart1 {

            $chart = new BellChart1();

            $chart->export(true, "Download");
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
         * @return BellChart1
         */
        public function getHomeLootAveragesCruisers() : HomeCruiserMedian
        {

            $chart = new HomeCruiserMedian();
            $chart->export(true, "Download");
            $chart->height("400");
            $chart->theme(ThemeController::getChartTheme());
            $chart->load(route("chart.home.distribution.cruisers"));
            $labels = collect([]);
            for ($i = 0; $i<=6; $i++) {
                $labels->add("Tier {$i}");
            }
            $chart->labels($labels);
            $chart->options([
                'yAxis' =>  [
                    'axisLabel' => [
                        'formatter' => '{value} M ISK'
                    ]
                ]
            ]);
            return $chart;
        }



        /**
         * @return array
         */
        public function getHomeDailyRunCounts() : object
        {

            [$run_date, $count_unknown, $count_cruiser, $count_frigate, $rolling_avg_week, $rolling_avg_month, $count_destroyer] = Cache::remember("chart.daily_run_count", now()->addMinutes(15), function () {

                $run_date = [];
                $count_unknown = [];
                $count_cruiser = [];
                $count_frigate = [];
                $count_destroyer = [];
                $rolling_avg_week = [];
                $rolling_avg_month = [];
                for ($days = -60; $days <= 0; $days++) {
                    $timestamp = strtotime("now $days days");
                    $timestamp_week_older = strtotime("now " . ($days - 7) . " days");
                    $timestamp_month_older = strtotime("now " . ($days - 30) . " days");
                    $run_date[] = date("m. d.", $timestamp);
                    $count_unknown[] = DB::table("runs")
                                         ->whereNull("SHIP_ID")
                                         ->where("RUN_DATE", date("Y-m-d", $timestamp))
                                         ->groupBy("RUN_DATE")
                                         ->count();

                    $count_cruiser[] = DB::table("runs")
                                         ->whereNotNull("runs.SHIP_ID")
                                         ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                                         ->where("ship_lookup.HULL_SIZE", ShipHullSize::CRUISER)
                                         ->where("RUN_DATE", date("Y-m-d", $timestamp))
                                         ->groupBy("RUN_DATE")
                                         ->count();

                    $count_frigate[] = DB::table("runs")
                                         ->whereNotNull("runs.SHIP_ID")
                                         ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                                         ->where("ship_lookup.HULL_SIZE", ShipHullSize::FRIGATE)
                                         ->where("RUN_DATE", date("Y-m-d", $timestamp))
                                         ->groupBy("RUN_DATE")
                                         ->count();

                    $count_destroyer[] = DB::table("runs")
                                         ->whereNotNull("runs.SHIP_ID")
                                         ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                                         ->where("ship_lookup.HULL_SIZE", ShipHullSize::DESTROYER)
                                         ->where("RUN_DATE", date("Y-m-d", $timestamp))
                                         ->groupBy("RUN_DATE")
                                         ->count();

                    $rolling_avg_week[] = round(DB::table("runs")
                                                  ->where("RUN_DATE", '<=', date("Y-m-d", $timestamp))
                                                  ->where("RUN_DATE", '>', date("Y-m-d", $timestamp_week_older))
                                                  ->count() / 7, 2);
                    $rolling_avg_month[] = round(DB::table("runs")
                                                   ->where("RUN_DATE", '<=', date("Y-m-d", $timestamp))
                                                   ->where("RUN_DATE", '>', date("Y-m-d", $timestamp_month_older))
                                                   ->count() / 30, 2);
                }

                return [$run_date, $count_unknown, $count_cruiser, $count_frigate, $rolling_avg_week, $rolling_avg_month, $count_destroyer];
            });

            $daily_add_chart = new DailyAdds();
            $daily_add_chart->displayAxes(true)->export(true)->height(400)->labels($run_date);
            $daily_add_chart->dataset("Unspecified runs", "bar", $count_unknown)->options(["stack" => "1"]);
            $daily_add_chart->dataset("Cruiser runs", "bar", $count_cruiser)->options(["stack" => "1"]);
            $daily_add_chart->dataset("Destroyer runs", "bar", $count_destroyer)->options(["stack" => "1"]);
            $daily_add_chart->dataset("Frigate runs", "bar", $count_frigate)->options(["stack" => "1"]);
            $daily_add_chart->dataset("7 day avg", "line", $rolling_avg_week)->options(['smooth' => 0.001, 'symbolSize' => 0]);
            $daily_add_chart->dataset("30 day avg", "line", $rolling_avg_month)->options(['smooth' => 0.001, 'symbolSize' => 0]);
            $daily_add_chart->theme(ThemeController::getChartTheme());
            $daily_add_chart->displayLegend(true);
            $daily_add_chart->options([
                'symbolSize'     => 0,
                'smoothMonotone' => 'x',
                'tooltip'        => [
                    'trigger' => "axis"
                ]
            ]);

            return $daily_add_chart;
        }


//        /**
//         * Returns charts for the Personal Stats screen
//         * @param array $labels
//         * @return PersonalDaily
//         */
//        public function getPersonalStatsCharts(): PersonalDaily {
//            $personalDaily = new PersonalDaily();
//            $personalDaily->load(route("chart.personal.loot"));
//            $personalDaily->displayAxes(true);
//            $personalDaily->displayLegend(true);
//            $personalDaily->export(true, "Download");
//            $personalDaily->height("400");
//            $personalDaily->theme(ThemeController::getChartTheme());
//
//
//            $labels = [];
//            for($i=-30; $i<=0; $i++) {
//                $labels[] = date("m.d", strtotime("now $i days"));
//            }
//            $personalDaily->labels($labels);
//
//            return $personalDaily;
//        }


        /**
         * Gets single run graphs
         * @param $data
         * @return array
         */
        public function getRunGraphs($data): array {
            $hullSize = DB::table("ship_lookup")
                       ->where("ID", $data->SHIP_ID ?? 17715)
                       ->value("HULL_SIZE");
            $otherCharts = new PersonalDaily();

            $medianLootForTier = DB::select("SELECT AVG(dd.LOOT_ISK) as MEDIAN
FROM (
SELECT d.LOOT_ISK, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
  FROM runs d, (SELECT @rownum:=0) r
  WHERE d.LOOT_ISK is NOT NULL
  and d.TIER=? and d.SURVIVED=1 and d.SHIP_ID in (select ID from ship_lookup where HULL_SIZE=?)
  ORDER BY d.LOOT_ISK
) as dd
WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );", [$data->TIER, $hullSize])[0]->MEDIAN ?? 0;


            $medianLootForTierCruiser =  DB::select("SELECT AVG(dd.LOOT_ISK) as MEDIAN
FROM (
SELECT d.LOOT_ISK, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
  FROM runs d, (SELECT @rownum:=0) r
  WHERE d.LOOT_ISK is NOT NULL
  and d.TIER=? and d.SURVIVED=1 and d.SHIP_ID in (select ID from ship_lookup where HULL_SIZE=?)
  ORDER BY d.LOOT_ISK
) as dd
WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );", [$data->TIER,  ShipHullSize::CRUISER])[0]->MEDIAN ?? 0;


            $medianLootForTierDestroyer =  DB::select("SELECT AVG(dd.LOOT_ISK) as MEDIAN
FROM (
SELECT d.LOOT_ISK, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
  FROM runs d, (SELECT @rownum:=0) r
  WHERE d.LOOT_ISK is NOT NULL
  and d.TIER=? and d.SURVIVED=1 and d.SHIP_ID in (select ID from ship_lookup where HULL_SIZE=?)
  ORDER BY d.LOOT_ISK
) as dd
WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );", [$data->TIER, ShipHullSize::DESTROYER])[0]->MEDIAN ?? 0;

            $medianLootForTierFrigate =  DB::select("SELECT AVG(dd.LOOT_ISK) as MEDIAN
FROM (
SELECT d.LOOT_ISK, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
  FROM runs d, (SELECT @rownum:=0) r
  WHERE d.LOOT_ISK is NOT NULL
  and d.TIER=? and d.SURVIVED=1 and d.SHIP_ID in (select ID from ship_lookup where HULL_SIZE=?)
  ORDER BY d.LOOT_ISK
) as dd
WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );", [$data->TIER,  ShipHullSize::FRIGATE])[0]->MEDIAN ?? 0;

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

            $otherCharts->dataset(sprintf("%s tier cruiser (median)",  $data->TIER), 'bar', [round($medianLootForTierCruiser/ 1000000, 2)]);
            $otherCharts->dataset(sprintf("%s tier frigates (destroyer)",  $data->TIER), 'bar', [round($medianLootForTierDestroyer/ 1000000, 2)]);
            $otherCharts->dataset(sprintf("%s tier frigates (median)",  $data->TIER), 'bar', [round($medianLootForTierFrigate/ 1000000, 2)]);
            $otherCharts->dataset(sprintf("Tier %s (median)", $data->TIER), 'bar', [round($medianLootForTier / 1000000, 2)]);
            $otherCharts->dataset(sprintf("This run"), 'bar', [round($data->LOOT_ISK / 1000000, 2)]);
            $otherCharts->theme(ThemeController::getChartTheme());
            $otherCharts->displayAxes(true);
            $otherCharts->displayLegend(true);
            $otherCharts->export(true, "Download");


            if ($data->SHIP_NAME) {
                $group = DB::table("ship_lookup")->where("NAME", $data->SHIP_NAME)->value("HULL_SIZE");
                switch ($group) {
                    case  ShipHullSize::DESTROYER:
                        $medianLootForTier = $medianLootForTierDestroyer;
                        break;
                    case  ShipHullSize::CRUISER:
                        $medianLootForTier = $medianLootForTierCruiser;
                        break;
                    case  ShipHullSize::FRIGATE:
                        $medianLootForTier = $medianLootForTierFrigate;
                        break;

                }
            }

            return [$otherCharts, $medianLootForTier];

        }

        /**
         * Returns the homepage's most popular ship classes graph container
         * @return HomePagePopularHulls
         */
        public function getPopularShipsGraph() {
            $chart = new HomePagePopularHulls();
            $chart->load(route("chart.home.popular-hulls"));
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->export(true, "Download");
            $chart->height("300");
            $chart->theme(ThemeController::getChartTheme());
            $chart->options([
                "roseType" => "radius",
                'label' => [
                    'position' => 'inside',
                    'alignTo' => 'none',
                    'bleedMargin' => 5
                ],
                'tooltip'=> [
                    'confine' => true
                ]
            ]);

            return $chart;
        }

        public function getPopularShipsClasses() {
            $chart = new HomePagePopularClasses();
            $chart->load(route("chart.home.popular-classes"));
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->export(true, "Download");
            $chart->height("300");
            $chart->theme(ThemeController::getChartTheme());
            $chart->options([
                "roseType" => "radius",
                'label' => [
                    'position' => 'inside',
                    'alignTo' => 'none',
                    'bleedMargin' => 5
                ],
                'tooltip'=> [
                    'confine' => true
                ]
            ]);

            return $chart;
        }
    }
