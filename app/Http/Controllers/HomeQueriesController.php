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
    }
