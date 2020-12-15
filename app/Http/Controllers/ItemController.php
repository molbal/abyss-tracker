<?php


    namespace App\Http\Controllers;


    use App\Charts\CruiserChart;
    use App\Charts\FrigateChart;
    use App\Charts\MarketESIChart;
    use App\Connector\EveAPI\Market\MarketService;
    use App\Http\Controllers\Cache\DBCacheController;
    use App\Http\Controllers\Loot\LootCacheController;
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

            return view("item", [
               "item" => $item,
               "count" => $count,
                "drops" => $drop_rates,
                "max_runs" => $max_runs,
                "drop_rate" => $drop_rate_overall,
                "ago_drop" =>  TimeHelper::timeElapsedString($drop_rates["Dark"]["1"]->UPDATED_AT ?? "never"),
                "ago_price" => TimeHelper::timeElapsedString($item->PRICE_LAST_UPDATED),

               'marketHistory'=>$marketHistory,
               'volumeHistory'=>$volumeHistory,
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


        private function itemMarketHistoryChart(int $itemID) {

            $history = collect($this->marketService->getItemHistory($itemID));
            $minDay = $history->min('date');
//            $a = collect(DB::select('select SUM(dl.COUNT) as DAY_COUNT, r.RUN_DATE as CNT from detailed_loot dl left join runs r on r.ID = dl.RUN_ID where dl.ITEM_ID=48121 and r.RUN_DATE is not null and r.RUN_DATE >= ? GROUP BY r.RUN_DATE order by 2 ASC', [
//                $minDay
//            ]));

            $startDate = new Carbon($minDay);
            $labels = collect([]);

            while (!$startDate->isToday()) {
                $startDate = $startDate->addDay();
                $labels->add($startDate->toDateString());
            }

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
            $startDate = new Carbon($minDay);
            $labels = collect([]);

            while (!$startDate->isToday()) {
                $startDate = $startDate->addDay();
                $labels->add($startDate->toDateString());
            }

            $cc = new FrigateChart();

            $cc->load(route('chart.item.volume-history', ['id' => $itemID]));
            $cc->export(true, "Download");
            $cc->height("400");
            $cc->theme(ThemeController::getChartTheme());
            $cc->options([
                'tooltip' => [
                    'trigger' => "axis"
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
            $history = collect($this->marketService->getItemHistory($id));

            $chart = new MarketESIChart();

            $history->sortBy('date');
            $average = $history->pluck('average');
            $highest = $history->pluck('highest');
            $lowest = $history->pluck('lowest');
            $volume = $history->pluck('volume');


            $chart->dataset("Average sale", "line", $average);
            $chart->dataset("Highest sale", "line", $highest);
            $chart->dataset("Lowest sale", "line", $lowest);
            $chart->dataset("Sale volume", "bar", $volume)->options([
                'yAxisIndex' => 1
            ]);

            return $chart->api();
        }

        public function itemDroppedVolume(int $id) {


            $history = collect($this->marketService->getItemHistory($id));
            $minDay = $history->min('date') ?? '2020-01-01';
            $sql = "select SUM(dl.COUNT) as count, r.RUN_DATE as runDate, r.TYPE as type from detailed_loot dl left join runs r on r.ID = dl.RUN_ID where dl.ITEM_ID=48121 and r.RUN_DATE is not null and r.RUN_DATE >= ? GROUP BY r.RUN_DATE, r.TYPE order by 2 ASC";

            $data = collect(DB::select($sql, [$minDay]));

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
        }



    }
