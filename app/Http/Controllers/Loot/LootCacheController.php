<?php


    namespace App\Http\Controllers\Loot;


    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;

    class LootCacheController extends Controller {

        /**
         * @param int $item_id
         * @return array
         */
        public function getAllItemStats(int $item_id) {
            $stats = DB::table("droprates_cache")
                ->where("ITEM_ID", $item_id)
                ->orderBy("TYPE", "ASC")
                ->orderBy("TIER", "ASC")
                ->get();

            $all = DB::table("droprates_cache")
                ->where("ITEM_ID", $item_id)
                ->where("TYPE", "ALL")
                ->selectRaw("SUM(DROPPED_COUNT) AS DROPPED_COUNT_SUM")
                ->selectRaw("SUM(RUNS_COUNT) AS RUNS_COUNT_SUM")
                ->get()->get(0);

            $ret = [];
            foreach ($stats as $stat) {
                if (!isset($stat->TYPE)) {
                    $ret[$stat->TYPE] = [];
                }
                $ret[$stat->TYPE][$stat->TIER] = $stat;
            }
            $ret["sum"] = $all;
            return $ret;
        }

        public function getItemStatsForTierType(int $item_id, string $type, int $tier) {
            $stats = DB::table("droprates_cache")
                ->where("ITEM_ID", $item_id)
                ->where("TYPE", $type)
                ->where("TIER", $tier)
                ->get();

            $all = DB::table("droprates_cache")
                ->where("ITEM_ID", $item_id)
                ->where("TYPE", "ALL")
                ->selectRaw("SUM(DROPPED_COUNT) AS DROPPED_COUNT_SUM")
                ->selectRaw("SUM(RUNS_COUNT) AS RUNS_COUNT_SUM")
                ->get()->get(0);

            $ret = [];
            foreach ($stats as $stat) {
                if (!isset($stat->TYPE)) {
                    $ret[$stat->TYPE] = [];
                }
                $ret[$stat->TYPE][$stat->TIER] = $stat;
            }
            $ret["sum"] = $all;
            return $ret;

        }
    }
