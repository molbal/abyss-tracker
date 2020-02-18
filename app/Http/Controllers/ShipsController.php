<?php


    namespace App\Http\Controllers;


    use App\Charts\LootTierChart;
    use App\Charts\PersonalDaily;
    use App\Charts\ShipCruiserChart;
    use App\Charts\ShipFrigateChart;
    use App\Http\Controllers\Loot\LootCacheController;
    use DateTime;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use function Psy\debug;

    class ShipsController extends Controller {

        /** @var LootCacheController */
        private $lootCacheController;

        /**
         * ItemController constructor.
         *
         * @param LootCacheController $lootCacheController
         */
        public function __construct(LootCacheController $lootCacheController) {
            $this->lootCacheController = $lootCacheController;
        }


        /**
         * Handles the all ships view
         * TODO: Move chart renders to its respectible controllers
         * TODO: Make ship list types
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        function get_all() {
            $query_cruiser = Cache::remember("ships.cruisers", 20, function () {
                return DB::select("select count(r.ID) as RUNS, l.Name as NAME, l.ID as SHIP_ID
                    from runs r inner join ship_lookup l on r.SHIP_ID=l.ID
                    where l.IS_CRUISER=1
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
            $shipCruiserChart->dataset("Cruisers", "pie", $values)->options([
                "radius" => [70, 170],
                "roseType" => "radius"
            ]);
            $shipCruiserChart->displayLegend(false);


            $query_frig = Cache::remember("ships.frigates", 20, function () {
                return DB::select("select count(r.ID) as RUNS, l.Name as NAME, l.ID as SHIP_ID
                    from runs r inner join ship_lookup l on r.SHIP_ID=l.ID
                    where l.IS_CRUISER=0
                    group by r.SHIP_ID, l.NAME, l.ID
                    order by 1 desc
                    limit 15");
            });

            $dataset = [];
            $values = [];
            foreach ($query_frig as $type) {
                $i = 7;
                if ($i-- == 0) break;
                $dataset[] = $type->NAME;
                $values[] = $type->RUNS;
            }


            $shipFrigateChart = new ShipFrigateChart();
            $shipFrigateChart->export(true, "Download");
            $shipFrigateChart->displayAxes(false);
            $shipFrigateChart->height(400);
            $shipFrigateChart->theme(ThemeController::getChartTheme());
            $shipFrigateChart->labels($dataset);
            $shipFrigateChart->dataset("Cruisers", "pie", $values)->options([
                "radius" => [70, 170],
                "roseType" => "radius"
            ]);
            $shipFrigateChart->displayLegend(false);



            return view("ships", [
                "cruiser_chart" => $shipCruiserChart,
                "frigate_chart" => $shipFrigateChart,
                "query_cruiser" => $query_cruiser,
                "query_frigate" => $query_frig,
            ]);
        }


        function get_single(int $id) {

            $name = DB::table("ship_lookup")->where("ID", $id)->value("NAME");

            list($dates, $values) = Cache::remember("ship.popularity.$id", 180, function() use ($id) {
                $dates = [];
                $values= [];
                for ($i=-90; $i<=0; $i++) {
                    $date = strtotime("now $i days");
                    $val = DB::select("select (select count(ID) from runs where RUN_DATE=?) as 'ALL', (select count(ID) from runs where RUN_DATE=? and SHIP_ID=?) as 'SHIP';",
                        [
                            date('Y-m-d', $date),
                            date('Y-m-d', $date),
                            $id
                        ]);
                    $dates[] = date("M.d.", $date);
                    if ($val[0]->ALL == 0) {
                        $values[] = 0.0;
                    }
                    else {
                        $values[] = round(($val[0]->SHIP/$val[0]->ALL)*100, 2);
                    }
                }
                return [$dates, $values];
            });

            $pop = new PersonalDaily();
            $pop->displayAxes(true);
            $pop->export(true, "Download");
            $pop->height(400);
            $pop->theme(ThemeController::getChartTheme());
            $pop->displayLegend(false);
            $pop->labels($dates);
            $pop->dataset("Popularity", "line", $values)->options([
                'smooth' => true,
                'symbolSize' => 0,
                'smoothMonotone' => 'x'
            ]);


            return view("ship", [
                "name" => $name,
                "pop_chart" => $pop
            ]);
        }
    }
