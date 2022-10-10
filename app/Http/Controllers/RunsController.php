<?php


    namespace App\Http\Controllers;


    use App\Http\Controllers\Loot\LootCacheController;
    use App\Http\Controllers\Loot\LootValueEstimator;
    use App\Http\Requests\NewRunRequest;
    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;

    class RunsController {
        /** @var LootCacheController */
        private $lootCacheController;

        /**
         * RunsController constructor.
         *
         * @param LootCacheController $lootCacheController
         */
        public function __construct(LootCacheController $lootCacheController) { $this->lootCacheController = $lootCacheController; }


        /**
         * Gets the previous run of the logged in char
         *
         * @return mixed
         */
        public function getPreviousRun() {
            $prev = DB::table("runs")
                ->where("CHAR_ID", session()->get("login_id"))
                ->orderBy("CREATED_AT", "DESC")
                ->orderBy("RUN_DATE", "DESC")
                ->limit(1)
                ->first();
            return $prev;
        }

        /**
         * @param Collection $loot
         * @param            $all_data
         */
        public function extendDropListWithRates(Collection $loot, $all_data): void {
            foreach ($loot as $lt) {
                $loot_stats = $this->lootCacheController->getItemStatsForTierType($lt->ITEM_ID, $all_data->TYPE, $all_data->TIER);
                try {
                    $lt->DROP_PERCENT = $loot_stats[$all_data->TYPE][$all_data->TIER]->DROPPED_COUNT / max(1, $loot_stats[$all_data->TYPE][$all_data->TIER]->RUNS_COUNT);
                    $lt->TOOLTIP = sprintf("%d / %d runs", $loot_stats[$all_data->TYPE][$all_data->TIER]->DROPPED_COUNT, $loot_stats[$all_data->TYPE][$all_data->TIER]->RUNS_COUNT);
                }
                catch (Exception $e) {
                    $lt->DROP_PERCENT = 0;
                    $lt->TOOLTIP = "Drop rate is not yet calculated.";
                }
            }
        }

    }
