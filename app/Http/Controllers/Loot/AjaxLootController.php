<?php


    namespace App\Http\Controllers\Loot;


    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class AjaxLootController extends Controller {

        public function getSum(Request $request): string {
            $lootEstimator = new LootValueEstimator($request->get("LOOT_DETAILED") ?? "");

            $int = $lootEstimator->getTotalPrice();
            return json_encode([
                'number' => $int,
                'formatted' => number_format($int, 0, ",", " ")
            ]);
        }
    }
