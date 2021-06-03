<?php


	namespace App\Http\Controllers\PVP;

    use App\Charts\PvpTopAttackersChart;
    use App\Charts\PvpTopShipsChart;
    use App\Charts\PvpTopWeaponsChart;
    use App\Http\Controllers\GraphHelper;
    use App\Http\Controllers\ThemeController;
    use App\Pvp\PvpEvent;
    use App\Pvp\PvpVictim;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class PvpStats {

        public static function getEventFeedPaginator(PvpEvent $event, int $itemsPerPage = 15) : LengthAwarePaginator {
            return PvpVictim::with([
                'attackers',
                'attackers.character',
                'character',
                'corporation',
                'alliance',
                'ship_type'])->where('pvp_event_id', $event->id)->orderByDesc('pvp_victims.created_at')->paginate($itemsPerPage);

//            DB::table("pvp_victims v")
//              ->join("pvp_type_id_lookup t", function($join){
//                  $join->on("v.ship_type_id", "=", "t.id");
//              })
//              ->join("pvp_characters pc", function($join){
//                  $join->on("pc.id", "=", "v.character_id");
//              })
//              ->join("pvp_corporati", function($join){
//                  $join->on("ons", "p", "v.corporation_id");
//              })
//              ->leftJoin("pvp_alliances pa", function($join){
//                  $join->on("v.alliance_id", "=", "pa.id");
//              })
//              ->select("v.killmail_id", "v.character_id", "pc.name as character_name", "v.corporation_id", "p.name as corporation_name", "v.alliance_id", "pa.name as alliance_name", "v.ship_type_id", "t.name as ship_name", "v.created_at")
//              ->where("pvp_event_id", "=", 1)
//              ->orderBy("v.created_at","desc")
//              ->get();


        }

        public static function getTopAttackersChart(Model|PvpVictim|Builder $victim) : PvpTopAttackersChart {
            $attackers = new PvpTopAttackersChart();
            $labels = collect();
            foreach ($victim->attackers as $attacker) {
                $labels->add($attacker->isCapsuleer() ? $attacker->character->name : 'NPC ' . $attacker->ship_type->name);
            }
            $attackers->labels($labels);
            $attackers->dataset('Damage dealt', 'pie', $victim->attackers()->pluck('damage_done'))->options([
                "radius" => GraphHelper::HOME_PIE_RADIUS_SM
            ]);

            $attackers->displayAxes(false);
            $attackers->displayLegend(false);
            $attackers->theme(ThemeController::getChartTheme());
            $attackers->height('300');

            return $attackers;
        }


        public static function getEventTopKillsPaginator(PvpEvent $event, int $itemsPerPage = 15) : LengthAwarePaginator {
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

        public static function getChartContainerTopShips(PvpEvent $event, int $maxItems = 8) : PvpTopShipsChart {
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
            $chart->height("300");
            $chart->theme(ThemeController::getChartTheme());
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->labels($dataset->pluck('name'));
            $chart->dataset($event->name." kills", 'pie', $dataset->pluck('kills_count'))->options([
                "radius" => GraphHelper::HOME_PIE_RADIUS_SM
            ]);
            $chart->title($event->name." ship meta");
            $chart->options([
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

        public static function getChartContainerTopWeapons(PvpEvent $event, int $maxItems = 8) : PvpTopWeaponsChart {
            $dataset = collect(DB::select("
            select pvp_attackers.weapon_type_id, pvp_type_id_lookup.name, count(distinct pvp_attackers.killmail_id) as kills_count
from pvp_attackers
         join pvp_type_id_lookup on pvp_attackers.weapon_type_id = pvp_type_id_lookup.id
         join pvp_victims pv on pvp_attackers.killmail_id = pv.killmail_id
where pv.pvp_event_id = ?
and pvp_attackers.weapon_type_id not in (select distinct p2.ship_type_id from pvp_victims p2)
group by pvp_attackers.weapon_type_id
order by kills_count desc
limit ?;", [$event->id, $maxItems]));

            $chart = new PvpTopWeaponsChart();
            $chart->height("300");
            $chart->theme(ThemeController::getChartTheme());
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->labels($dataset->pluck('name'));
            $chart->dataset($event->name." kills", 'pie', $dataset->pluck('kills_count'))->options([
                "radius" => GraphHelper::HOME_PIE_RADIUS_SM
            ]);
            $chart->options([
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


        public static function getChartcontainerWinrateCharacter(PvpEvent $event, int $id) : PvpTopWeaponsChart {
            $dataset = collect(DB::select("
            select (select count(distinct killmail_id)
        from pvp_victims
        where pvp_event_id = ? and character_id = ?) as losses,
       (select count(distinct killmail_id)
        from pvp_attackers
        where killmail_id in (select killmail_id from pvp_victims where pvp_event_id = ?)
          and character_id = ?)                      as wins;", [$event->id, $id, $event->id, $id]))->first();

            $chart = new PvpTopWeaponsChart();
            $chart->height("300");
            $chart->theme(ThemeController::getChartTheme());
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->labels(['Wins', 'Losses']);
            $chart->dataset("Win rate", 'pie', [$dataset->wins, $dataset->losses])->options([
                "radius" => GraphHelper::HOME_PIE_RADIUS_SM
            ]);
            $chart->title("In ".$event->name);
            $chart->options([
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

        public static function getChartContainerTopWeaponsCharacter(PvpEvent $event, int $id, int $maxItems = 8) : PvpTopWeaponsChart {
            $dataset = collect(DB::select("
            select pvp_attackers.weapon_type_id, pvp_type_id_lookup.name, count(distinct pvp_attackers.killmail_id) as kills_count
from pvp_attackers
         join pvp_type_id_lookup on pvp_attackers.weapon_type_id = pvp_type_id_lookup.id
         join pvp_victims pv on pvp_attackers.killmail_id = pv.killmail_id
where pv.pvp_event_id = ? and pvp_attackers.character_id=?
and pvp_attackers.weapon_type_id not in (select distinct p2.ship_type_id from pvp_victims p2)
group by pvp_attackers.weapon_type_id
order by kills_count desc
limit ?;", [$event->id, $id, $maxItems]));

            $chart = new PvpTopWeaponsChart();
            $chart->height("300");
            $chart->theme(ThemeController::getChartTheme());
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->labels($dataset->pluck('name'));
            $chart->dataset("Favourite weapons", 'pie', $dataset->pluck('kills_count'))->options([
                "radius" => GraphHelper::HOME_PIE_RADIUS_SM
            ]);
            $chart->title("In ".$event->name);
            $chart->options([
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

        public static function getShipsChartContainerCharacter(PvpEvent $event, int $id, int $maxItems = 8) {
            $dataset = collect(DB::select("
select a.ship_type_id, a.name, sum(a.kills_count) as kills_count
from (
         select pv.ship_type_id, pt.name, count(distinct pv.killmail_id) as kills_count
         from pvp_victims pv
                  join pvp_type_id_lookup pt on pv.ship_type_id = pt.id
         where pv.pvp_event_id = ?
           and pv.character_id = ?
         group by pv.ship_type_id, pt.name
         union
         select v.ship_type_id, l.name, count(distinct v.killmail_id) as kills_count
         from pvp_victims v
                  join pvp_type_id_lookup l
                       on v.ship_type_id = l.id
         where v.pvp_event_id = ?
           and v.character_id = ?
    group by v.ship_type_id, l.name
     ) a
group by a.ship_type_id, a.name
order by 3 desc
limit ?
            ;", [$event->id, $id,$event->id, $id, $maxItems]));

            $chart = new PvpTopShipsChart();
            $chart->height("300");
            $chart->theme(ThemeController::getChartTheme());
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->labels($dataset->pluck('name'));
            $chart->dataset("Favourite ships", 'pie', $dataset->pluck('kills_count'))->options([
                "radius" => GraphHelper::HOME_PIE_RADIUS_SM
            ]);
            $chart->title("In ".$event->name);
            $chart->options([
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
