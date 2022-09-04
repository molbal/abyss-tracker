<?php

	namespace App\Runs;

	use App\Http\Controllers\HelperController;
    use App\Http\Controllers\Loot\LootValueEstimator;
    use App\Http\Requests\NewRunRequest;
    use App\Models\Fit;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class CreateRunHelper {

        public static function storeFromTelemetry(array $payload): int {

            $ship_payload = [];
            foreach ($payload['ships'] as $ship) {
                if ($ship['characterName'] == $payload['CharacterName']) {
                    $ship_payload = $ship;
                    break;
                }
            }

            if ($ship_payload['foreignID'] && Fit::where('ID', $ship_payload['foreignID'])->doesntExist()) {
                $ship_payload['foreignID'] = null;
            }

            $id = DB::table("runs")->insertGetId([
                'CHAR_ID'           => $payload['CharacterID'],
                'PUBLIC'            => $payload['Privacy'] == 'PUBLIC' ? 1 : 0,
                'TIER'              => HelperController::clamp($payload['Tier'],0,6),
                'TYPE'              => $payload['Weather'],
                'LOOT_ISK'          => intval(floatval($payload['LootGainedPrice'])+floatval($payload['LootLostPrice'])),
                'SURVIVED'          => $payload['Success'] ? 1 : 0,
                'RUN_DATE'          => date('Y-m-d', $payload['RunStartTime']),
                'CREATED_AT'        => date('Y-m-d H:i:s', $payload['RunStartTime']),
                'SHIP_ID'           => $ship_payload['shipTypeID'] ?? null,
                'DEATH_REASON'      => null,
                'PVP_CONDUIT_USED'  => null,
                'PVP_CONDUIT_SPAWN' => null,
                'FILAMENT_PRICE'    => null,
                'LOOT_TYPE'         => $payload['CansSpawned'] == $payload['CansLooted'] ? 'BIOADAPTIVE_PLUS_ALL_CANS': null,
                'KILLMAIL'          => null,
                'RUNTIME_SECONDS'   => $payload['RunDurationSeconds'],
                'IS_BONUS'          => null,
                'FIT_ID'            => $ship_payload['foreignID'],
            ]);

            $gainedItems = [];
            foreach ($payload['LootGained'] as $telemetryItem) {
                $gainedItems[] = [
                    "RUN_ID"  => $id,
                    "ITEM_ID" => $telemetryItem['TypeID'],
                    "COUNT"   => $telemetryItem['Count'],
                ];
            }
            DB::table("detailed_loot")->insert($gainedItems);

            $lostItems = [];
            foreach ($payload['LootLost'] as $telemetryItem) {
                $lostItems[] = [
                    "RUN_ID"  => $id,
                    "ITEM_ID" => $telemetryItem['TypeID'],
                    "COUNT"   => $telemetryItem['Count'],
                ];
            }
            DB::table("lost_items")->insert($lostItems);

            return $id;
        }

        /**
         * Handles the DB persisting of the new run
         *
         * @param Request $request
         * @param array   $lootDifference
         * @return int
         */
        public static function storeFromUI(NewRunRequest $request, array $lootDifference): int {

            if ($request->filled("RUN_LENGTH_M") || $request->filled("RUN_LENGTH_S")) {
                $runtime_m = $request->filled("RUN_LENGTH_M") ? $request->get("RUN_LENGTH_M") : 20;
                $runtime_s = $request->filled("RUN_LENGTH_S") ? $request->get("RUN_LENGTH_S") : 0;
                $runtime = ($runtime_m*60)+$runtime_s;
            }
            else {
                $runtime = null;
            }
            $id = DB::table("runs")->insertGetId([
                'CHAR_ID'           => session()->get("login_id"),
                'PUBLIC'            => $request->get("PUBLIC"),
                'TIER'              => strval($request->isBonusRoom() ? "5" : HelperController::clamp($request->get('TIER'),0,6)),
                'TYPE'              => $request->get("TYPE"),
                'LOOT_ISK'          => $request->get("SURVIVED") ? $lootDifference['totalPrice'] : 0,
                'SURVIVED'          => $request->get("SURVIVED"),
                'RUN_DATE'          => $request->get("RUN_DATE"),
                'SHIP_ID'           => $request->getShipId(),
                'DEATH_REASON'      => $request->get('DEATH_REASON'),
                'PVP_CONDUIT_USED'  => null,
                'PVP_CONDUIT_SPAWN' => null,
                'FILAMENT_PRICE'    => null,
                'LOOT_TYPE'         => $request->get('LOOT_TYPE'),
                'KILLMAIL'          => $request->get('KILLMAIL'),
                'RUNTIME_SECONDS'   => $runtime,
                'IS_BONUS'          => $request->isBonusRoom(true),
                'FIT_ID'            => $request->getFitId()
            ]);

            foreach ($lootDifference['gainedItems'] as $item) {
                LootValueEstimator::setItemPrice($item);
                DB::table("detailed_loot")->insert([
                    "RUN_ID"  => $id,
                    "ITEM_ID" => $item->getItemId(),
                    "COUNT"   => $item->getCount()
                ]);
            }

            foreach ($lootDifference['lostItems'] as $item) {
                LootValueEstimator::setItemPrice($item);
                DB::table("lost_items")->insert([
                    "RUN_ID"  => $id,
                    "ITEM_ID" => $item->getItemId(),
                    "COUNT"   => $item->getCount()
                ]);
            }
            return $id;
        }
	}
