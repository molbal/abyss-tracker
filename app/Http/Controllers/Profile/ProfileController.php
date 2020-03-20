<?php


	namespace App\Http\Controllers\Profile;


	use App\Charts\ShipCruiserChart;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\ThemeController;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class ProfileController extends Controller {



        public function index(int $id) {

            if (!DB::table("chars")->where("CHAR_ID", $id)->exists()) {
                return view("error", ["error" => "No such user found"]);
            }

            $name = DB::table("chars")->where("CHAR_ID", $id)->value("NAME");

            $runs = DB::table("v_runall")
                ->where("CHAR_ID", $id)
                ->where("PUBLIC", 1)
                ->orderBy("CREATED_AT", "DESC")
                ->paginate(15);

            $my_avg_loot = DB::table("runs")->where("CHAR_ID", $id)->where("PUBLIC", 1)->avg('LOOT_ISK');
            $my_sum_loot = DB::table("runs")->where("CHAR_ID", $id)->where("PUBLIC", 1)->sum('LOOT_ISK');
            $my_runs_count = DB::table("runs")->where("CHAR_ID", $id)->where("PUBLIC", 1)->count();
            $my_survival_ratio = (DB::table("runs")->where("CHAR_ID", $id)->where("PUBLIC", 1)->where("SURVIVED", '=', true)->count()) / max(1, $my_runs_count) * 100;

            [$query_ships, $favoriteShipsChart] = $this->getProfileShipsChart($id);

            $access = $this->getAllRights($id);
            return view('profile', [
                'id' => $id,
                'name' =>$name,
                'last_runs' => $runs,
                'my_avg_loot' => $my_avg_loot,
                'my_sum_loot' => $my_sum_loot,
                'my_runs_count' => $my_runs_count,
                'my_survival_ratio' => $my_survival_ratio,
                'query_ships' => $query_ships,
                'favoriteShipsChart' => $favoriteShipsChart,
                'access' => $access
            ]);
        }




        /**
         * Gets default display levels
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

        public function getAllRights(int $userId):array {
            $rights = ["LAST_RUNS","TOTAL_LOOT","TOTAL_RUNS","LOOT","SHIPS","SURVIVAL"];
            $ar = [];
            foreach ($rights as $right) {
                $ar[$right] = $this->getRight($userId, $right);
            }
            return $ar;
        }

        /**
         * Persists a DB setting
         * @param int    $userId
         * @param string $panel
         * @param int    $visible
         */
        public function persistRight(int $userId, string $panel, int $visible):void {
            DB::beginTransaction();
            if (DB::table("privacy")
                  ->where("CHAR_ID", $userId)
                  ->where("PANEL", $panel)
                  ->exists()) {
                DB::table("privacy")
                      ->where("CHAR_ID", $userId)
                      ->where("PANEL", $panel)
                      ->update(["DISPLAY" => $visible ? "public" : "private"]);
            }
            else {
                DB::table("privacy")
                    ->insert([
                        "CHAR_ID" => $userId,
                        "PANEL" => $panel,
                        "DISPLAY" => $visible ? "public" : "private"]);
            }
        }

        /**
         * Gets if a panel should be visible
         * @param int    $userId
         * @param string $panel
         *
         * @return bool
         */
        private function getRight(int $userId, string $panel):bool {
            if (DB::table("privacy")
            ->where("CHAR_ID", $userId)
            ->where("PANEL", $panel)
            ->exists()) {
                return DB::table("privacy")
                         ->where("CHAR_ID", $userId)
                         ->where("PANEL", $panel)
                         ->value("DISPLAY") == 'public';
            }
            else {
                return $this->getDefaultVisibility($panel);
            }
        }

        /**
         * @return array
         */
        public function getProfileShipsChart(int $id): array {
            $query_cruiser = Cache::remember("ships.profile.$id", 20, function() use ($id) {
                return DB::select("select count(r.ID) as RUNS, l.Name as NAME, l.ID as SHIP_ID
                    from runs r inner join ship_lookup l on r.SHIP_ID=l.ID
                    where r.CHAR_ID=".$id." and r.PUBLIC=1
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
            $shipCruiserChart->dataset("Favorite ships", "pie", $values)->options([
                "radius"   => [30, 120],
                "roseType" => "radius"
            ]);
            $shipCruiserChart->displayLegend(false);
            return [$query_cruiser, $shipCruiserChart];
        }
	}
