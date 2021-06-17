<?php


	namespace App\Http\Controllers\PVP;

    use App\Charts\PvpCounters;
    use App\Charts\PvpEffective;
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
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class PvpStats {

        public static function getShipEffectiveAgainstChart(PvpEvent $event, int $shipTypeId) : PvpEffective {
            $dataset = collect(Cache::remember('ship-effective'.$event->id.".".$shipTypeId, now()->addMinutes(15), function () use ($event, $shipTypeId) {
                return DB::select('
                   select v.ship_type_id, s.name, count(v.killmail_id) as cnt
                    from pvp_victims v
                             inner join pvp_attackers a on v.killmail_id = a.killmail_id
                             left join pvp_type_id_lookup s on s.id = v.ship_type_id
                    where a.ship_type_id = ? and v.pvp_event_id=?
                    group by v.ship_type_id
                    order by 3 desc
                    limit 10;
               ', [$shipTypeId, $event->id]);
            }));


            $chart = new PvpEffective();
            $chart->height("300");
            $chart->theme(ThemeController::getChartTheme());
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->labels($dataset->pluck('name'));
            $chart->dataset("Effective against", 'pie', $dataset->pluck('cnt'))->options([
                "radius" => GraphHelper::HOME_PIE_RADIUS_SM
            ]);
            $chart->title("Effective against");
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
        public static function getShipCountersChart(PvpEvent $event, int $shipTypeId) : PvpCounters {
            $dataset = collect(Cache::remember('ship-counter'.$event->id.".".$shipTypeId, now()->addMinutes(15), function () use ($event, $shipTypeId) {
                return DB::select('
                   select a.ship_type_id, s.name, count(v.killmail_id) as cnt
                    from pvp_victims v
                             inner join pvp_attackers a on v.killmail_id = a.killmail_id
                             left join pvp_type_id_lookup s on s.id = a.ship_type_id
                    where v.ship_type_id = ? and v.pvp_event_id=?
                    group by a.ship_type_id
                    order by 3 desc
                    limit 10;
               ', [$shipTypeId, $event->id]);
            }));


            $chart = new PvpCounters();
            $chart->height("300");
            $chart->theme(ThemeController::getChartTheme());
            $chart->displayAxes(false);
            $chart->displayLegend(false);
            $chart->labels($dataset->pluck('name'));
            $chart->dataset("Counters", 'pie', $dataset->pluck('cnt'))->options([
                "radius" => GraphHelper::HOME_PIE_RADIUS_SM
            ]);
            $chart->title("Effective against");
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

        public static function getEventFeedPaginator(PvpEvent $event, int $itemsPerPage = 15) : LengthAwarePaginator {
            return PvpVictim::with([
                'attackers',
                'attackers.character',
                'character',
                'corporation',
                'alliance',
                'ship_type'])->where('pvp_event_id', $event->id)->orderByDesc('pvp_victims.created_at')->paginate($itemsPerPage);
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

        public static function getEventTopCorps(PvpEvent $event, int $limit = 20) {
            return collect(DB::select('select a.corporation_id as id, pc.name, count(distinct a.killmail_id) kills_count
from pvp_attackers a
join pvp_corporations pc on pc.id = a.corporation_id
where a.killmail_id in (select killmail_id from pvp_victims where pvp_event_id = ?)
and a.corporation_id is not null
group by a.corporation_id
order by 3  desc limit ?;
', [$event->id, $limit]));
        }
        public static function getEventTopAlliances(PvpEvent $event, int $limit = 20) {
            return collect(DB::select('select a.alliance_id as id, pc.name, count(distinct a.killmail_id) kills_count
from pvp_attackers a
join pvp_alliances pc on pc.id = a.alliance_id
where a.killmail_id in (select killmail_id from pvp_victims where pvp_event_id = ?)
and a.alliance_id is not null
group by a.alliance_id
order by 3  desc limit ?;
', [$event->id, $limit]));
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
            return self::getChartcontainerWinrateMulti($event, $id, 'character');
        }
        public static function getChartcontainerWinrateCorporation(PvpEvent $event, int $id) : PvpTopWeaponsChart {
            return self::getChartcontainerWinrateMulti($event, $id, 'corporation');
        }
        public static function getChartcontainerWinrateAlliance(PvpEvent $event, int $id) : PvpTopWeaponsChart {
            return self::getChartcontainerWinrateMulti($event, $id, 'alliance');
        }
        public static function getChartcontainerWinrateShip(PvpEvent $event, int $id) : PvpTopWeaponsChart {
            return self::getChartcontainerWinrateMulti($event, $id, 'ship_type');
        }
        public static function getChartcontainerWinrateMulti(PvpEvent $event, int $id, string $scope = 'character') : PvpTopWeaponsChart {
            $dataset = collect(DB::select("
            select (select count(distinct killmail_id)
        from pvp_victims
        where pvp_event_id = ? and ".$scope."_id = ?) as losses,
       (select count(distinct killmail_id)
        from pvp_attackers
        where killmail_id in (select killmail_id from pvp_victims where pvp_event_id = ?)
          and ".$scope."_id = ?)                      as wins;", [$event->id, $id, $event->id, $id]))->first();

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
            return self::getChartContainerTopWeaponsMulti($event, $id, $maxItems, 'character');
        }
        public static function getChartContainerTopWeaponsCorporation(PvpEvent $event, int $id, int $maxItems = 8) : PvpTopWeaponsChart {
            return self::getChartContainerTopWeaponsMulti($event, $id, $maxItems, 'corporation');
        }
        public static function getChartContainerTopWeaponsAlliance(PvpEvent $event, int $id, int $maxItems = 8) : PvpTopWeaponsChart {
            return self::getChartContainerTopWeaponsMulti($event, $id, $maxItems, 'alliance');
        }
        public static function getChartContainerTopWeaponsShip(PvpEvent $event, int $id, int $maxItems = 8) : PvpTopWeaponsChart {
            return self::getChartContainerTopWeaponsMulti($event, $id, $maxItems, 'ship_type');
        }

        public static function getChartContainerTopWeaponsMulti(PvpEvent $event, int $id, int $maxItems = 8, string $scope = 'character') : PvpTopWeaponsChart {
            $dataset = collect(DB::select("
            select pvp_attackers.weapon_type_id, pvp_type_id_lookup.name, count(distinct pvp_attackers.killmail_id) as kills_count
from pvp_attackers
         join pvp_type_id_lookup on pvp_attackers.weapon_type_id = pvp_type_id_lookup.id
         join pvp_victims pv on pvp_attackers.killmail_id = pv.killmail_id
where pv.pvp_event_id = ? and pvp_attackers.".$scope."_id=? /*and pvp_attackers.weapon_type_id not in (select distinct ship_type_id from pvp_attackers)*/
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

        public static function getShipsChartContainer(PvpEvent $event, int $id, int $maxItems = 8, string $scope = 'character') {
            $dataset = collect(DB::select("
select a.ship_type_id, a.name, sum(a.kills_count) as kills_count
from (
         select pv.ship_type_id, pt.name, count(distinct pv.killmail_id) as kills_count
         from pvp_victims pv
                  join pvp_type_id_lookup pt on pv.ship_type_id = pt.id
         where pv.pvp_event_id = ?
           and pv.".$scope."_id = ?
         group by pv.ship_type_id, pt.name
         union
         select v.ship_type_id, l.name, count(distinct v.killmail_id) as kills_count
         from pvp_attackers v
                  join pvp_type_id_lookup l
                       on v.ship_type_id = l.id
         where v.killmail_id in (select killmail_id from pvp_victims where pvp_event_id = ?)
           and v.".$scope."_id = ?
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

        public static function getShipsChartContainerCharacter(PvpEvent $event, int $id, int $maxItems = 8) : PvpTopShipsChart {
            return self::getShipsChartContainer($event, $id, $maxItems, 'character');
        }
        public static function getShipsChartContainerCorporation(PvpEvent $event, int $id, int $maxItems = 8) : PvpTopShipsChart {
            return self::getShipsChartContainer($event, $id, $maxItems, 'corporation');
        }
        public static function getShipsChartContainerAlliance(PvpEvent $event, int $id, int $maxItems = 8) : PvpTopShipsChart {
            return self::getShipsChartContainer($event, $id, $maxItems, 'alliance');
        }
        public static function getChartContainerTopShipsWeapon(PvpEvent $event, int $id, int $maxItems = 8) : PvpTopShipsChart {
            $scope = 'weapon_type';
            $dataset = collect(DB::select("
select a.ship_type_id, a.name, sum(a.kills_count) as kills_count
from (
         select v.ship_type_id, l.name, count(distinct v.killmail_id) as kills_count
         from pvp_attackers v
                  join pvp_type_id_lookup l
                       on v.ship_type_id = l.id
         where v.killmail_id in (select killmail_id from pvp_victims where pvp_event_id = ?)
           and v.".$scope."_id = ?
    group by v.ship_type_id, l.name
     ) a
group by a.ship_type_id, a.name
order by 3 desc
limit ?
            ;", [$event->id, $id, $maxItems]));

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
