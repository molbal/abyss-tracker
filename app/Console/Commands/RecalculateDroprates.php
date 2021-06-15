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
                            ->whereIn("GROUP_ID", config("tracker.items.group_whitelist"))
                            ->whereNotIn("ITEM_ID", config('tracker.items.items_blacklist'))
                            ->get();

                $types = ["Electrical", "Dark", "Exotic", "Firestorm", "Gamma"];
                Log::channel("droprate")->info("Starting item drop rate calculation.");

                Cache::put("recalc-notice", "Adjusting drop rates during downtime.. ", now()->addMinutes(20));
                Cache::put("recalc-current", 0, now()->addMinutes(20));
                Cache::put("recalc-all", $items->count(), now()->addMinutes(20));
                $k = 0;
                foreach ($items as $item) {
                    $item_id = $item->ITEM_ID;
                    $type_drp = 0;
                    $type_ran = 0;
                    Cache::increment("recalc-current");

                    Log::channel("droprate")->info("Doing item ". $item->NAME);
                    for ($tier = 0; $tier <= 6; $tier++) {
                        $tier = strval($tier);
                        //Log::channel("droprate")->info("  - Starting tier $tier");
                        $tier_ran = 0;
                        $tier_drp = 0;
                        foreach ($types as $type) {
                            if (DB::table("v_drop_rates")
                                  ->where("TIER", $tier)
                                  ->where("TYPE", $type)
                                  ->where("ITEM_ID", $item_id)->exists()) {

                                $stats = DB::table("v_drop_rates")
                                           ->where("TIER", $tier)
                                           ->where("TYPE", $type)
                                           ->where("ITEM_ID", $item_id)
                                           ->first();

                                $tier_ran += $stats->MAX_RUNS ?? 0;
                                $tier_drp += $stats->DROP_RATE ?? 0;
                            }
                            else {
                                Log::channel("droprate")->warning("Could not get drop information for  $item_id / $type / $tier");
                            }

                            try {
                            $removals = DB::table("delete_cleanup")
                                          ->where("TIER", $tier)
                                          ->where("TYPE", $type)
                                          ->where("ITEM_ID", $item_id)
                                          ->count("DELETES_SUM");
                            }
                            catch (\Exception $e) {
                                Log::channel("droprate")->warning("Error while getting delete list for  $item_id / $type / $tier " . $e->getMessage() . " " . $e->getFile() . " " . $e->getLine());
                                $removals = 0;
                            }
                            $tier_drp -= $removals;
                            try {
                                DB::beginTransaction();
                                DB::table("droprates_cache")
                                  ->where("TIER", $tier)
                                  ->where("TYPE", $type)
                                  ->where("ITEM_ID", $item_id)
                                  ->delete();
                                DB::table("droprates_cache")
                                  ->insert(["ITEM_ID" => $item_id, "TIER" => $tier, "TYPE" => $type, 'DROPPED_COUNT' => $stats->DROP_RATE, 'RUNS_COUNT' => $stats->MAX_RUNS, 'UPDATED_AT' => now()]);
                                DB::commit();
                                Log::channel("droprate")->info(sprintf("Did item  %s TYPE=%s DROPPED_COUNT=%d RUNS_COUNT=%d", $item->NAME,$type, $tier_drp, $tier_ran));
                            } catch (\Exception $e) {
                                Log::channel("droprate")->warning("Error while processing $item_id / $type / $tier " . $e->getMessage() . " " . $e->getFile() . " " . $e->getLine());
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
                            Log::channel("droprate")->info(sprintf("Did item ALL %s DROPPED_COUNT=%d RUNS_COUNT=%d", $item->NAME, $tier_drp, $tier_ran));
                        } catch (\Exception $e) {
                            Log::channel("droprate")->warning("Error while processing $item_id / All / $tier " . $e->getMessage() . " " . $e->getFile() . " " . $e->getLine());
                        }
                    }
                }
                DB::table("delete_cleanup")->delete();
                Log::channel("droprate")->info("Finished recalc.");
                Cache::forget("recalc-notice");
                Cache::forget("recalc-current");
                Cache::forget("recalc-all");
                Log::channel("droprate")->info("Finished processing " . $items->count() . " items");
            } catch (\Exception $e) {
                Log::channel("droprate")->error($e);
            } finally {
                Cache::forget("notice");
            }

        }
    }
