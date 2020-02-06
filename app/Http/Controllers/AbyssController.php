<?php


    namespace App\Http\Controllers;


    use App\Charts\AbyssSurvivalType;
    use App\Charts\DailyAdds;
    use App\Charts\IskPerHourChart;
    use App\Charts\LootAveragesChart;
    use App\Charts\LootTierChart;
    use App\Charts\LootTypesChart;
    use App\Charts\PersonalDaily;
    use App\Charts\RunBetter;
    use App\Charts\SurvivalLevelChart;
    use App\Charts\TierLevelsChart;
    use App\Http\Controllers\Loot\LootCacheController;
    use App\Http\Controllers\Loot\LootValueEstimator;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Validator;

    class AbyssController extends Controller {

        /** @var LootCacheController */
        private $lootCacheController;

        /** @var GraphContainerController */
        private $graphContainerController;

        /** @var HomeQueriesController */
        private $homeQueriesController;

        /**
         * AbyssController constructor.
         *
         * @param LootCacheController      $lootCacheController
         * @param GraphContainerController $graphContainerController
         * @param HomeQueriesController    $homeQueriesController
         */
        public function __construct(LootCacheController $lootCacheController, GraphContainerController $graphContainerController, HomeQueriesController $homeQueriesController)
        {
            $this->lootCacheController = $lootCacheController;
            $this->graphContainerController = $graphContainerController;
            $this->homeQueriesController = $homeQueriesController;
        }


        public function home() {
            $lootTypesChart = $this->graphContainerController->getHomeLootTypesChart();
            $tierLevelsChart = $this->graphContainerController->getHomeLootTierLevels();
            $survival_chart = $this->graphContainerController->getHomeSurvivalLevels();
            $loot_tier_chart = $this->graphContainerController->getHomeLootAverages();
            $last_runs = $this->homeQueriesController->getLastRuns();
            $drops = $this->homeQueriesController->getCommonDrops();
            [$count, $daily_add_chart] = $this->graphContainerController->getHomeDailyRunCounts();

            $today_num = DB::table("runs")->where("RUN_DATE", date("Y-m-d"))->count();
            $count = DB::table("runs")->count();

            return view("welcome", [
                'loot_types_chart' => $lootTypesChart,
                'tier_levels_chart' => $tierLevelsChart,
                'survival_chart' => $survival_chart,
                'loot_tier_chart' => $loot_tier_chart,
                'abyss_num' => $count,
                'today_num' => $today_num,
                'items' => $last_runs,
                'drops' => $drops,
                'daily_add_chart' => $daily_add_chart
            ]);
        }


        public function home_mine() {

            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            $my_runs = DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->count();
            $my_avg_loot = DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->avg('LOOT_ISK');
            $my_sum_loot = DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->sum('LOOT_ISK');
            $my_survival_ratio = (DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->where("SURVIVED", '=', true)->count()) / max(1, $my_runs) * 100;
            $id = session()->get("login_id");
            $data = DB::table("runs")
                ->where("CHAR_ID", '=', $id)
                ->whereRaw("RUN_DATE > NOW() - INTERVAL 30 DAY")
                ->select("RUN_DATE")
                ->groupBy("RUN_DATE")
                ->get();

            $chart = new IskPerHourChart();
            $labels = [];
            foreach ($data as $type) {
                $labels[] = date("m.d", strtotime($type->RUN_DATE));
            }
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

            return view("home_mine", [
                'my_runs' => $my_runs,
                'my_avg_loot' => $my_avg_loot,
                'my_sum_loot' => $my_sum_loot,
                'my_survival_ratio' => $my_survival_ratio,
                'personal_chart_loot' => $personalDaily,
                'personal_isk_per_hour' => $iskPerHour,
            ]);
        }


        public function store(Request $request) {
            Validator::make($request->all(), [
                'TYPE' => 'required',
                'TIER' => 'required',
                'SURVIVED' => 'required',
                'PUBLIC' => 'required',
                'RUN_DATE' => 'required|date',
                'KILLMAIL' => 'nullable|regex:/https?:\/\/zkillboard\.com\/kill\/\d+\/?/m'
            ], [
                'required' => "Please fill :attribute before saving your request",
                'regex' => "Please link a valid zKillboard link like this: https://zkillboard.com/kill/81359022/"
            ])->validate();

            if ($request->get("SURVIVED") == "1") {
                Validator::make($request->all(), [
                    'LOOT_DETAILED' => 'required',
                ], [
                    'required' => "Please fill :attribute before saving your request"
                ])->validate();
            }

            $lootEstimator = new LootValueEstimator($request->get("LOOT_DETAILED") ?? "");

            $id = DB::table("runs")->insertGetId([
                'CHAR_ID' => session()->get("login_id"),
                'PUBLIC' => $request->get("PUBLIC"),
                'TIER' => $request->get("TIER"),
                'TYPE' => $request->get("TYPE"),
                'LOOT_ISK' => $request->get("SURVIVED") ? $lootEstimator->getTotalPrice() : 0,
                'SURVIVED' => $request->get("SURVIVED"),
                'RUN_DATE' => $request->get("RUN_DATE"),
                'SHIP_ID' => $request->get('SHIP_ID'),
                'DEATH_REASON' => $request->get('DEATH_REASON'),
                'PVP_CONDUIT_USED' => $request->get('PVP_CONDUIT_USED'),
                'PVP_CONDUIT_SPAWN' => $request->get('PVP_CONDUIT_SPAWN'),
                'FILAMENT_PRICE' => $request->get('FILAMENT_PRICE'),
                'LOOT_TYPE' => $request->get('LOOT_TYPE'),
                'KILLMAIL' => $request->get('KILLMAIL'),
            ]);

            foreach ($lootEstimator->getItems() as $item) {
                LootValueEstimator::setItemPrice($item);
                DB::table("detailed_loot")->insert([
                    "RUN_ID" => $id,
                    "ITEM_ID" => $item->getItemId(),
                    "COUNT" => $item->getCount()
                ]);
            }

            return redirect(route("view_single", ["id" => $id]));
        }

        public function form_new() {
            if (session()->has("login_id")) {
                $ships = DB::table("ship_lookup")->orderBy("NAME", "ASC")->get();
                $prev = DB::table("runs")
                    ->where("CHAR_ID", session()->get("login_id"))
                    ->orderBy("CREATED_AT", "DESC")
                    ->orderBy("RUN_DATE", "DESC")
                    ->limit(1)
                    ->get()->get(0);
//                dd($prev);
                return view("new", [
                    "ships" => $ships,
                    "prev" => $prev
                ]);
            } else {
                return view("error", ["error" => "Please sign in first to add a new run"]);
            }
        }

        public function get_single($id) {

            $builder = DB::table("v_runall")->where("ID", $id);
            if (!$builder->exists()) {
                return view("error", ["error" => "Sorry, we could not find an Abyss run with this ID"]);
            }

            $data = DB::table("v_runall")->where("ID", $id)->get()->get(0);

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


            $otherCharts->dataset(sprintf("Average loot for %s tier %s  (M ISK)", $data->TYPE, $data->TIER), 'bar', [round($averageLootForTierType / 1000000, 2)]);
            $otherCharts->dataset(sprintf("Average loot for tier %s  (M ISK)", $data->TIER), 'bar', [round($averageLootForTier / 1000000, 2)]);
            $otherCharts->dataset(sprintf("This run's loot (M ISK)"), 'bar', [round($data->LOOT_ISK / 1000000, 2)]);
            $otherCharts->theme(ThemeController::getChartTheme());
            $otherCharts->displayAxes(true);
            $otherCharts->displayLegend(true);

            $all_data = DB::table("runs")->where("ID", $id)->get()->get(0);
            $loot = DB::table("v_loot_details")->where("RUN_ID", $id)->get();

            if ($data->LOOT_ISK >0) {
                $percent = ($data->LOOT_ISK / $averageLootForTier) * 100;
            }
            else {
                $percent = -100;
            }
            if ($percent == -100) {
                $run_summary = "a catastrophic";
            }
            else if ($percent < 50) {
                $run_summary = "a poor";
            }
            else if ($percent < 75) {
                $run_summary = "an unsatisfactory";
            }
            else if ($percent < 90) {
                $run_summary = "a slightly below average";
            }
            else if ($percent < 110) {
                $run_summary = "a decent";
            }
            else if ($percent < 125) {
                $run_summary = "a satisfactory";
            }
            else if ($percent < 150) {
                $run_summary = "an excellent";
            }
            else if($percent < 333) {
                $run_summary = "an exceptional";
            }
            else {
                $run_summary = "a jackpot-hitting";
            }

            switch ($all_data->DEATH_REASON) {
                case 'TIMEOUT':
                    $death_reason = "Timer ran out";
                    break;
                case 'TANK_FAILED':
                    $death_reason = "My tank could not handle the DPS";
                    break;
                case 'CONNECTION_DROP':
                    $death_reason = "Connection dropped";
                    break;
                case 'PILOTING_MISTAKE':
                    $death_reason = "I made a grave piloting mistake";
                    break;
                case 'PVP_DEATH':
                    $death_reason = "I went into the PVP room and lost";
                    break;
                case 'OVERHEAT_FAILURE':
                    $death_reason = "I overheated a critical module too much accidentally";
                    break;
                case 'EXPERIMENTAL_FIT':
                    $death_reason = "I tried an experimental fit and it didn't work";
                    break;
                case 'OTHER':
                    $death_reason = "There was something else";
                    break;
                default:
                    $death_reason = "Not specified / secret";
            }

            switch ($all_data->LOOT_TYPE) {
                case 'BIOADAPTIVE_ONLY':
                    $looting = "Looted the bioadaptive caches only";
                    break;
                case 'BIOADAPTIVE_PLUS_SOME_CANS':
                    $looting = "Looted the bioadaptive caches + some cans";
                    break;
                case 'BIOADAPTIVE_PLUS_MOST_CANS':
                    $looting = "Looted the bioadaptive caches + most cans";
                    break;
                case 'BIOADAPTIVE_PLUS_ALL_CANS':
                    $looting = "Looted the bioadaptive caches + all the cans";
                    break;
                default:
                    $looting = "It's unclear if only the cache or the cans were looted too";
                    break;
            }

            $count_same_type_tier = DB::table("runs")->where("TYPE", $all_data->TYPE)->where("TIER", $all_data->TIER)->count();


            foreach ($loot as $lt) {
                $loot_stats = $this->lootCacheController->getItemStatsForTierType($lt->ITEM_ID, $all_data->TYPE, $all_data->TIER);
                try {

                $lt->DROP_PERCENT = round($loot_stats[$all_data->TYPE][$all_data->TIER]->DROPPED_COUNT/max(1,$loot_stats[$all_data->TYPE][$all_data->TIER]->RUNS_COUNT), 2);
                $lt->TOOLTIP = sprintf("%d / %d runs", $loot_stats[$all_data->TYPE][$all_data->TIER]->DROPPED_COUNT, $loot_stats[$all_data->TYPE][$all_data->TIER]->RUNS_COUNT);
                }
                catch (\Exception $e) {
                    $lt->DROP_PERCENT = 0;
                    $lt->TOOLTIP = "Unknown drop rate!";
                }
            }

            return view("run", [
                "id" => $id,
                "run" => $data,
                "survival" => $explodeCharts,
                "other" => $otherCharts,
                "loot_table" => $loot,
                "all_data" => $all_data,
                "percent" => ($percent),
                "run_summary" => $run_summary,
                "death_reason" => $death_reason,
                "loot_type" => $looting,
                "count_same_type_tier" => $count_same_type_tier
            ]);
        }

        public function get_all($order_by = "", $order_type = "") {
            $builder = DB::table("v_runall");
            [$order_by, $order_by_text, $order_type_text, $order_type] = $this->getSort($order_by, $order_type);

            $items = $builder->orderBy($order_by, $order_type)->paginate(25);
            return view("runs", ["order_type" => $order_type_text, "order_by" => $order_by_text, "items" => $items]);
        }

        public function get_mine($order_by = "", $order_type = "") {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to list your runs"]);
            }
            $builder = DB::table("v_runall")->where("CHAR_ID", session()->get('login_id'));
            [$order_by, $order_by_text, $order_type_text, $order_type] = $this->getSort($order_by, $order_type);

            $items = $builder->orderBy($order_by, $order_type);
            if ($order_by == "RUN_DATE") {
                $items->orderBy("CREATED_AT", $order_type);
            }
            return view("my_runs", ["order_type" => $order_type_text, "order_by" => $order_by_text, "items" => $items->paginate(25)]);
        }

        /**
         * @param $order_by
         * @param $order_type
         * @return array
         */
        private function getSort($order_by, $order_type): array {
            switch (strtoupper($order_by)) {
                case 'CHAR_ID':
                    $order_by = "NAME";
                    $order_by_text = "character name";
                    break;
                case 'TIER':
                    $order_by = "TIER";
                    $order_by_text = "Abyss tier";
                    break;
                case 'TYPE':
                    $order_by = "TYPE";
                    $order_by_text = "Abyss type";
                    break;
                case 'LOOT_ISK':
                    $order_by = "LOOT_ISK";
                    $order_by_text = "éoot value";
                    break;
                case 'SURVIVED':
                    $order_by = "SURVIVED";
                    $order_by_text = "survival";
                    break;
                default:
                case 'RUN_DATE':
                    $order_by = "RUN_DATE";
                    $order_by_text = "date of run";
                    break;
            }

            switch (strtoupper($order_type)) {
                case 'DESC':
                default:
                    $order_type_text = "in descending order";
                    $order_type = "DESC";
                    break;
                case 'ASC':
                    $order_type = "ASC";
                    $order_type_text = "in ascending order";
            }
            return [$order_by, $order_by_text, $order_type_text, $order_type];
        }
    }
