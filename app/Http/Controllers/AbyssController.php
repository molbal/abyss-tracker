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

        /** @var RunsController */
        private $runsController;

        /** @var BarkController */
        private $barkController;

        /**
         * AbyssController constructor.
         *
         * @param LootCacheController      $lootCacheController
         * @param GraphContainerController $graphContainerController
         * @param HomeQueriesController    $homeQueriesController
         * @param RunsController           $runsController
         * @param BarkController           $barkController
         */
        public function __construct(LootCacheController $lootCacheController, GraphContainerController $graphContainerController, HomeQueriesController $homeQueriesController, RunsController $runsController, BarkController $barkController) {
            $this->lootCacheController = $lootCacheController;
            $this->graphContainerController = $graphContainerController;
            $this->homeQueriesController = $homeQueriesController;
            $this->runsController = $runsController;
            $this->barkController = $barkController;
        }


        /**
         * Handles homepage view
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function home() {
            $lootTypesChart = $this->graphContainerController->getHomeLootTypesChart();
            $tierLevelsChart = $this->graphContainerController->getHomeLootTierLevels();
            $survival_chart = $this->graphContainerController->getHomeSurvivalLevels();
            $loot_tier_chart = $this->graphContainerController->getHomeLootAverages();
            $last_runs = $this->homeQueriesController->getLastRuns();
            $drops = $this->homeQueriesController->getCommonDrops();
            $daily_add_chart = $this->graphContainerController->getHomeDailyRunCounts();
            $today_num = DB::table("runs")->where("RUN_DATE", date("Y-m-d"))->count();
            $count = DB::table("runs")->count();

            return view("welcome", [
                'loot_types_chart'  => $lootTypesChart,
                'tier_levels_chart' => $tierLevelsChart,
                'survival_chart'    => $survival_chart,
                'loot_tier_chart'   => $loot_tier_chart,
                'abyss_num'         => $count,
                'today_num'         => $today_num,
                'items'             => $last_runs,
                'drops'             => $drops,
                'daily_add_chart'   => $daily_add_chart
            ]);
        }


        /**
         * Handles the my stats view
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function home_mine() {

            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            list($my_runs, $my_avg_loot, $my_sum_loot, $my_survival_ratio, $data) = $this->homeQueriesController->getPersonalStats();

            $labels = [];
            foreach ($data as $type) {
                $labels[] = date("m.d", strtotime($type->RUN_DATE));
            }
            list($personalDaily, $iskPerHour) = $this->graphContainerController->getPersonalStatsCharts($labels);

            $table = [];
            for($i=0;$i>-31;$i--) {
                $date = date("Y-m-d", strtotime("now $i days"));
                $val = DB::select("select
    COUNT(*) as COUNT,
    AVG(LOOT_ISK) as AVG,
    SUM(LOOT_ISK) as SUM,
    '$date' as RUN_DATE
       from runs
where CHAR_ID=? and RUN_DATE=?" ,[
                    session()->get("login_id"), $date
                ]);
                $table[]= $val;
            }


            return view("home_mine", [
                'my_runs'               => $my_runs,
                'my_avg_loot'           => $my_avg_loot,
                'my_sum_loot'           => $my_sum_loot,
                'my_survival_ratio'     => $my_survival_ratio,
                'personal_chart_loot'   => $personalDaily,
                'personal_isk_per_hour' => $iskPerHour,
                'activity_daily' => $table
            ]);
        }


        /**
         * Handles the storing of a new run
         *
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function store(Request $request) {
            Validator::make($request->all(), [
                'TYPE'     => 'required',
                'TIER'     => 'required',
                'SURVIVED' => 'required',
                'PUBLIC'   => 'required',
                'RUN_DATE' => 'required|date',
                'KILLMAIL' => 'nullable|regex:/https?:\/\/zkillboard\.com\/kill\/\d+\/?/m'
            ], [
                'required' => "Please fill :attribute before saving your request",
                'regex'    => "Please link a valid zKillboard link like this: https://zkillboard.com/kill/81359022/"
            ])->validate();

            if ($request->get("SURVIVED") == "1") {
                Validator::make($request->all(), ['LOOT_DETAILED' => 'required'], ['required' => "Please fill :attribute before saving your request"])->validate();
            }

            if (trim($request->get("LOOT_DETAILED_BEFORE")) != "") {

                $difference = LootValueEstimator::difference($request->get("LOOT_DETAILED") ?? "", $request->get("LOOT_DETAILED_BEFORE") ?? "");
                $id = $this->runsController->storeNewRunWithAdvancedLoot($request, $difference);
            }
            else {

            $lootEstimator = new LootValueEstimator($request->get("LOOT_DETAILED") ?? "");
            $id = $this->runsController->storeNewRun($request, $lootEstimator);
            }

            return redirect(route("view_single", ["id" => $id]));
        }

        /**
         * Handles getting the new run screen
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function form_new() {
            if (session()->has("login_id")) {
                $ships = DB::table("ship_lookup")->orderBy("NAME", "ASC")->get();

                $stopwatch_enabled = DB::table("chars")->where("CHAR_ID", session()->get("login_id"))->whereNotNull("REFRESH_TOKEN")->exists();


                $prev = $this->runsController->getPreviousRun();
                return view("new", [
                    "ships" => $ships,
                    "prev"  => $prev,
                    "stopwatch" => $stopwatch_enabled
                ]);
            }
            else {
                return view("error", ["error" => "Please sign in first to add a new run"]);
            }
        }

        /**
         * Handles the display of a single run.
         * @param $id
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function get_single($id) {

            // Check if exists
            $runExists = DB::table("runs")->where("ID", $id)->exists();
            if (!$runExists) {
                return view("error", ["error" => "Sorry, we could not find an Abyss run with this ID"]);
            }

            // Get run view
            $data = DB::table("v_runall")->where("ID", $id)->get()->get(0);

            // Get graphs
            list($otherCharts, $averageLootForTier) = $this->graphContainerController->getRunGraphs($data);

            // Get all data and all loot
            $all_data = DB::table("runs")->where("ID", $id)->get()->get(0);
            $loot = DB::table("v_loot_details")->where("RUN_ID", $id)->get();
            $lost = DB::select("select `dl`.`ITEM_ID`                   AS `ITEM_ID`,
       `dl`.`RUN_ID`                    AS `RUN_ID`,
       `dl`.`COUNT`                     AS `COUNT`,
       `ip`.`NAME`                      AS `NAME`,
       `ip`.`DESCRIPTION`               AS `DESCRIPTION`,
       `ip`.`GROUP_NAME`                AS `GROUP_NAME`,
       `ip`.`PRICE_BUY`                 AS `PRICE_BUY`,
       `ip`.`PRICE_SELL`                AS `PRICE_SELL`,
       `ip`.`PRICE_BUY` * `dl`.`COUNT`  AS `BUY_PRICE_ALL`,
       `ip`.`PRICE_SELL` * `dl`.`COUNT` AS `SELL_PRICE_ALL`
from (`abyss`.`lost_items` `dl`
         join `abyss`.`item_prices` `ip` on (`dl`.`ITEM_ID` = `ip`.`ITEM_ID`)) where dl.`RUN_ID`=?;", [intval($id)]);

            // Get customization options
            list($percent, $run_summary) = $this->barkController->getRunSummaryBark($data, $averageLootForTier);
            $death_reason = $this->barkController->getDeathReasonBark($all_data);
            $looting = $this->barkController->getLootStrategyDescription($all_data);

            // Count same tiers
            $count_same_type_tier = DB::table("runs")->where("TYPE", $all_data->TYPE)->where("TIER", $all_data->TIER)->count();
            $count_same_ship = DB::table("runs")->where("SHIP_ID", $all_data->SHIP_ID)->count();

            // Get drop rates
            $this->runsController->extendDropListWithRates($loot, $all_data);

            return view("run", [
                "id"                   => $id,
                "run"                  => $data,
                "other"                => $otherCharts,
                "loot_table"           => $loot,
                "lost_table"           => $lost,
                "all_data"             => $all_data,
                "percent"              => ($percent),
                "run_summary"          => $run_summary,
                "death_reason"         => $death_reason,
                "loot_type"            => $looting,
                "count_same_type_tier" => $count_same_type_tier,
                "count_same_ship" => $count_same_ship
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
