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

            $runs = DB::table("V_runall")
                ->where("CHAR_ID", $id)
                ->where("PUBLIC", 1)
                ->orderBy("CREATED_AT", "DESC")
                ->paginate(15);

            $my_avg_loot = DB::table("runs")->where("CHAR_ID", $id)->where("PUBLIC", 1)->avg('LOOT_ISK');
            $my_sum_loot = DB::table("runs")->where("CHAR_ID", $id)->where("PUBLIC", 1)->sum('LOOT_ISK');
            $my_runs_count = DB::table("runs")->where("CHAR_ID", $id)->where("PUBLIC", 1)->count();
            $my_survival_ratio = (DB::table("runs")->where("CHAR_ID", $id)->where("PUBLIC", 1)->where("SURVIVED", '=', true)->count()) / max(1, $my_runs_count) * 100;

            list($query_ships, $favoriteShipsChart) = $this->getProfileShipsChart($id);

            return view('profile', [
                'id' => $id,
                'name' =>$name,
                'last_runs' => $runs,
                'my_avg_loot' => $my_avg_loot,
                'my_sum_loot' => $my_sum_loot,
                'my_runs_count' => $my_runs_count,
                'my_survival_ratio' => $my_survival_ratio,
                'query_ships' => $query_ships,
                'favoriteShipsChart' => $favoriteShipsChart
            ]);
        }


        /**
         * @return array
         */
        public function getProfileShipsChart(int $id): array {
            $query_cruiser = Cache::remember("ships.cruisers.$id", 20, function() use ($id) {
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
