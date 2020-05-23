<?php


    namespace App\Http\Controllers;


    use App\Charts\IskPerHourChart;
    use App\Charts\LootAveragesChart;
    use App\Charts\LootTierChart;
    use App\Charts\PersonalDaily;
    use App\Charts\RunBetter;
    use App\Charts\SurvivalLevelChart;
    use App\Charts\TierLevelsChart;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class GraphHelper extends Controller {

        const HOME_PIE_RADIUS = [50, 90];

        public function homeType() {
            if (Cache::has("home.types")) {
                $chart = Cache::get("home.types");
            } else {
                $chart = DB::table("runs")
                           ->groupBy("TYPE")
                           ->select("TYPE")
                           ->selectRaw("COUNT(type) AS CNT")->get();
                Cache::put("home.types", $chart, 15);
            }

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

        public function homeTier() {
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

        /**
         * @return string
         */
        public function getHomeRunBellGraphs() {
            $million = 1000000;

            $meansCruiser = collect([]);
            $meansFrigate = collect([]);
            $sdevsCruiser = collect([]);
            $sdevsFrigate = collect([]);
            $ndataCruiser = collect([]);
            $ndataFrigate = collect([]);

            $datasets = collect([]);


            $chart = new RunBetter();

            for ($i=1;$i<=5;$i++) {
                $meansCruiser->add((DB::table("runs")->where("runs.LOOT_ISK", '>', 0)->where("runs.SURVIVED", true)->where("runs.TIER", $i)->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')->where("ship_lookup.IS_CRUISER", 1)->avg("runs.LOOT_ISK"))/$million);
                $meansFrigate->add((DB::table("runs")->where("runs.LOOT_ISK", '>', 0)->where("runs.SURVIVED", true)->where("runs.TIER", $i)->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')->where("ship_lookup.IS_CRUISER", 0)->avg("runs.LOOT_ISK"))/$million);
                $sdevsCruiser->add((DB::table("runs")->where("runs.LOOT_ISK", '>', 0)->where("runs.SURVIVED", true)->where("runs.TIER", $i)->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')->where("ship_lookup.IS_CRUISER", 1)->select(DB::raw("STDDEV(runs.LOOT_ISK) as STDEV"))->first()->STDEV)/$million);
                $sdevsFrigate->add((DB::table("runs")->where("runs.LOOT_ISK", '>', 0)->where("runs.SURVIVED", true)->where("runs.TIER", $i)->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')->where("ship_lookup.IS_CRUISER", 0)->select(DB::raw("STDDEV(runs.LOOT_ISK) as STDEV"))->first()->STDEV)/$million);
                $ndataCruiser->add($this->getCruiserBaseDataForTier($i));
                $ndataFrigate->add($this->getFrigateBaseDataForTier($i));

                $datasets->add($this->buildDataSet($ndataCruiser->last(), $million, $meansCruiser->last(), $sdevsCruiser->last())[0]);
                $chart->dataset("Cruisers Tier $i", "line", $datasets->last())->options([
                    "smooth" => 0.3,
                    "showSymbol" => false,
                    "hoverAnimation" => false
                ]);

                $datasets->add($this->buildDataSet($ndataFrigate->last(), $million, $meansFrigate->last(), $sdevsFrigate->last())[0]);
                $chart->dataset("Frigates Tier $i", "line", $datasets->last())->options([
                    "smooth" => 0.3,
                    "showSymbol" => false,
                    "hoverAnimation" => false
                ]);
            }

//            dd($meansCruiser,$sdevsCruiser );

            return $chart->api();
        }

        /**
         * Gets the run bell graphs for
         * @param int $tier
         * @param int $isCruiser
         * @param int $thisRun
         *
         * @return string
         */
        public function getRunBellGraphs(int $tier, int  $isCruiser, int $thisRun) {

            $million = 1000000;
            $meanCruiser = (DB::table("runs")->where("runs.LOOT_ISK", '>', 0)->where("runs.SURVIVED", true)->where("runs.TIER", $tier)->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')->where("ship_lookup.IS_CRUISER", 1)->avg("runs.LOOT_ISK"))/$million;
            $sdevCruiser = (DB::table("runs")->where("runs.LOOT_ISK", '>', 0)->where("runs.SURVIVED", true)->where("runs.TIER", $tier)->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')->where("ship_lookup.IS_CRUISER", 1)->select(DB::raw("STDDEV(runs.LOOT_ISK) as STDEV"))->first()->STDEV)/$million;
            $meanFrigate = (DB::table("runs")->where("runs.LOOT_ISK", '>', 0)->where("runs.SURVIVED", true)->where("runs.TIER", $tier)->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')->where("ship_lookup.IS_CRUISER", 0)->avg("runs.LOOT_ISK"))/$million;
            $sdevFrigate = (DB::table("runs")->where("runs.LOOT_ISK", '>', 0)->where("runs.SURVIVED", true)->where("runs.TIER", $tier)->join("ship_lookup", "runs.SHIP_ID", '=', 'ship_lookup.ID')->where("ship_lookup.IS_CRUISER", 0)->select(DB::raw("STDDEV(runs.LOOT_ISK) as STDEV"))->first()->STDEV)/$million;


            $dataCruiser = $this->getCruiserBaseDataForTier($tier);
            $dataFrigate = $this->getFrigateBaseDataForTier($tier);

            [$chartDataCruiser, $i, $dat, $label] = $this->buildDataSet($dataCruiser, $million, $meanCruiser, $sdevCruiser);
            [$chartDataFrigate, $i, $dat, $label] = $this->buildDataSet($dataFrigate, $million, $meanFrigate, $sdevFrigate);

//            usort($chartDataCruiser, function($a, $b) {
//                if ($a == $b) return 0;
//                return ($a < $b) ? -1 : 1;
//            });
//
//            usort($chartDataFrigate, function($a, $b) {
//                if ($a == $b) return 0;
//                return ($a < $b) ? -1 : 1;
//            });

            $thisRunData = [[
                floatval(round($thisRun/$million, 2)),
                round($this->calcNormalDist(floatval(round($thisRun/$million, 2)),$isCruiser ? $meanCruiser : $meanFrigate, $isCruiser ? $sdevCruiser : $sdevFrigate)*100, 2)
            ]];

            $chart = new RunBetter();
            $chart->dataset("Cruiser size distribution", "line", $chartDataCruiser)->options([
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

        public function homeSurvival() {
            $data = Cache::remember("home.survival", 15, function () {
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

        public function tierAverages() {

            $data = Cache::remember("home.tier_averages", 15, function () {
                return DB::table("runs")
                    ->select("TIER")
                    ->selectRaw("AVG(LOOT_ISK) as AVG")
                    ->whereRaw("RUN_DATE > NOW() - INTERVAL 90 DAY")
                    ->groupBy("TIER")
                    ->orderBy("TIER", "ASC")
                    ->get();
            });

            $data_cruiser = Cache::remember("home.tier_averages_cruiser", 15, function () {
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

            $data_frigate = Cache::remember("home.tier_averages_frigate", 15, function () {
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

        public function personalLoot() {

            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            $id = session()->get("login_id");

            $data = DB::table("runs")
                ->where("CHAR_ID", '=', $id)
                ->whereRaw("RUN_DATE > NOW() - INTERVAL 30 DAY")
                ->select("RUN_DATE")
                ->selectRaw("SUM(LOOT_ISK) AS SUM_ISK")
                ->selectRaw("AVG(LOOT_ISK) AS AVG_ISK")
                ->groupBy("RUN_DATE")
                ->get();

            $chart = new PersonalDaily();

            $dataset = [];
            $values = [];
            $values2 = [];
            foreach ($data as $type) {
                $dataset[] = $type->RUN_DATE;
                $values[] = round($type->SUM_ISK/1000000, 2);
                $values2[] = round($type->AVG_ISK/1000000, 2);
            }
            $chart->labels($dataset);
            $chart->dataset('Sum loot / day (Million ISK)', 'bar', $values);
            $chart->dataset('Average loot / day (Million ISK)', 'bar', $values2);
            return $chart->api();
        }

        public function personalIsk() {

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

            $z = ($x - $mean) / $sdev;
            return (1.0 / ($sdev * sqrt(2.0 * pi()))) * exp(-0.5 * $z * $z);
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
                $chartDataSet[] = [$label, round($this->calcNormalDist(floatval(round($dat->LOOT_ISK / $million, 2)), $meanCruiser, $sdevCruiser) * 100, 2)];
            }

            usort($chartDataSet, function($a, $b) {
                if ($a == $b) return 0;
                return ($a < $b) ? -1 : 1;
            });

            return array($chartDataSet, $i, $dat, $label);
        }

        /**
         * @param int $tier
         *
         * @return array
         */
        protected function getCruiserBaseDataForTier(int $tier) : array {
            return Cache::remember("aft.bellgraph.cruiser.t" . $tier, now()->addMinutes(15), function () use ($tier) {
                return DB::select("
                    select AVG(i.LOOT_ISK) as `LOOT_ISK`
                    from (SELECT MIN(r.LOOT_ISK) as `LOOT_ISK`, CUME_DIST() OVER (ORDER BY LOOT_ISK ASC) as `DIST`
                          FROM runs r
                                   join ship_lookup sl on r.SHIP_ID = sl.ID
                          where r.SURVIVED = 1
                            and r.TIER = ?
                            and r.LOOT_ISK > 0
                            and sl.IS_CRUISER = ?
                          GROUP BY r.LOOT_ISK
                          ORDER BY r.LOOT_ISK ASC) i
                    WHERE i.DIST<=? AND i.LOOT_ISK <= ?
                    GROUP BY ROUND(i.DIST, 2)
                    ORDER BY i.LOOT_ISK ASC", [$tier, 1, 1, ($tier*$tier)*10000000]);
            });
        }

        /**
         * @param int $tier
         *
         * @return array
         */
        protected function getFrigateBaseDataForTier(int $tier) : array {

            return Cache::remember("aft.bellgraph.cruiser.t" . $tier, now()->addMinutes(15), function () use ($tier) {
                return DB::select("
                    select AVG(i.LOOT_ISK) as `LOOT_ISK`
                    from (SELECT MIN(r.LOOT_ISK) as `LOOT_ISK`, CUME_DIST() OVER (ORDER BY LOOT_ISK ASC) as `DIST`
                          FROM runs r
                                   join ship_lookup sl on r.SHIP_ID = sl.ID
                          where r.SURVIVED = 1
                            and r.TIER = ?
                            and r.LOOT_ISK > 0
                            and sl.IS_CRUISER = ?
                          GROUP BY r.LOOT_ISK
                          ORDER BY r.LOOT_ISK ASC) i
                    WHERE i.DIST<=? AND i.LOOT_ISK <= ?
                    GROUP BY ROUND(i.DIST, 2)
                    ORDER BY i.LOOT_ISK ASC", [$tier, 0, 1, ($tier*$tier)*10000000]);
            });
        }
    }
