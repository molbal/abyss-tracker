<?php

    namespace App\Console\Commands;

    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class RecalculateDroprates extends Command {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'abyss:recalc';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Recalculates drop rates';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct() {
            parent::__construct();
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle() {
            try {
                ini_set('max_execution_time', 0);
                set_time_limit(0);

                $items = DB::table("item_prices")
                           ->select("ITEM_ID", "NAME")
                           ->whereRaw("GROUP_ID in (1992,1993,105,255,2019,1964,1088,1990,257,1995,1977,1979,1996,489,107,106,487)")
                           ->get();

                $types = ["Electrical", "Dark", "Exotic", "Firestorm", "Gamma"];
                Log::info("Starting item drop rate calculation.");

                Cache::put("recalc-notice", "We are currently updating drop rates.", 100);
                Cache::put("recalc-current", 0, 100);
                Cache::put("recalc-all", $items->count(), 100);
                $k = 0;
                foreach ($items as $item) {
                    $item_id = $item->ITEM_ID;
                    $type_drp = 0;
                    $type_ran = 0;
                    Cache::increment("recalc-current");

                    for ($tier = 1; $tier <= 5; $tier++) {
                        //Log::info("  - Starting tier $tier");
                        $tier_ran = 0;
                        $tier_drp = 0;
                        foreach ($types as $type) {
                            $stats = DB::table("v_drop_rates")
                                       ->where("TIER", $tier)
                                       ->where("TYPE", $type)
                                       ->where("ITEM_ID", $item_id)
                                       ->get()
                                       ->get(0);

                            $tier_ran += $stats->MAX_RUNS ?? 0;
                            $tier_drp += $stats->DROP_RATE ?? 0;

                            $removals = DB::table("delete_cleanup")
                                          ->where("TIER", $tier)
                                          ->where("TYPE", $type)
                                          ->where("ITEM_ID", $item_id)
                                          ->count("DELETES_SUM");

                            $tier_drp -= $removals;
                            try {
                                DB::beginTransaction();
                                DB::table("droprates_cache")
                                  ->where("TIER", $tier)
                                  ->where("TYPE", $type)
                                  ->where("ITEM_ID", $item_id)
                                  ->delete();
                                DB::table("droprates_cache")
                                  ->insert(["ITEM_ID" => $item_id, "TIER" => $tier, "TYPE" => $type, 'DROPPED_COUNT' => $stats->DROP_RATE, 'RUNS_COUNT' => $stats->MAX_RUNS]);
                                DB::commit();
                            } catch (\Exception $e) {
                                Log::warning("Error while processing $item_id / $type / $tier " . $e->getMessage() . " " . $e->getFile() . " " . $e->getLine());
                            }
                        }

                        try {
                            DB::beginTransaction();
                            DB::table("droprates_cache")
                              ->where("TIER", $tier)
                              ->where("TYPE", "All")
                              ->where("ITEM_ID", $item_id)
                              ->delete();
                            DB::table("droprates_cache")
                              ->insert(["ITEM_ID" => $item_id, "TIER" => $tier, "TYPE" => "All", 'DROPPED_COUNT' => $tier_drp, 'RUNS_COUNT' => $tier_ran]);
                            DB::commit();
                        } catch (\Exception $e) {
                            Log::warning("Error while processing $item_id / All / $tier " . $e->getMessage() . " " . $e->getFile() . " " . $e->getLine());
                        }
                    }
                }
                DB::table("delete_cleanup")->delete();
                Log::info("Finished recalc.");
                Cache::forget("recalc-notice");
                Cache::forget("recalc-current");
                Cache::forget("recalc-all");
                Log::info("Finished processing " . $items->count() . " items");
            } catch (\Exception $e) {
                Log::error($e);
            } finally {
                Cache::forget("notice");
            }

        }
    }
