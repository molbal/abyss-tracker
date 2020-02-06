<?php


    namespace App\Http\Controllers;


    use Illuminate\Support\Facades\DB;

    class HomeQueriesController
    {


        /**
         * @return \Illuminate\Support\Collection
         */
        public function getLastRuns() : \Illuminate\Support\Collection
        {
            return DB::table("v_runall")->orderBy("CREATED_AT", "DESC")->limit(20)->get();
        }

        /**
         * @return array
         */
        public function getCommonDrops() : array
        {
            $drops = DB::select("SELECT          ip.ITEM_ID,
                MAX(ip.PRICE_BUY) as PRICE_BUY,
                MAX(ip.PRICE_SELL) as PRICE_SELL,
                MAX(ip.NAME) as NAME,
                MAX(ip.GROUP_NAME) as GROUP_NAME,
  (SELECT SUM(drci.DROPPED_COUNT)/SUM(drci.RUNS_COUNT)
   FROM droprates_cache drci
   WHERE drci.ITEM_ID=ip.ITEM_ID
     AND drci.TYPE='All') DROP_CHANCE
FROM item_prices ip
LEFT JOIN droprates_cache drc ON ip.ITEM_ID=drc.ITEM_ID
WHERE drc.TYPE='ALL'
GROUP BY ip.ITEM_ID
ORDER BY 6 DESC LIMIT 10;
");

            return $drops;
        }


        /**
         * @return array
         */
        public function getPersonalStats(): array {
            $my_runs = DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->count();
            $my_avg_loot = DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->avg('LOOT_ISK');
            $my_sum_loot = DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->sum('LOOT_ISK');
            $my_survival_ratio = (DB::table("runs")->where("CHAR_ID", session()->get("login_id"))->where("SURVIVED", '=', true)->count()) / max(1, $my_runs) * 100;
            $id = session()->get("login_id");
            $data = DB::table("runs")
                ->where("CHAR_ID", '=', $id)
                ->whereRaw("RUN_DATE > NOW() - INTERVAL 30 DAY")
                ->select("RUN_DATE")
                ->groupBy("RUN_DATE")
                ->get();
            return [$my_runs, $my_avg_loot, $my_sum_loot, $my_survival_ratio, $data];
        }
    }
