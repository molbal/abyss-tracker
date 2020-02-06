<?php


    namespace App\Http\Controllers;


    use App\Charts\IskPerHourChart;
    use App\Charts\LootAveragesChart;
    use App\Charts\LootTierChart;
    use App\Charts\PersonalDaily;
    use App\Charts\SurvivalLevelChart;
    use App\Charts\TierLevelsChart;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class GraphHelper extends Controller {

        public function homeType() {
            if (Cache::has("home.types")) {
                $chart = Cache::get("home.types");
            } else {
                $chart = DB::table("runs")->groupBy("TYPE")->select("TYPE")->selectRaw("COUNT(type) AS CNT")->get();
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
            $chart->dataset('Filament types', 'pie', $values);
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
            $chart->dataset('Tier levels', 'pie', $values);
            return $chart->api();

        }

        public function homeSurvival() {
            if (Cache::has("home.survival")) {
                $data = Cache::get("home.survival");
            } else {
                $data = [
                    "survived" => DB::table("runs")->where("SURVIVED", '=', true)->count(),
                    "died" => DB::table("runs")->where("SURVIVED", '=', false)->count()];
                Cache::put("home.survival", $data, 15);
            }

            $dataset = ["Survived", "Died"];
            $values = [$data["survived"], $data["died"]];
            $chart = new SurvivalLevelChart();

            $chart->labels($dataset);
            $chart->dataset('Survival', 'pie', $values);
            return $chart->api();

        }

        public function tierAverages() {

            if (Cache::has("home.tier_averages")) {
                $data = Cache::get("home.tier_averages");
            } else {
                $data = DB::table("runs")

                    ->select("TIER")
                    ->selectRaw("AVG(LOOT_ISK) as AVG")
                    ->groupBy("TIER")
                    ->orderBy("TIER", "ASC")
                    ->get();
                Cache::put("home.tier_averages", $data, 15);
            }

            $chart = new LootTierChart();

            $dataset = [];
            $values = [];
            foreach ($data as $type) {
                $dataset[] = "Tier ".$type->TIER;
                $values[] = round($type->AVG/1000000, 2);
            }

            $chart->labels($dataset);
            $chart->dataset('Average loot value/tier (Million ISK)', 'bar', $values);
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
    }
