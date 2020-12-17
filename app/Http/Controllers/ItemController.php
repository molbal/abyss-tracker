<?php


    namespace App\Http\Controllers;


    use App\Charts\CruiserChart;
    use App\Charts\DropHistoryChart;
    use App\Charts\FrigateChart;
    use App\Charts\ItemTierChart;
    use App\Charts\ItemTypeChart;
    use App\Charts\MarketESIChart;
    use App\Connector\EveAPI\Market\MarketService;
    use App\Http\Controllers\Cache\DBCacheController;
    use App\Http\Controllers\Loot\LootCacheController;
    use App\Http\Controllers\Misc\Enums\ChartColor;
    use App\Http\Controllers\Misc\Enums\ShipHullSize;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ItemController extends Controller {

        /** @var MarketService */
        private $marketService;

        /** @var LootCacheController */
        private $lootCacheController;

        /**
         * ItemController constructor.
         *
         * @param MarketService       $marketService
         * @param LootCacheController $lootCacheController
         */
        public function __construct(MarketService $marketService, LootCacheController $lootCacheController) {
            $this->marketService = $marketService;
            $this->lootCacheController = $lootCacheController;
        }


        public function get_single(int $item_id) {
            $item = DB::table("item_prices")->where("ITEM_ID", $item_id);
            if (!$item->exists()) {
                return view('error', [
                    "error" => "Sorry, we do not have info of this item yet."
                ]);
            }
            else {
                $item = $item->get()->get(0);
            }

            $builder = DB::table("detailed_loot")->where("ITEM_ID", $item_id);
            $count = $builder->count();

            $max_runs = 1;
            $drop_rate_overall = 0;

            try {
                $drop_rates = $this->lootCacheController->getAllItemStats($item_id);
            }catch (\Exception $e) {
                Log::warning("Unable to get drop rates: " . $e->getMessage());
            }

            $marketHistory = $this->itemMarketHistoryChart($item_id);
            $volumeHistory = $this->itemVolumeHistoryChart($item_id);


            $runs =  DB::table("v_runall")
                ->join('detailed_loot', 'detailed_loot.RUN_ID', '=', 'v_runall.ID')
                ->where('detailed_loot.ITEM_ID', $item_id)
                ->orderBy("v_runall.ID", "DESC")
                ->limit(20)
                ->select(['v_runall.ID','v_runall.CHAR_ID','v_runall.PUBLIC','v_runall.TIER','v_runall.TYPE','v_runall.LOOT_ISK','v_runall.SURVIVED','v_runall.RUN_DATE','v_runall.NAME','v_runall.SHIP_NAME','v_runall.HULL_SIZE','v_runall.SHIP_ID','v_runall.CREATED_AT','v_runall.RUNTIME_SECONDS'])
                ->get();


            $item->DESCRIPTION = str_replace("
", '<br/>', $item->DESCRIPTION);


            $itemTiersChart = $this->itemTiersChart($item_id);
            $itemTypesChart = $this->itemTypesChart($item_id);

            return view("item", [
               "item" => $item,
               "count" => $count,
                "drops" => $drop_rates,
                "max_runs" => $max_runs,
                "drop_rate" => $drop_rate_overall,
                "ago_drop" =>  TimeHelper::timeElapsedString($drop_rates["Dark"]["1"]->UPDATED_AT ?? "never"),
                "ago_price" => TimeHelper::timeElapsedString($item->PRICE_LAST_UPDATED),

               'runs' => $runs,

               'marketHistory'=>$marketHistory,
               'volumeHistory'=>$volumeHistory,

               'itemTiers'=>$itemTiersChart,
               'itemTypes'=>$itemTypesChart,
            ]);
        }

        public function get_group(int $group_id)
        {
            $items = DB::select("select ip.ITEM_ID, ip.NAME, ip.GROUP_NAME, ip.GROUP_ID, ip.PRICE_SELL, ip.PRICE_BUY, (
    select SUM(drp.DROPPED_COUNT)/SUM(GREATEST(1,drp.RUNS_COUNT)) from droprates_cache drp where drp.ITEM_ID=ip.ITEM_ID and drp.TYPE='All'
    ) DROP_RATE from item_prices ip where ip.GROUP_ID=? and ip.ITEM_ID not in (".implode(",",config("tracker.items.items_blacklist")).")
order by 2 ASC;", [intval($group_id)]);
//            $items = DB::table("item_prices")->where("GROUP_ID", $group_id)->orderBy("NAME", "ASC")->paginate(25);
            $name = DB::table("item_prices")->where("GROUP_ID", $group_id)->exists() ? DB::table("item_prices")->where("GROUP_ID", $group_id)->limit(1)->get()->get(0)->GROUP_NAME : "Unknown group";
            return view("group_items", [
                "group_name" => $name,
                "items" => $items,
            ]);
        }

        function get_all() {

            $items = Cache::remember("aft.items.all", now()->addMinute(), function () {
                return DB::select("select ip.ITEM_ID, ip.NAME, ip.GROUP_NAME, ip.GROUP_ID, ip.PRICE_SELL, ip.PRICE_BUY, (
    select SUM(drp.DROPPED_COUNT)/SUM(GREATEST(1,drp.RUNS_COUNT)) from droprates_cache drp where drp.ITEM_ID=ip.ITEM_ID and drp.TYPE='All'
    ) DROP_RATE from item_prices ip
    where GROUP_ID in (".implode(",",config("tracker.items.group_whitelist")).") and ip.ITEM_ID not in (".implode(",",config("tracker.items.items_blacklist")).") order by 7 DESC;");
            }) ;
            $cnt = DB::select("select count(*) as c from (select 1 from `detailed_loot` group by `RUN_ID`) a")[0]->c;
            return view("all_items", [
                "cnt" => $cnt,
               "items" => $items
            ]);
        }

        /**
         * @param int $itemID
         *
         * @return ItemTierChart
         */
        public function itemTypesChart(int $itemID):ItemTypeChart {
            $cc = new ItemTypeChart();

            $cc->displayAxes(false);
            $cc->displayLegend(false);

            $data = collect(Cache::remember('itemTypesChart' . $itemID, now()->addHour(), function () use ($itemID) {
                return DB::select('select runs.TYPE as TYPE, sum(dl.COUNT) as COUNT
from runs join detailed_loot dl on runs.ID = dl.RUN_ID
where dl.ITEM_ID = ? and runs.RUN_DATE > now() - interval 90 day
group by runs.TYPE;', [$itemID]);
            }));

            $cc->export(true, "Download");
            $cc->displayAxes(false);
            $cc->height(300);
            $cc->theme(ThemeController::getChartTheme());
            $cc->labels($data->pluck('TYPE'));
            $cc->dataset("Types", "pie", $data->pluck('COUNT'))
               ->options([
                   "radius" => ShipsController::PIE_RADIUS_SMALL,
                   "roseType" => "radius",
                   'label' => ['position' => 'outer', 'alignTo' => 'none', 'bleedMargin' => 5]]);

            return $cc;
        }


        /**
         * @param int $itemID
         *
         * @return ItemTierChart
         */
        public function itemTiersChart(int $itemID):ItemTierChart {
            $cc = new ItemTierChart();

            $cc->displayAxes(false);
            $cc->displayLegend(false);

            $data = collect(Cache::remember('itemTiersChart' . $itemID, now()->addHour(), function () use ($itemID) {
                return DB::select('select runs.TIER, sum(dl.COUNT) as COUNT
from runs join detailed_loot dl on runs.ID = dl.RUN_ID
where dl.ITEM_ID = ? and runs.RUN_DATE > now() - interval 90 day
group by runs.TIER;', [$itemID]);
            }));

            $cc->export(true, "Download");
            $cc->displayAxes(false);
            $cc->height(300);
            $cc->theme(ThemeController::getChartTheme());
            $cc->labels($data->pluck('TIER')->map(function($item) {
                return __('tiers.'.$item).' (T'.$item.')';
            }));
            $cc->dataset("Tiers", "pie", $data->pluck('COUNT'))
               ->options([
                   "radius" => ShipsController::PIE_RADIUS_SMALL,
                   "roseType" => "radius",
                   'label' => ['position' => 'outer', 'alignTo' => 'none', 'bleedMargin' => 5]]);

            return $cc;
        }




        private function itemMarketHistoryChart(int $itemID) {

            $history = collect($this->marketService->getItemHistory($itemID));
            $minDay = $history->min('date');

            $labels = $this->getLabels($minDay);

            $cc = new MarketESIChart();

            $cc->load(route('chart.item.market-history', ['id' => $itemID]));
            $cc->displayAxes(true);
            $cc->displayLegend(true);
            $cc->export(true, "Download");
            $cc->height("400");
            $cc->theme(ThemeController::getChartTheme());
            $cc->options([
                'tooltip' => [
                    'trigger' => "axis"
                ],
                'yAxis' =>  [
                    'axisLabel' => [
                        'formatter' => '{value} ISK'
                    ]
                ]
            ]);
            $cc->labels($labels);

            return $cc;
        }

        private function itemVolumeHistoryChart(int $itemID) {

            $history = collect($this->marketService->getItemHistory($itemID));
            $minDay = $history->min('date') ?? '2020-01-01';;
            $labels = $this->getLabels($minDay);

            $cc = new DropHistoryChart();

            $cc->load(route('chart.item.volume-history', ['id' => $itemID]));
            $cc->export(true, "Download");
            $cc->height("400");
            $cc->theme(ThemeController::getChartTheme());
            $cc->options([
                'tooltip' => [
                    'trigger' => "axis"
                ],
                'toolbox'=>[
                    'feature' => [
                        'dataView' => []
                    ]
                ],
                'yAxis' =>  [
                    [
                        'id' => 1,
                        'type' => 'value',
                        'show' => false,
                        'axisLabel' => [
                            'formatter' => '{value} ISK'
                        ]
                    ],
                    [
                        'id' => 2,
                        'type' => 'value',
                        'axisLabel' => [
                            'formatter' => '{value} vol.'
                        ]
                    ],
                ]
            ]);
            $cc->labels($labels);

            return $cc;
        }

        public function itemMarketHistory(Request  $request, int $id) {
            return Cache::remember('itemMarketHistory'.$id, now()->addMinute(), function () use ($id) {
                $history = collect($this->marketService->getItemHistory($id));

                $chart = new MarketESIChart();

                $history->sortBy('date');
                $average = $history->pluck('average');
                $highest = $history->pluck('highest');
                $lowest = $history->pluck('lowest');
                $volume = $history->pluck('volume');


                $chart->dataset("Sell price", "line", $highest)->options([
                    'showSymbol' => false,
                    'lineStyle' => [
                        'color' => ThemeController::getChartLineColor(ChartColor::GREEN)
                    ],
                    'itemStyle' => [
                        'color' => ThemeController::getChartLineColor(ChartColor::GREEN)
                    ]
                ]);
                $chart->dataset("Average sale", "line", $average)->options([
                    'showSymbol' => false,
                    'lineStyle' => [
                        'color' => ThemeController::getChartLineColor(ChartColor::GRAY)
                    ],
                    'itemStyle' => [
                        'color' => ThemeController::getChartLineColor(ChartColor::GRAY)
                    ]
                ]);
                $chart->dataset("Buy price", "line", $lowest)->options([
                    'showSymbol' => false,
                    'lineStyle' => [
                        'color' => ThemeController::getChartLineColor(ChartColor::RED)
                    ],
                    'itemStyle' => [
                        'color' => ThemeController::getChartLineColor(ChartColor::RED)
                    ]
                ]);
                $chart->dataset("Traded volume", "bar", $volume)->options([
                    'yAxisIndex' => 1,
                    'itemStyle' => [
                        'color' => ThemeController::getChartLineColor(ChartColor::BLUE)
                    ]
                ]);

                return $chart->api();
            });
        }

        public function itemDroppedVolume(int $id) {

            return Cache::remember('itemDroppedVolume'.$id, now()->addMinute(), function () use ($id) {

                $history = collect($this->marketService->getItemHistory($id));
                $minDay = $history->min('date') ?? '2020-01-01';
                $sql = "select SUM(dl.COUNT) as count, r.RUN_DATE as runDate, r.TYPE as type from detailed_loot dl left join runs r on r.ID = dl.RUN_ID where dl.ITEM_ID=? and r.RUN_DATE is not null and r.RUN_DATE >= ? GROUP BY r.RUN_DATE, r.TYPE order by 2 ASC";

                $data = collect(DB::select($sql, [$id, $minDay]));

                $dataReturn = collect([]);
                $types = DB::table("type")->get()->pluck("TYPE");



                $startDate = new Carbon($minDay);
                while (!$startDate->isToday()) {
                    $t = [];
                    foreach ($types as $type) {
                        $t[$type] = $data->where('runDate', $startDate->toDateString())->where('type',$type)->first()->count ?? 0;
                    }

                    $dataReturn->add($t);
                    $startDate->addDay();
                }


                $chart = new FrigateChart();

                $history->sortBy('date');
                $volume = $history->pluck('volume');

                foreach ($types as $type) {
                    $chart->dataset("$type drops", "bar", $dataReturn->pluck($type))->options([
                        'stack' => 1
                    ]);
                }

                return $chart->api();
            });
        }

        /**
         * @param $minDay
         *
         * @return \Illuminate\Support\Collection
         */
        private function getLabels($minDay) : \Illuminate\Support\Collection {
            $startDate = new Carbon($minDay);
            $labels = collect([]);

            while (!$startDate->isToday()) {
                $startDate = $startDate->addDay();
                $labels->add($startDate->toDateString());
            }

            return $labels;
        }


    }
