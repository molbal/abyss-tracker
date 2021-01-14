<?php


    namespace App\Http\Controllers;


    use App\Charts\HomePagePopularClasses;
    use App\Charts\HomePagePopularHulls;
    use App\Charts\IskPerHourChart;
    use App\Charts\LootAveragesChart;
    use App\Charts\LootTierChart;
    use App\Charts\PersonalDaily;
    use App\Charts\BellChart1;
    use App\Charts\SurvivalLevelChart;
    use App\Charts\TierLevelsChart;
    use App\Http\Controllers\DS\MedianController;
    use App\Http\Controllers\Misc\Enums\ShipHullSize;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class GraphHelper extends Controller {


        /** @var BarkController */
        private $barkController;


        const HOME_PIE_RADIUS = [50, 90];

        /**
         * GraphHelper constructor.
         *
         * @param BarkController $barkController
         */
        public function __construct(BarkController $barkController) {
            $this->barkController = $barkController;
        }

        public function getFitLootStrategyChart(string $ids) {
            $ids_int = json_decode($ids, 1);
            $this->checkValidIds($ids_int);

            $loot_chart = new LootAveragesChart();
            $loot_strategy = DB::table("runs")
                               ->whereIn("FIT_ID", $ids_int)
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
            $loot_chart->labels($labels);
            $loot_chart->dataset("Looting strategy", "pie", $data)->options([
                'radius' => ShipsController::PIE_RADIUS_SMALL
            ]);

            return $loot_chart->api();
        }

        private function checkValidIds(array $ids_int) {
            foreach ($ids_int as $id) {
                if(!is_numeric($id)) {
                    throw new \InvalidArgumentException("IDs passed must be nulls");
                }
            }
        }

        public function getFitPopularityChart(string $ids, string $name) {
            $ids_int = json_decode($ids, 1);
            $this->checkValidIds($ids_int);
            [ $values, $dead] = Cache::remember("ship.popularity-ffh.".md5($ids), now()->addHour(), function() use ($ids_int, $name) {
                $values = [];
                $dead = [];
                for ($i = -90; $i <= 0; $i++) {
                    $query = "select
                            (select count(ID) from runs where RUN_DATE>=? and RUN_DATE<=?) as 'ALL',
                            (select count(ID) from runs where RUN_DATE>=? and RUN_DATE<=? and FIT_ID in (" . implode(",", $ids_int) . ")) as 'SHIP',
                            (select count(ID) from runs where RUN_DATE>=? and RUN_DATE<=? and FIT_ID in (" . implode(",", $ids_int) . ") and SURVIVED=0) as 'DEAD';";
                    $val = DB::select($query,
                        [
                            (new Carbon("now $i days"))->addDays(-3),
                            (new Carbon("now $i days"))->addDays(+3),
                            (new Carbon("now $i days"))->addDays(-3),
                            (new Carbon("now $i days"))->addDays(+3),
                            (new Carbon("now $i days"))->addDays(-3),
                            (new Carbon("now $i days"))->addDays(+3),
                        ]);
                    if ($val[0]->ALL == 0) {
                        $values[] = 0.0;
                        $dead[] = 0.0;
                    }
                    else {
                        $values[] = round(($val[0]->SHIP / $val[0]->ALL) * 100, 2);
                        $dead[] = round(($val[0]->DEAD / ($val[0]->SHIP > 0 ? $val[0]->SHIP : 1)) * 100, 2);
                    }
                }
                return [$values, $dead];
            });


            $pop = new PersonalDaily();

            $pop->dataset("Fit popularity (Percentage of all runs)", "line", $values)->options([
                'smooth'         => true,
                'symbolSize'     => 0,
                'smoothMonotone' => 'x',
                'tooltip'        => [
                    'trigger' => "axis"
                ]
            ]);
            $pop->dataset("Failure ratio (Percentage of failed runs)", "line", $dead)->options([
                'smooth'         => true,
                'symbolSize'     => 0,
                'smoothMonotone' => 'x',
                'color'          => 'red',
                'tooltip'        => [
                    'trigger' => "axis"
                ]
            ]);

            return $pop->api();
        }

        /**
         * @return string
         */
        public function getHomeRunBellGraphsCruisers(Request $request) {
            $chart = new BellChart1();
//sleep(5);

            $dataCruiser = collect([]);
            $dataDestroyer = collect([]);
            $dataFrigate = collect([]);

            for ($i = 0; $i<=6; $i++) {
                $dataCruiser->add(round(MedianController::getTierMedian($i, ShipHullSize::CRUISER) / 1000000, 2));
                $dataDestroyer->add(round(MedianController::getTierMedian($i, ShipHullSize::DESTROYER) / 1000000, 2));
                $dataFrigate->add(round(MedianController::getTierMedian($i, ShipHullSize::FRIGATE) / 1000000, 2));
            }

            $chart->dataset("Cruiser median loot", "bar", $dataCruiser);
            $chart->dataset("Destroyer median loot", "bar", $dataDestroyer);
            $chart->dataset("Frigate median loot", "bar", $dataFrigate);
            $request->headers->set('Accept', 'application/json');
            return $chart->api();
        }



        public function popularHulls(Request $request) {
            $request->headers->set('Accept', 'application/json');

            $chart = Cache::remember("aft.home.popular.hulls", now()->addMinutes(15), function() {
                return  DB::select("
                    select f.SHIP_ID, sl.NAME, count(f.ID) as CNT, max(cj.cf), round(count(f.ID)/max(cj.cf)*100, 1) as PERCENTAGE
                    from fits f
                    join ship_lookup sl on f.SHIP_ID = sl.ID
                    cross join (select count(cf.ID) as cf from fits cf) as cj
                    group by f.SHIP_ID, sl.NAME, sl.`GROUP`
                    having  PERCENTAGE>3.0
                    order by 3 desc;");
            });
            $dataset = [];
            $values = [];
            $other = 100.0;
            foreach ($chart as $type) {
                $dataset[] = $type->NAME;
                $values[] = $type->PERCENTAGE;
                $other -= $type->PERCENTAGE;
            }

            if ($other >= 0.5) {
                $dataset[] = "Other";
                $values[] = round($other, 1);
            }
            $chart = new HomePagePopularHulls();
            $chart->labels($dataset);
            $chart->dataset('Popular hulls (%)', 'pie', $values)->options([
                "radius" => [12,46]
            ]);
            return $chart->api();
        }

        public function popularClasses(Request $request) {
            $request->headers->set('Accept', 'application/json');

            $chart = Cache::remember("aft.home.popular.classes", now()->addMinutes(15), function() {
                return  DB::select("

select sl.`GROUP` as NAME, count(f.ID) as CNT, max(cj.cf), round(count(f.ID)/max(cj.cf)*100, 1) as PERCENTAGE
                    from fits f
                    join ship_lookup sl on f.SHIP_ID = sl.ID
                    cross join (select count(cf.ID) as cf from fits cf) as cj
                    group by sl.GROUP, sl.`GROUP`
                    having  PERCENTAGE>3.0
                    order by 2 desc;");
            });
            $dataset = [];
            $values = [];
            $other = 100.0;
            foreach ($chart as $type) {
                $dataset[] = $type->NAME;
                $values[] = $type->PERCENTAGE;
                $other -= $type->PERCENTAGE;
            }

            if ($other >= 0.5) {
                $dataset[] = "Other";
                $values[] = round($other, 1);
            }
            $chart = new HomePagePopularClasses();
            $chart->labels($dataset);
            $chart->dataset('Popular classes (%)', 'pie', $values)->options([
                "radius" => [12,46]
            ]);
            return $chart->api();
        }

        /**
         * Gets the run bell graphs for
         * @param int $tier
         * @param string $isCruiser
         * @param int $thisRun
         *
         * @return string
         */
        public function getRunBellGraphs(int $tier, string $isCruiser, int $thisRun) {

            $million = 1000000;
            $meanCruiser = (DB::table("runs")
                              ->where("runs.LOOT_ISK", '>', 0)
                              ->where("runs.SURVIVED", true)
                              ->where("runs.TIER", $tier)
                              ->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')
                              ->where("ship_lookup.HULL_SIZE", ShipHullSize::CRUISER)
                              ->avg("runs.LOOT_ISK"))/$million;
            $sdevCruiser = (DB::table("runs")
                              ->where("runs.LOOT_ISK", '>', 0)
                              ->where("runs.SURVIVED", true)
                              ->where("runs.TIER", $tier)
                              ->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')
                              ->where("ship_lookup.HULL_SIZE", ShipHullSize::CRUISER)
                              ->select(DB::raw("STDDEV(runs.LOOT_ISK) as STDEV"))->first()->STDEV)/$million;
            $meanDestroyer = (DB::table("runs")
                              ->where("runs.LOOT_ISK", '>', 0)
                              ->where("runs.SURVIVED", true)
                              ->where("runs.TIER", $tier)
                              ->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')
                              ->where("ship_lookup.HULL_SIZE", ShipHullSize::DESTROYER)
                              ->avg("runs.LOOT_ISK"))/$million;
            $sdevDestroyer = (DB::table("runs")
                              ->where("runs.LOOT_ISK", '>', 0)
                              ->where("runs.SURVIVED", true)
                              ->where("runs.TIER", $tier)
                              ->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')
                              ->where("ship_lookup.HULL_SIZE", ShipHullSize::DESTROYER)
                              ->select(DB::raw("STDDEV(runs.LOOT_ISK) as STDEV"))->first()->STDEV)/$million;
            $meanFrigate = (DB::table("runs")
                              ->where("runs.LOOT_ISK", '>', 0)
                              ->where("runs.SURVIVED", true)
                              ->where("runs.TIER", $tier)
                              ->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')
                              ->where("ship_lookup.HULL_SIZE", ShipHullSize::FRIGATE)
                              ->avg("runs.LOOT_ISK"))/$million;
            $sdevFrigate = (DB::table("runs")
                              ->where("runs.LOOT_ISK", '>', 0)
                              ->where("runs.SURVIVED", true)
                              ->where("runs.TIER", $tier)
                              ->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')
                              ->where("ship_lookup.HULL_SIZE", ShipHullSize::FRIGATE)
                              ->select(DB::raw("STDDEV(runs.LOOT_ISK) as STDEV"))->first()->STDEV)/$million;


            $dataCruiser = $this->getCruiserBaseDataForTier($tier);
            $dataDestroyer = $this->getDestroyerBaseDataForTier($tier);
            $dataFrigate = $this->getFrigateBaseDataForTier($tier);

            $chartDataCruiser = $this->buildDataSet($dataCruiser, $million, $meanCruiser, $sdevCruiser);
            $chartDataDestroyer= $this->buildDataSet($dataDestroyer, $million, $meanDestroyer, $sdevDestroyer);
            $chartDataFrigate = $this->buildDataSet($dataFrigate, $million, $meanFrigate, $sdevFrigate);

            $thisRunData = [[
                floatval(round($thisRun/$million, 2)),
                round($this->calcNormalDist(floatval(round($thisRun/$million, 2)),$isCruiser ? $meanCruiser : $meanFrigate, $isCruiser ? $sdevCruiser : $sdevFrigate)*100, 2)
            ]];

            $chart = new BellChart1();
            $chart->dataset("Cruiser size distribution", "line", $chartDataCruiser)->options([
                "smooth" => 0.5,
                "showSymbol" => false,
                "hoverAnimation" => false
            ]);
            $chart->dataset("Destroyer size distribution", "line", $chartDataDestroyer)->options([
                "smooth" => 0.5,
                "showSymbol" => false,
                "hoverAnimation" => false
            ]);
            $chart->dataset("Frigate size distribution", "line", $chartDataFrigate)->options([
                "smooth" => 0.5,
                "showSymbol" => false,
                "hoverAnimation" => false
            ]);
            $chart->dataset("This run", "scatter", $thisRunData)->options([
            ]);
            return $chart->api();
        }

        public function homeSurvival(Request $request) {
            $request->headers->set('Accept', 'application/json');
            $data = Cache::remember("home.survival", now()->addHour(), function () {
                return [
                    "survived" => DB::table("runs")->where("SURVIVED", '=', true)->whereRaw("RUN_DATE > NOW() - INTERVAL 90 DAY")->count(),
                    "died" => DB::table("runs")->where("SURVIVED", '=', false)->whereRaw("RUN_DATE > NOW() - INTERVAL 90 DAY")->count()];
            });

            $dataset = ["Survived", "Died"];
            $values = [$data["survived"], $data["died"]];
            $chart = new SurvivalLevelChart();

            $chart->labels($dataset);
            $chart->dataset('Survival', 'pie', $values)->options([
                "radius" => self::HOME_PIE_RADIUS
            ]);
            return $chart->api();

        }

        public function homeSurvivalTier(Request $request, int $tier) {
            $request->headers->set('Accept', 'application/json');
            $data = Cache::remember("home.survival.tier.$tier", now()->addHour(), function () use ($tier) {
                return [
                    "survived" => DB::table("runs")->where("SURVIVED", '=', true)->where('TIER', $tier)->whereRaw("RUN_DATE > NOW() - INTERVAL 180 DAY")->count(),
                    "died" => DB::table("runs")->where("SURVIVED", '=', false)->where('TIER', $tier)->whereRaw("RUN_DATE > NOW() - INTERVAL 180 DAY")->count()];
            });

            $dataset = ["Survived", "Died"];
            $values = [$data["survived"], $data["died"]];
            $chart = new SurvivalLevelChart();

            $chart->labels($dataset);
            $chart->dataset('Survival', 'pie', $values)->options([
                "radius" => self::HOME_PIE_RADIUS
            ]);
            return $chart->api();

        }

        public function typeTier(Request $request, $tier) {
            $request->headers->set('Accept', 'application/json');


            $chart = Cache::remember("aft.tiers.type-". $tier, now()->addMinutes(15), function() use ($tier) {
                return  DB::table("runs")
                          ->where("TIER", $tier)
                          ->groupBy("TYPE")
                          ->select("TYPE")
                          ->selectRaw("COUNT(type) AS CNT")->get();
            });

            $dataset = [];
            $values = [];
            foreach ($chart as $type) {
                $dataset[] = $type->TYPE;
                $values[] = $type->CNT;
            }

            $chart = new LootAveragesChart();

            $chart->labels($dataset);
            $chart->dataset('Filament types', 'pie', $values)->options([
                "radius" => self::HOME_PIE_RADIUS
            ]);
            return $chart->api();
        }


        public function homeTier(Request $request) {
            $request->headers->set('Accept', 'application/json');
            if (Cache::has("home.levels")) {
                $chart = Cache::get("home.levels");
            } else {
                $chart = DB::table("runs")->groupBy("TIER")->select("TIER")->selectRaw("COUNT(TIER) AS CNT")->get();
                Cache::put("home.levels", $chart, 15);
            }

            $dataset = [];
            $values = [];
            foreach ($chart as $type) {
                $dataset[] = "Tier ".$type->TIER;
                $values[] = $type->CNT;
            }

            $chart = new TierLevelsChart();

            $chart->labels($dataset);
            $chart->dataset('Tier levels', 'pie', $values)->options([
                "radius" => self::HOME_PIE_RADIUS
            ]);
            return $chart->api();

        }


        public function tierAverages(Request $request) {
            $request->headers->set('Accept', 'application/json');

            $data = Cache::remember("home.tier_averages", now()->addHour(), function () {
                return DB::table("runs")
                    ->select("TIER")
                    ->selectRaw("AVG(LOOT_ISK) as AVG")
                    ->whereRaw("RUN_DATE > NOW() - INTERVAL 90 DAY")
                    ->groupBy("TIER")
                    ->orderBy("TIER", "ASC")
                    ->get();
            });

            $data_cruiser = Cache::remember("home.tier_averages_cruiser", now()->addHour(), function () {
                return DB::table("runs")
                    ->select("runs.TIER")
                    ->selectRaw("AVG(runs.LOOT_ISK) as AVG")
                    ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                    ->whereRaw("RUN_DATE > NOW() - INTERVAL 90 DAY")
                    ->whereNotNull("runs.SHIP_ID")
                    ->where("ship_lookup.IS_CRUISER", "1")
                    ->groupBy("runs.TIER")
                    ->orderBy("runs.TIER", "ASC")
                    ->get();
            });

            $data_frigate = Cache::remember("home.tier_averages_frigate", now()->addHour(), function () {
                return DB::table("runs")
                    ->select("runs.TIER")
                    ->selectRaw("AVG(runs.LOOT_ISK) as AVG")
                    ->join("ship_lookup", "runs.SHIP_ID", 'ship_lookup.ID')
                    ->whereNotNull("runs.SHIP_ID")
                    ->where("ship_lookup.IS_CRUISER", "0")
                    ->whereRaw("RUN_DATE > NOW() - INTERVAL 90 DAY")
                    ->groupBy("runs.TIER")
                    ->orderBy("runs.TIER", "ASC")
                    ->get();
            });

            $chart = new LootTierChart();

            $dataset = [];
            $values = [];
            foreach ($data as $type) {
                $dataset[] = "Tier ".$type->TIER;
                $values[] = round($type->AVG/1000000, 2);
            }
            $values_cruiser = [];
            foreach ($data_cruiser as $type) {
                $values_cruiser[] = round($type->AVG/1000000, 2);
            }
            $values_frigate = [];
            foreach ($data_frigate as $type) {
                $values_frigate[] = round($type->AVG/1000000, 2);
            }

            $chart->labels($dataset);
            $chart->dataset('All runs (M ISK)', 'bar', $values);
            $chart->dataset('Cruiser runs (M ISK)', 'bar', $values_cruiser);
            $chart->dataset('Frigate runs (M ISK)', 'bar', $values_frigate);
            return $chart->api();
        }

        public function personalLoot(Request $request) {
            $request->headers->set('Accept', 'application/json');

            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            $loginId = session()->get("login_id");

            $dataset = [];
            $values = [];
            $values2 = [];
            $values3 = [];
            for($i=-30; $i<=0; $i++) {
                $date = date("Y-m-d", strtotime("now $i days"));
                $dataset[] = date("m.d", strtotime("now $i days"));

                $val = DB::select("select
                        COUNT(*) as COUNT,
                        AVG(LOOT_ISK) as AVG,
                        SUM(LOOT_ISK) as SUM,
                        '$date' as RUN_DATE
                           from runs
                    where CHAR_ID=? and RUN_DATE=?" ,[$loginId, $date
                ]);

                $seconds = DB::table("runs")
                             ->select("RUNTIME_SECONDS")
                             ->where("CHAR_ID", $loginId)
                             ->where("RUN_DATE", $date)->get();

                $totalSeconds = 0;
                foreach ($seconds as $second) {
                    $totalSeconds += $second->RUNTIME_SECONDS ?? 1200;
                }
                $totalSeconds = max($totalSeconds, 3600);

                $val[0]->IPH = $val[0]->SUM/($totalSeconds/3600);
                $val[0]->TOTAL_SECONDS = $totalSeconds;
                $val[0]->TOTAL_HOURS = $totalSeconds/3600;
                $table[]= $val;

                $values[]  = round($val[0]->SUM/1000000, 2);
                $values2[] = round($val[0]->AVG/1000000, 2);
                $values3[] = round($val[0]->SUM/($totalSeconds/3600)/1000000, 2);
            }

            $chart = new PersonalDaily();
            $chart->labels($dataset);
            $chart->dataset('Sum loot / day (M ISK)', 'bar', $values);
            $chart->dataset('Average loot / day (M ISK)', 'bar', $values2);
            $chart->dataset('Efficiency (M ISK/Hour)', 'bar', $values3);

            return $chart->api();
        }

        public function personalIsk(Request $request) {
            $request->headers->set('Accept', 'application/json');

            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            $id = session()->get("login_id");

            $data = DB::table("runs")
                ->where("CHAR_ID", '=', $id)
                ->whereRaw("RUN_DATE > NOW() - INTERVAL 30 DAY")
//                ->select("RUN_DATE")
                ->selectRaw("(SUM(LOOT_ISK)/GREATEST(3,COUNT(ID)))*LEAST(COUNT(ID), 3)  AS ISK_PER_HOUR")
                ->groupBy("RUN_DATE")
                ->get();

            $chart = new IskPerHourChart();
            $values = [];
            foreach ($data as $type) {
                $values[] = round($type->ISK_PER_HOUR/1000000, 2);
            }
            $chart->dataset('Approximate ISK/hour (Million ISK)', 'line', $values)->options(["smooth" => true]);

            return $chart->api();
        }

        /**
         * Calculates the nornal distribution
         * @param float $x Value
         * @param float $mean Mean value
         * @param float $sdev Standard deviation
         *
         * @return float|int
         */
        private function calcNormalDist(float  $x, float $mean, float $sdev) {

            $z = ($x - $mean) / max($sdev, 1);
            return (1.0 / (max($sdev, 1) * sqrt(2.0 * pi()))) * exp(-0.5 * $z * $z);
//            return ($mean+$sdev / ($sdev * sqrt(2.0 * pi()))) * exp(-0.5 * $z * $z);


        }

        /**
     * @param array $dataCruiser
     * @param int   $million
     * @param       $meanCruiser
     * @param       $sdevCruiser
     * @return array
     */
        protected function buildDataSet(array $dataCruiser, int $million, $meanCruiser, $sdevCruiser) : array {
            $chartDataSet = [[0, 0]];
            $i = 0;
            foreach ($dataCruiser as $dat) {
                if ($i++ % 3 == 0) continue;
                $label = floatval(round($dat->LOOT_ISK / $million, 2));
                $chartDataSet[] = [$label, round($this->calcNormalDist(floatval(round($dat->LOOT_ISK / $million, 2)), $meanCruiser, $sdevCruiser) * 100, 3)];
            }

            usort($chartDataSet, function($a, $b) {
                if ($a == $b) return 0;
                return ($a < $b) ? -1 : 1;
            });

            $max = $chartDataSet[0][1];
            foreach ($chartDataSet as $chartData) {
                $max = max($max, $chartData[1]);
            }

            foreach ($chartDataSet as $i => $chartData) {
                $chartDataSet[$i][1] = $chartData[1]/max(1,$max);
            }
            return $chartDataSet;
        }



        /**
         * @param int $tier
         *
         * @return array
         */
        protected function getCruiserBaseDataForTier(int $tier) : array {
            return Cache::remember("aft.bellgraph.cruiser.t" . $tier, now()->addMinutes(15), function () use ($tier) {
                return $this->executeBaseDataForTier($tier, ShipHullSize::CRUISER);
            });
        }

        /**
         * @param int $tier
         *
         * @return array
         */
        protected function getFrigateBaseDataForTier(int $tier) : array {
            return Cache::remember("aft.bellgraph.cruiser.t" . $tier, now()->addMinutes(15), function () use ($tier) {
                return $this->executeBaseDataForTier($tier,  ShipHullSize::FRIGATE);
            });
        }

        /**
         * @param int $tier
         *
         * @return array
         */
        protected function getDestroyerBaseDataForTier(int $tier) : array {
            return Cache::remember("aft.bellgraph.destroyer.t" . $tier, now()->addMinutes(15), function () use ($tier) {
                return $this->executeBaseDataForTier($tier, ShipHullSize::DESTROYER);
            });
        }


        protected function executeBaseDataForTier(int $tier, string $hullSize) {
            return DB::select("
                    select AVG(i.LOOT_ISK) as `LOOT_ISK`
                    from (SELECT MIN(r.LOOT_ISK) as `LOOT_ISK`, CUME_DIST() OVER (ORDER BY LOOT_ISK ASC) as `DIST`
                          FROM runs r
                                   join ship_lookup sl on r.SHIP_ID = sl.ID
                          where r.SURVIVED = 1
                            and r.TIER = ?
                            and r.LOOT_ISK > 0
                            and sl.HULL_SIZE = ?
                          GROUP BY r.LOOT_ISK
                          ORDER BY r.LOOT_ISK ASC) i
                    WHERE i.DIST<=? AND i.LOOT_ISK <= ?
                    GROUP BY ROUND(i.DIST, 2)
                    ORDER BY i.LOOT_ISK ASC", [$tier, $hullSize, 1, 300000000]);
        }
    }
