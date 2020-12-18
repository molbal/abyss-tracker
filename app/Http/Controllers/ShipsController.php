<?php


    namespace App\Http\Controllers;


    use App\Charts\AbyssSurvivalType;
    use App\Charts\LootAveragesChart;
    use App\Charts\LootTierChart;
    use App\Charts\LootTypesChart;
    use App\Charts\PersonalDaily;
    use App\Charts\ShipCruiserChart;
    use App\Charts\ShipDestroyerChart;
    use App\Charts\ShipFrigateChart;
    use App\Http\Controllers\Loot\LootCacheController;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class ShipsController extends Controller {
        public const PIE_RADIUS = [45, 135];
        public const PIE_RADIUS_SMALL = [25, 95];

        /** @var LootCacheController */
        private $lootCacheController;

        /** @var BarkController */
        private $barkController;

        /** @var ItemController */
        private $itemController;

        /**
         * ShipsController constructor.
         *
         * @param LootCacheController $lootCacheController
         * @param BarkController      $barkController
         * @param ItemController      $itemController
         */
        public function __construct(LootCacheController $lootCacheController, BarkController $barkController, ItemController $itemController) {
            $this->lootCacheController = $lootCacheController;
            $this->barkController = $barkController;
            $this->itemController = $itemController;
        }


        /**
         * Handles the all ships view
         * TODO: Move chart renders to its respectible controllers
         * TODO: Make ship list types
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        function get_all() {

            [$query_cruiser, $shipCruiserChart] = $this->getAllShipsCruiersChart();
            [$query_frig, $shipFrigateChart] = $this->getAllShipsFrigatesChart();
            [$query_destroyer, $shipDestroyerChart] = $this->getAllShipsDestroyerChart();

            return view("ships", [
                "cruiser_chart" => $shipCruiserChart,
                "frigate_chart" => $shipFrigateChart,
                "destroyer_chart" => $shipDestroyerChart,
                "query_cruiser" => $query_cruiser,
                "query_frigate" => $query_frig,
                "query_destroyer" => $query_destroyer,
            ]);
        }


        function get_single(int $id) {

            $name = DB::table("ship_lookup")->where("ID", $id)->value("NAME");
            $pop = $this->getShipPopularityChart($id, $name);

            $all_runs = DB::table("runs")
                ->where("SHIP_ID", $id)
                ->count();

            $all_survived = DB::table("runs")
                ->where("SHIP_ID", $id)
                ->where("SURVIVED", true)
                ->count();

            $all_dead = DB::table("runs")
                ->where("SHIP_ID", $id)
                ->where("SURVIVED", false)
                ->count();

            [$chart_tiers, $i, $all_ship_runs, $all_runs, $percent] = $this->getShipTierChart($id, $name);
            [$chart_types, $all_runs] = $this->getShipTypeChart($id, $name);

            $items = DB::table("runs")
                ->where("SHIP_ID", $id)
                ->orderBy("CREATED_AT", 'DESC')
                ->paginate(25);

            [$death_reasons, $labels, $data, $reason, $death_reason] = $this->getShipDeathReasons($id);
            $loot_chart = $this->getShipLootStrategyChart($id);


            $priceChart = $this->itemController->itemMarketHistoryChart($id);

            return view("ship", [
                "id"           => $id,
                "name"         => $name,
                "pop_chart"    => $pop,
                "all_runs"     => $all_runs,
                "all_survived" => $all_survived,
                "all_dead"     => $all_dead,
                "pop_tiers"    => $chart_tiers,
                "pop_types"    => $chart_types,
                "items" => $items,
                "death_chart" => $death_reason,
                "loot_chart" => $loot_chart,
                'priceChart' => $priceChart
            ]);
        }

        /**
         * @param int $id
         * @param     $name
         * @return PersonalDaily
         */
        public function getShipPopularityChart(int $id, $name): PersonalDaily {
            [$dates, $values, $dead] = Cache::remember("ship.popularity.$id", now()->addHour(), function() use ($id, $name) {
                $dates = [];
                $values = [];
                $dead = [];
                for ($i = -90; $i <= 0; $i++) {
                    $date = strtotime("now $i days");
                    $val = DB::select("select
                            (select count(ID) from runs where RUN_DATE>=? and RUN_DATE<=?) as 'ALL',
                            (select count(ID) from runs where RUN_DATE>=? and RUN_DATE<=? and SHIP_ID=?) as 'SHIP',
                            (select count(ID) from runs where RUN_DATE>=? and RUN_DATE<=? and SHIP_ID=? and SURVIVED=0) as 'DEAD';",
                        [
                            (new Carbon($date))->addDays(-3),
                            (new Carbon($date))->addDays(+3),
                            (new Carbon($date))->addDays(-3),
                            (new Carbon($date))->addDays(+3),
                            $id,
                            (new Carbon($date))->addDays(-3),
                            (new Carbon($date))->addDays(+3),
                            $id
                        ]);
                    $dates[] = date("M.d.", $date);
                    if ($val[0]->ALL == 0) {
                        $values[] = 0.0;
                        $dead[] = 0.0;
                    }
                    else {
                        $values[] = round(($val[0]->SHIP / $val[0]->ALL) * 100, 2);
                        $dead[] = round(($val[0]->DEAD / ($val[0]->SHIP > 0 ? $val[0]->SHIP : 1)) * 100, 2);
                    }
                }
                return [$dates, $values, $dead];
            });

            $pop = new PersonalDaily();
            $pop->displayAxes(true);
            $pop->export(true, "Download");
            $pop->height(200);
            $pop->theme(ThemeController::getChartTheme());
            $pop->displayLegend(true);
            $pop->labels($dates);
            $pop->options([
                'tooltip' => [
                    'trigger' => "axis"
                ]
            ]);
            $pop->dataset("Popularity of $name (Percentage of all runs)", "line", $values)->options([
                'smooth'         => true,
                'symbolSize'     => 0,
                'smoothMonotone' => 'x',
                'tooltip'        => [
                    'trigger' => "axis"
                ]
            ]);
            $pop->dataset("Failure ratio of $name (Percentage of failed runs)", "line", $dead)->options([
                'smooth'         => true,
                'symbolSize'     => 0,
                'smoothMonotone' => 'x',
                'color'          => 'red',
                'tooltip'        => [
                    'trigger' => "axis"
                ]
            ]);
            return $pop;
        }

        /**
         * @param int $id
         * @param     $name
         * @return array
         */
        public function getShipTierChart(int $id, $name): array {
            $chart_tiers = new LootTierChart();
            $chart_tiers->displayLegend(false);
            $chart_tiers->displayAxes(false);
            $chart_tiers->export(true, "Download");
            $chart_tiers->height(270);
            $chart_tiers->theme(ThemeController::getChartTheme());
            $chart_tiers->labels([$name, "Other"]);


            $series = [];
            for ($i = 1; $i <= 5; $i++) {
                $all_ship_runs = DB::table("v_ship_run_percent")
                    ->where("SHIP_ID", $id)
                    ->where("TIER", $i)
                    ->sum("SHIP_RUNS");
                $all_runs = DB::table("v_tt_run_count")
                    ->where("TIER", $i)
                    ->sum("RUNS");
                $percent = round($all_ship_runs / $all_runs * 100, 2);
                $chart_tiers->dataset("Tier $i", "line", [$percent, 100 - $percent])->options([
                    "stack"    => $i,
                    "roseType" => 'area'
                ]);
                $series[$i - 1] = [
                    'name'     => "Tier $i",
                    'type'     => "pie",
                    'radius'   => [0 => 20, 1 => 60],
                    'center'   => [0 => (($i - 1) * 20 + 10) . "%", 1 => '50%'],
                    'roseType' => 'rose',
                    'label'    => ['show' => true],
                    'emphasis' => ['label' => ['show' => true, 'alignTo' => "labelLine"]],
                    'data'     => [
                        0 => [
                            'value' => $percent,
                            'name'  => $name
                        ],
                        1 => [
                            'value' => round(100 - $percent, 2),
                            'name'  => 'Other'
                        ]
                    ]
                ];
            }
            $chart_tiers->dataset("", "pie", []);
            $chart_tiers->options([
                'title'   => [
                    [
                        'subtext'   => 'Tier 1 (Calm)',
                        'left'      => '10%',
                        'top'       => '1%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series[0]['data']['0']['value']."%",
                        'left'      => '10%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => 'Tier 2 (Agitated)',
                        'left'      => '30%',
                        'top'       => '1%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series[1]['data']['0']['value']."%",
                        'left'      => '30%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => 'Tier 3 (Fierce)',
                        'left'      => '50%',
                        'top'       => '1%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series[2]['data']['0']['value']."%",
                        'left'      => '50%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => 'Tier 4 (Raging)',
                        'left'      => '70%',
                        'top'       => '1%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series[3]['data']['0']['value']."%",
                        'left'      => '70%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => 'Tier 5 (Chaotic)',
                        'left'      => '90%',
                        'top'       => '1%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series[4]['data']['0']['value']."%",
                        'left'      => '90%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ]
                ],
                'tooltip' =>
                    [
                        'trigger'   => 'item',
                        'formatter' => '{a} <br/>{b} usage: {c}%',
                    ],
                'legend'  =>
                    [
                        'left' => 'center',
                        'top'  => 'bottom',
                        'data' =>
                            [
                                0 => $name,
                                1 => 'Other',
                            ],
                    ],
                'toolbox' =>
                    [
                        'show'    => true,
                        'feature' =>
                            [
                                'mark'      =>
                                    [
                                        'show' => true,
                                    ],
                                'magicType' =>
                                    [
                                        'show' => true,
                                        'type' =>
                                            [
                                                0 => 'funnel',
                                                1 => 'funnel',
                                            ],
                                    ]
                            ],
                    ],
                'series'  =>
                    $series, 3
            ]);
            return [$chart_tiers, $i, $all_ship_runs, $all_runs, $percent];
        }

        /**
         * @param int $id
         * @param     $name
         * @return array
         */
        public function getShipTypeChart(int $id, $name): array {
            $chart_types = new LootTypesChart();
            $chart_types->displayLegend(false);
            $chart_types->displayAxes(false);
            $chart_types->export(true, "Download");
            $chart_types->height(270);
            $chart_types->theme(ThemeController::getChartTheme());
            $chart_types->labels([$name, "Other"]);

            $series_t = [];
            $c = 0;
            foreach (['Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma'] as $i) {
                $all_ship_runs = DB::table("v_ship_run_percent")
                    ->where("SHIP_ID", $id)
                    ->where("TYPE", $i)
                    ->sum("SHIP_RUNS");
                $all_runs = DB::table("v_tt_run_count")
                    ->where("TYPE", $i)
                    ->sum("RUNS");
                $percent = round($all_ship_runs / max(1, $all_runs) * 100, 2);
                $series_t[$c] = [
                    'name'     => "$i",
                    'type'     => "pie",
                    'radius'   => [0 => 20, 1 => 60],
                    'center'   => [0 => (($c) * 20 + 10) . "%", 1 => '50%'],
                    'roseType' => 'rose',
                    'label'    => ['show' => true],
                    'emphasis' => ['label' => ['show' => true, 'alignTo' => "labelLine"]],
                    'data'     => [
                        0 => [
                            'value' => $percent,
                            'name'  => $name
                        ],
                        1 => [
                            'value' => round(100 - $percent, 2),
                            'name'  => 'Other'
                        ]
                    ]
                ];
                $c++;
            }
            $chart_types->dataset("", "pie", []);
            $chart_types->options([
                'title'   => [
                    [
                        'subtext'   => 'Electrical',
                        'left'      => '10%',
                        'top'       => '1%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series_t[0]['data']['0']['value']."%",
                        'left'      => '10%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => 'Dark',
                        'left'      => '30%',
                        'top'       => '1%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series_t[1]['data']['0']['value']."%",
                        'left'      => '30%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => 'Exotic',
                        'left'      => '50%',
                        'top'       => '1',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series_t[2]['data']['0']['value']."%",
                        'left'      => '50%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => 'Firestorm',
                        'left'      => '70%',
                        'top'       => '1%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series_t[3]['data']['0']['value']."%",
                        'left'      => '70%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => 'Gamma',
                        'left'      => '90%',
                        'top'       => '1%',
                        'textAlign' => 'center'
                    ],
                    [
                        'subtext'   => $series_t[4]['data']['0']['value']."%",
                        'left'      => '90%',
                        'top'       => '10%',
                        'textAlign' => 'center'
                    ]
                ],
                'tooltip' =>
                    [
                        'trigger'   => 'item',
                        'formatter' => '{a} <br/>{b} usage: {c}%',
                    ],
                'legend'  =>
                    [
                        'left' => 'center',
                        'top'  => 'bottom',
                        'data' =>
                            [
                                0 => $name,
                                1 => 'Other',
                            ],
                    ],
                'toolbox' =>
                    [
                        'show'    => true,
                        'feature' =>
                            [
                                'mark'      =>
                                    [
                                        'show' => true,
                                    ],
                                'magicType' =>
                                    [
                                        'show' => true,
                                        'type' =>
                                            [
                                                0 => 'funnel',
                                                1 => 'funnel',
                                            ],
                                    ]
                            ],
                    ],
                'series'  =>
                    $series_t, 3
            ]);
            return [$chart_types, $all_runs];
        }

        /**
         * @return array
         */
        public function getAllShipsFrigatesChart(): array {
            $query_frig = Cache::remember("ships.frigates", now()->addMinutes(20), function() {
                return DB::select("select count(r.ID) as RUNS, l.Name as NAME, l.ID as SHIP_ID, l.GROUP
                    from runs r inner join ship_lookup l on r.SHIP_ID=l.ID
                    where l.HULL_SIZE='frigate'
                    group by r.SHIP_ID, l.NAME, l.ID,  l.GROUP
                    order by 1 desc
                    limit 15");
            });

            $dataset = [];
            $values = [];
            foreach ($query_frig as $type) {
                $i = 7;
                if ($i-- == 0) break;
                $dataset[] = $type->NAME;
                $values[] = $type->RUNS;
            }


            $shipFrigateChart = new ShipFrigateChart();
            $shipFrigateChart->export(true, "Download");
            $shipFrigateChart->displayAxes(false);
            $shipFrigateChart->height(400);
            $shipFrigateChart->theme(ThemeController::getChartTheme());
            $shipFrigateChart->labels($dataset);
            $shipFrigateChart->dataset("Frigates", "pie", $values)->options([
                "radius"   => self::PIE_RADIUS,
                "roseType" => "radius",
                'label' => [
                    'position' => 'outer',
                    'alignTo' => 'none',
                    'bleedMargin' => 5
                ]
            ]);
            $shipFrigateChart->displayLegend(false);
            return [$query_frig, $shipFrigateChart];
        }

        public function getAllShipsDestroyerChart(): array {
            $shipDestroyerDataset = Cache::remember("ships.destroyers", now()->addMinutes(20), function() {
                return DB::select("select count(r.ID) as RUNS, l.Name as NAME, l.ID as SHIP_ID, l.GROUP
                    from runs r inner join ship_lookup l on r.SHIP_ID=l.ID
                    where l.HULL_SIZE='destroyer'
                    group by r.SHIP_ID, l.NAME, l.ID,  l.GROUP
                    order by 1 desc
                    limit 15");
            });

            $dataset = [];
            $values = [];
            foreach ($shipDestroyerDataset as $type) {
                $i = 7;
                if ($i-- == 0) break;
                $dataset[] = $type->NAME;
                $values[] = $type->RUNS;
            }


            $shipDestroyerChart = new ShipDestroyerChart();
            $shipDestroyerChart->export(true, "Download");
            $shipDestroyerChart->displayAxes(false);
            $shipDestroyerChart->height(400);
            $shipDestroyerChart->theme(ThemeController::getChartTheme());
            $shipDestroyerChart->labels($dataset);
            $shipDestroyerChart->dataset("Destroyers", "pie", $values)->options([
                "radius"   => self::PIE_RADIUS,
                "roseType" => "radius",
                'label' => [
                    'position' => 'outer',
                    'alignTo' => 'none',
                    'bleedMargin' => 5
                ]
            ]);
            $shipDestroyerChart->displayLegend(false);
            return [$shipDestroyerDataset, $shipDestroyerChart];
        }
        /**
         * @return array
         */
        public function getAllShipsCruiersChart(): array {
            $query_cruiser = Cache::remember("ships.cruisers", now()->addMinutes(20), function() {
                return DB::select("select count(r.ID) as RUNS, l.Name as NAME, l.ID as SHIP_ID, l.GROUP
                    from runs r inner join ship_lookup l on r.SHIP_ID=l.ID
                    where l.HULL_SIZE='cruiser'
                    group by r.SHIP_ID, l.NAME, l.ID,  l.GROUP
                    order by 1 desc
                    limit 15");
            });

            $dataset = [];
            $values = [];
            $i = 7;
            foreach ($query_cruiser as $type) {
                if ($i-- == 0) break;
                $dataset[] = $type->NAME;
                $values[] = $type->RUNS;
            }

            $shipCruiserChart = new ShipCruiserChart();
            $shipCruiserChart->export(true, "Download");
            $shipCruiserChart->displayAxes(false);
            $shipCruiserChart->height(400);
            $shipCruiserChart->theme(ThemeController::getChartTheme());
            $shipCruiserChart->labels($dataset);
            $shipCruiserChart->dataset("Cruisers", "pie", $values)->options([
                "radius"   => self::PIE_RADIUS,
                "roseType" => "radius",
                'label' => [
                    'position' => 'outer',
                    'alignTo' => 'none',
                    'bleedMargin' => 5
                ]
            ]);
            $shipCruiserChart->displayLegend(false);
            return [$query_cruiser, $shipCruiserChart];
        }

        /**
         * @param int $id
         * @return array
         */
        public function getShipDeathReasons(int $id): array {
            $death_reasons = DB::table("runs")
                ->where("SHIP_ID", $id)
                ->whereNotNull("DEATH_REASON")
                ->where("SURVIVED", false)
                ->selectRaw("count(ID) as CNT, DEATH_REASON")
                ->groupBy("DEATH_REASON")
                ->get();
            $labels = [];
            $data = [];
            foreach ($death_reasons as $reason) {
                $labels[] = $this->barkController->getDeathReasonQQuickBark($reason->DEATH_REASON);
                $data[] = $reason->CNT;
            }

            $death_reason = new AbyssSurvivalType();
            $death_reason->displayAxes(false);
            $death_reason->export(true, "Download");
            $death_reason->height(400);
            $death_reason->theme(ThemeController::getChartTheme());
            $death_reason->displayLegend(true);
            $death_reason->labels($labels);
            $death_reason->dataset("Death reason", "pie", $data)->options([
                'radius' => self::PIE_RADIUS_SMALL
            ]);
            return [$death_reasons, $labels, $data, $reason ?? null, $death_reason];
        }

        /**
         * @param int $id
         * @return LootAveragesChart
         */
        public function getShipLootStrategyChart(int $id): LootAveragesChart {
            $loot_strategy = DB::table("runs")
                ->where("SHIP_ID", $id)
                ->whereNotNull("LOOT_TYPE")
                ->where("SURVIVED", true)
                ->selectRaw("count(ID) as CNT, LOOT_TYPE")
                ->groupBy("LOOT_TYPE")
                ->get();

            $labels = [];
            $data = [];
            foreach ($loot_strategy as $reason) {
                $labels[] = ucfirst(trim(str_ireplace("Looted the", "", $this->barkController->getLootStrategyDescription($reason))));
                $data[] = $reason->CNT;
            }
            $loot_chart = new LootAveragesChart();
            $loot_chart->displayAxes(false);
            $loot_chart->export(true, "Download");
            $loot_chart->height(400);
            $loot_chart->theme(ThemeController::getChartTheme());
            $loot_chart->displayLegend(true);
            $loot_chart->labels($labels);
            $loot_chart->dataset("Looting strategy", "pie", $data)->options([
                'radius' => self::PIE_RADIUS_SMALL
            ]);
            return $loot_chart;
        }
    }
