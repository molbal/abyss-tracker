<?php


    namespace App\Http\Controllers;


    use App\Http\Controllers\Loot\LootCacheController;
    use DateTime;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ItemController extends Controller {

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

        private function time_elapsed_string($datetime, $full = false) {
            if ($datetime == "never") return "never";
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ago' : 'just now';
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


            return view("item", [
               "item" => $item,
               "count" => $count,
                "drops" => $drop_rates,
                "max_runs" => $max_runs,
                "drop_rate" => $drop_rate_overall,
                "ago_drop" => $this->time_elapsed_string($drop_rates["Dark"]["1"]->UPDATED_AT ?? "never"),
                "ago_price" => $this->time_elapsed_string($item->PRICE_LAST_UPDATED)
            ]);
        }

        public function get_group(int $group_id)
        {
            $items = DB::select("select ip.ITEM_ID, ip.NAME, ip.GROUP_NAME, ip.GROUP_ID, ip.PRICE_SELL, ip.PRICE_BUY, (
    select SUM(drp.DROPPED_COUNT)/SUM(GREATEST(1,drp.RUNS_COUNT)) from droprates_cache drp where drp.ITEM_ID=ip.ITEM_ID and drp.TYPE='All'
    ) DROP_RATE from item_prices ip where ip.GROUP_ID=?
order by 2 ASC;", [intval($group_id)]);
//            $items = DB::table("item_prices")->where("GROUP_ID", $group_id)->orderBy("NAME", "ASC")->paginate(25);
            $name = DB::table("item_prices")->where("GROUP_ID", $group_id)->exists() ? DB::table("item_prices")->where("GROUP_ID", $group_id)->limit(1)->get()->get(0)->GROUP_NAME : "Unknown group";
            return view("group_items", [
                "group_name" => $name,
                "items" => $items,
            ]);
        }

        function get_all() {
            $items = DB::select("select ip.ITEM_ID, ip.NAME, ip.GROUP_NAME, ip.GROUP_ID, ip.PRICE_SELL, ip.PRICE_BUY, (
    select SUM(drp.DROPPED_COUNT)/SUM(GREATEST(1,drp.RUNS_COUNT)) from droprates_cache drp where drp.ITEM_ID=ip.ITEM_ID and drp.TYPE='All'
    ) DROP_RATE from item_prices ip
order by 7 DESC;");
            $cnt = DB::select("select count(*) as c from (select 1 from `detailed_loot` group by `RUN_ID`) a")[0]->c;
            return view("all_items", [
                "cnt" => $cnt,
               "items" => $items
            ]);
        }

        function search_items(Request $request) {
            $q = $request->get("q");
            $items = DB::table("item_prices")->where("NAME", "LIKE", "%".$q."%")->get();

            $q = [
                "results" => [],
                "pagination" => false
            ];
            foreach ($items as $item) {
                $q["results"][] = [
                  "id" => $item->ITEM_ID,
                  "text" => sprintf("%s (%s)", $item->NAME, $item->GROUP_NAME),
                    "html" => ""
                ];
            }

            return json_encode($q);
        }
    }
