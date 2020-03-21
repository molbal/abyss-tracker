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
    use App\Mail\RunFlagged;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;
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

            [$my_runs, $my_avg_loot, $my_sum_loot, $my_survival_ratio, $data] = $this->homeQueriesController->getPersonalStats();

            $labels = [];
            foreach ($data as $type) {
                $labels[] = date("m.d", strtotime($type->RUN_DATE));
            }
            [$personalDaily, $iskPerHour] = $this->graphContainerController->getPersonalStatsCharts($labels);

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

            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            Validator::make($request->all(), [
                'TYPE'     => 'required',
                'TIER'     => 'required',
                'SURVIVED' => 'required',
                'PUBLIC'   => 'required',
                'RUN_DATE' => 'required|date',
                'KILLMAIL' => 'nullable|regex:/https?:\/\/zkillboard\.com\/kill\/\d+\/?/m',
                'RUN_LENGTH_M' => 'nullable|numeric|min:0|max:20',
                'RUN_LENGTH_S' => 'nullable|numeric|min:0|max:59',
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

            DB::table("stopwatch")->where("CHAR_ID", session()->get("login_id"))->delete();
            return redirect(route("view_single", ["id" => $id]));
        }

        /**
         * Changes privacy
         * @param int    $id
         * @param string $privacy
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         */
        public function change_privacy(int $id, string $privacy) {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            $run = DB::table("runs")->where("ID", $id)->get()->get(0);
            if ($run->CHAR_ID != session()->get("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            DB::table("runs")->where("ID", $id)->update([
                "PUBLIC" => $privacy == "public" ? 1 : 0
            ]);

            return redirect(route("view_single", ["id" => $id]));

        }

        /**
         * Handles getting the new run screen
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function form_new() {
            if (session()->has("login_id")) {
                $ships = DB::table("ship_lookup")->orderBy("NAME", "ASC")->get();

                $stopwatch_enabled = DB::table("chars")->where("CHAR_ID", session()->get("login_id"))->get()->get(0)->REFRESH_TOKEN;


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
            [$otherCharts, $averageLootForTier] = $this->graphContainerController->getRunGraphs($data);

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
            $lost = $this->normalizeLootAndLost($id, $all_data, $lost, $loot);

            // Get customization options
            [$percent, $run_summary] = $this->barkController->getRunSummaryBark($data, $averageLootForTier);
            $death_reason = $this->barkController->getDeathReasonBark($all_data);
            $looting = $this->barkController->getLootStrategyDescription($all_data);

            // Count same tiers
            $count_same_type_tier = DB::table("runs")->where("TYPE", $all_data->TYPE)->where("TIER", $all_data->TIER)->count();
            $count_same_ship = DB::table("runs")->where("SHIP_ID", $all_data->SHIP_ID)->count();

            // Get drop rates
//            dd($loot, $all_data);
            $this->runsController->extendDropListWithRates($loot, $all_data);

            $reported = DB::table("run_report")->where("RUN_ID", $id)->exists();
            $reported_message = DB::table("run_report")->where("RUN_ID", $id)->value("MESSAGE");

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
                "count_same_ship" => $count_same_ship,
                "reported" => $reported,
                "reported_message" => $reported_message
            ]);
        }

        public function get_all($order_by = "", $order_type = "") {
            $builder = DB::table("v_runall");
            [$order_by, $order_by_text, $order_type_text, $order_type] = $this->getSort($order_by, $order_type);

            $items = $builder->orderBy($order_by, $order_type)->paginate(25);
            return view("runs", ["order_type" => $order_type_text, "order_by" => $order_by_text, "items" => $items]);
        }


        /**
         * Gets the logged in user's runs
         * @param string $order_by
         * @param string $order_type
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
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
         * Flags a run for review
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function flag(Request $request)
        {
            Validator::make($request->all(), ['id' => 'int|required', 'message' => 'required|min:5|max:1000'])->validate();

            $id = $request->get('id');
            $message = $request->get('message');

            $run_owner = DB::table("runs")->where("ID", $id)->value("CHAR_ID");

            if ($run_owner == session()->get('login_id')) {
                return view('error', ['error' => 'You can not flag your own run. Please delete it instead.']);
            } else {
                if (DB::table("run_report")->where("RUN_ID", $id)->exists()) {
                    return view('sp_message', ['title' => 'Run already flagged', 'message' => "This run was already flagged by someone else."]);
                }




                DB::table("run_report")->insert([
                    'REPORTER_CHAR_ID' => session()->get("login_id"),
                    'RUN_ID' => $id,
                    'MESSAGE' => $message,
                    'PROCESSED' => false
                ]);

                $text = "Run number $id was flagged by ".session()->get("login_name")." at ".date("Y-m-d H:i:s"). " because ".htmlentities($message);

                Mail::to(env("FLAG_ADDRESS"))->send(new RunFlagged($id, $message));

                return view('sp_message', ['title' => 'Run flagged', 'message' => "You have flagged this run! It will be manually reviewed soon."]);
            }

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



        /**
         * Handles the deletion of a run
         * @param int $id
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function delete(int $id) {

            $run_owner = DB::table("runs")
                ->where("ID", $id)
                ->value("CHAR_ID");

            if ($run_owner == session()->get('login_id')) {
                DB::table("runs")->where("ID", $id)->where("CHAR_ID", session()->get('login_id'))->delete();
                DB::table("detailed_loot")->where("RUN_ID", $id)->delete();
                DB::table("lost_items")->where("RUN_ID", $id)->delete();
                return view('sp_message', ['title' => 'Run deleted', 'message' => "Run #$id successfully deleted."]);
            }
            else {
                return view('error', ['error' => 'Please log in to delete your run.']);
            }

        }

        /**
         * @param                                $id
         * @param                                $all_data
         * @param array                          $lost
         * @param \Illuminate\Support\Collection $loot
         *
         * @return array
         */
        private function normalizeLootAndLost($id, $all_data, array $lost, \Illuminate\Support\Collection $loot) : array
        {
// Get which filament shall be used now
            $filament_id = DB::table("filament_types")->where("TIER", $all_data->TIER)->where("TYPE", $all_data->TYPE)->value("ITEM_ID");

            // Check if we there is anything here
            if (count($lost) == 0) {

                $is_frigate = false;
                if ($all_data->SHIP_ID) {
                    $is_frigate = intval(DB::table("ship_lookup")->where("ID", $all_data->SHIP_ID)->value("IS_CRUISER")) == 0;
                }

                // Add the missing filament
                $lost = DB::select("select
                    `ip`.`ITEM_ID`                   AS `ITEM_ID`,
                    ".($is_frigate ? 3 : 1)."                 AS `COUNT`,
                    `ip`.`NAME`                      AS `NAME`,
                    `ip`.`DESCRIPTION`               AS `DESCRIPTION`,
                    `ip`.`GROUP_NAME`                AS `GROUP_NAME`,
                    `ip`.`PRICE_BUY`                 AS `PRICE_BUY`,
                    `ip`.`PRICE_SELL`                AS `PRICE_SELL`,
                    ".($is_frigate ? 3 : 1)."*`ip`.`PRICE_BUY` AS `BUY_PRICE_ALL`,
                    ".($is_frigate ? 3 : 1)."*`ip`.`PRICE_SELL` AS `SELL_PRICE_ALL`
from (`abyss`.`item_prices` `ip`) where ip.`ITEM_ID`=?;", [intval($filament_id)]);
            } else {
                // If it doesnt exist in the list probably it was both looted and used
                $lost_has_filament = false;
                foreach ($lost as $item) {
                    if ($item->ITEM_ID == $filament_id) {
                        $lost_has_filament = true;
                        break;
                    }
                }

                if (!$lost_has_filament) {
                    $item = DB::select("select
                    `ip`.`ITEM_ID`                   AS `ITEM_ID`,
                    " . intval($id) . " AS `RUN_ID`,
                    1                 AS `COUNT`,
                    `ip`.`NAME`                      AS `NAME`,
                    `ip`.`DESCRIPTION`               AS `DESCRIPTION`,
                    `ip`.`GROUP_NAME`                AS `GROUP_NAME`,
                    `ip`.`PRICE_BUY`                 AS `PRICE_BUY`,
                    `ip`.`PRICE_SELL`                AS `PRICE_SELL`,
                    `ip`.`PRICE_BUY` AS `BUY_PRICE_ALL`,
                    `ip`.`PRICE_SELL` AS `SELL_PRICE_ALL`
from (`abyss`.`item_prices` `ip`) where ip.`ITEM_ID`=?;", [intval($filament_id)])[0];
                    $loot->add($item);
                    $lost[] = $item;
                }
            }

            return $lost;
        }

    }
