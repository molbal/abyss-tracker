<?php


	namespace App\Http\Controllers\PVP;


	use App\Charts\FrigateChart;
    use App\Charts\PvpTopShipsChart;
    use App\Http\Controllers\ThemeController;
    use App\Pvp\PvpEvent;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class PvpStats {

        public static function getEventTopKillsPaginator(PvpEvent $event, int $itemsPerPage = 15) {
            return
                DB::table("pvp_attackers", "attacker")
                  ->join("pvp_characters as pc", function($join){
                      $join->on("attacker.character_id", "=", "pc.id");
                  })
                  ->join("pvp_victims as pv", function($join){
                      $join->on("pv.killmail_id", "=", "attacker.killmail_id");
                  })
                  ->select(["pc.name", "pc.id", DB::raw("count(attacker.id) as kills_count")])
                  ->where("pv.pvp_event_id", "=", $event->id)
                  ->orderBy("kills_count","desc")
                  ->groupBy("pc.id")
                  ->paginate($itemsPerPage);
	    }

        public static function getChartContainerTopShips(PvpEvent $event, int $maxItems = 8) {

            $dataset = collect(DB::select("
            select pvp_attackers.ship_type_id, pvp_type_id_lookup.name, count(distinct pvp_attackers.killmail_id) as kills_count
from pvp_attackers
         join pvp_type_id_lookup on pvp_attackers.ship_type_id = pvp_type_id_lookup.id
         join pvp_victims pv on pvp_attackers.killmail_id = pv.killmail_id
where pv.pvp_event_id = ?
group by pvp_attackers.ship_type_id
order by kills_count desc
limit ?;", [$event->id, $maxItems]));

            $chart = new PvpTopShipsChart();
            $chart->height("400");
            $chart->theme(ThemeController::getChartTheme());
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->labels($dataset->pluck('name'));
            $chart->dataset($event->name." ship meta", 'pie', $dataset->pluck('kills_count'))->options([

            ]);
            $chart->title($event->name." ship meta");
            $chart->options([
//                "roseType" => "radius",
                'label' => [
                    'position' => 'inside',
                    'alignTo' => 'none',
                    'bleedMargin' => 250
                ],
                'tooltip'=> [
                    'confine' => true
                ]
            ]);

            return $chart;
        }
	}
