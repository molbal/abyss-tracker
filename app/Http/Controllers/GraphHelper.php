<?php


    namespace App\Http\Controllers;


    use App\Charts\LootAveragesChart;
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

        public function homeLootLevels() {
            if (Cache::has("home.levels")) {
                $data = Cache::get("home.levels");
            } else {
                $data = DB::table("v_all_loot_stats")->get()->get(0);
                Cache::put("home.levels", $data, 15);
            }

            $chart = new LootAveragesChart();

            $chart->labels([
                "0-2.5M",
                "2.5-5M",
                "5-10M",
                "10-15M",
                "15-25M",
                "25-35M",
                "35-50M",
                "50-65M",
                "65-100M",
                "100+M",
            ]);
            $chart->dataset("Run loot counts", 'bars', [
                $data->A,
                $data->B,
                $data->C,
                $data->D,
                $data->E,
                $data->F,
                $data->G,
                $data->H,
                $data->I,
                $data->J
            ]);
            return $chart->api();
        }
    }
