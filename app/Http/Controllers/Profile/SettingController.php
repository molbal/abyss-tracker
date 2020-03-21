<?php


    namespace App\Http\Controllers\Profile;


    use App\Charts\ShipCruiserChart;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\ThemeController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class SettingController extends Controller {


        /**
         * Handles the settings form
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index() {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }
            $access = $this->getAllRights(session()->get("login_id"));

            return view('settings', ['access' => $access]);
        }

        /**
         * Handles saving settings
         *
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function save(Request $request) {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            $rights = ['LAST_RUNS', 'TOTAL_LOOT', 'TOTAL_RUNS', 'LOOT', 'SHIPS', 'SURVIVAL'];

            try {

                $userId = session()->get("login_id");
                foreach ($rights as $right) {
                    $this->persistRight($userId, $right, intval($request->get($right)) == 1 ? 1 : 0);
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage() . " " . $e->getFile() . "@" . $e->getLine());

                return view("error", ["error" => "Something went wrong: " . $e->getMessage()]);
            }

            return view('sp_message', ['title' => 'Settings saved', 'message' => 'Your settings were updated.']);
        }


        /**
         * Gets default display levels
         *
         * @param string $panel
         *
         * @return bool
         */
        private function getDefaultVisibility(string $panel) {
            switch ($panel) {
                case 'LAST_RUNS':
                case 'TOTAL_LOOT':
                case 'TOTAL_RUNS':
                    return true;
                case 'LOOT':
                case 'SHIPS':
                case 'SURVIVAL':
                default:
                    return false;
            }
        }

        public function getAllRights(int $userId) : array {
            $rights = ["LAST_RUNS", "TOTAL_LOOT", "TOTAL_RUNS", "LOOT", "SHIPS", "SURVIVAL"];
            $ar = [];
            foreach ($rights as $right) {
                $ar[$right] = $this->getRight($userId, $right);
            }

            return $ar;
        }

        /**
         * Persists a DB setting
         *
         * @param int    $userId
         * @param string $panel
         * @param int    $visible
         */
        public function persistRight(int $userId, string $panel, int $visible) : void {
            DB::beginTransaction();
            try {

                if (DB::table("privacy")->where("CHAR_ID", $userId)->where("PANEL", $panel)->exists()) {
                    DB::table("privacy")->where("CHAR_ID", $userId)->where("PANEL", $panel)->update(["DISPLAY" => $visible ? "public" : "private"]);
                } else {
                    DB::table("privacy")->insert(["CHAR_ID" => $userId, "PANEL" => $panel, "DISPLAY" => $visible ? "public" : "private"]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("SQL error: ".$e->getMessage()." rolling back transaction.");
                throw $e;
            }
        }

        /**
         * Gets if a panel should be visible
         *
         * @param int    $userId
         * @param string $panel
         *
         * @return bool
         */
        private function getRight(int $userId, string $panel) : bool {
            if (DB::table("privacy")->where("CHAR_ID", $userId)->where("PANEL", $panel)->exists()) {
                return DB::table("privacy")->where("CHAR_ID", $userId)->where("PANEL", $panel)->value("DISPLAY") == 'public';
            } else {
                return $this->getDefaultVisibility($panel);
            }
        }

        /**
         * @return array
         */
        public function getProfileShipsChart(int $id) : array {
            $query_cruiser = Cache::remember("ships.profile.$id", 20, function () use ($id) {
                return DB::select("select count(r.ID) as RUNS, l.Name as NAME, l.ID as SHIP_ID
                    from runs r inner join ship_lookup l on r.SHIP_ID=l.ID
                    where r.CHAR_ID=" . $id . " and r.PUBLIC=1
                    group by r.SHIP_ID, l.NAME, l.ID
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
            $shipCruiserChart->dataset("Favorite ships", "pie", $values)->options(["radius" => [30, 120], "roseType" => "radius"]);
            $shipCruiserChart->displayLegend(false);

            return [$query_cruiser, $shipCruiserChart];
        }
    }