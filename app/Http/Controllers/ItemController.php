<?php


    namespace App\Http\Controllers;


    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class ItemController extends Controller {

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

            $drop_rates = Cache::remember("dropsrate-".$item_id, 90, function() use ($item_id) {
              return DB::table("v_drop_rates")
                  ->where("ITEM_ID", $item_id)
                  ->orderBy("TYPE", "ASC")
                  ->orderBy("TIER", "ASC")
                  ->get();
            });

            foreach ($drop_rates as $dropRate) {
                $max_runs += $dropRate->MAX_RUNS;
                $drop_rate_overall += $dropRate->DROP_RATE;
            }


            return view("item", [
               "item" => $item,
               "count" => $count,
                "drops" => $drop_rates,
                "max_runs" => $max_runs,
                "drop_rate" => $drop_rate_overall
            ]);
        }

        public function get_group(int $group_id)
        {
            return view('error', [
                "error" => "Sorry, item groups are not yet finished."
            ]);
        }

        function get_all() {
            $items = DB::table("item_prices")->orderBy("NAME", "ASC")->paginate(25);
            $cnt = DB::table("detailed_loot")->groupBy("RUN_ID")->count();
            $items_select = DB::table("item_prices")->orderBy("NAME", "ASC")->select(["ITEM_ID", "NAME", "GROUP_NAME"])->get();
            return view("all_items", [
                "cnt" => $cnt,
               "items" => $items,
                "items_select" => $items_select
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
