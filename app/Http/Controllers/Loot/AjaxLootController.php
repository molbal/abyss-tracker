<?php


    namespace App\Http\Controllers\Loot;


    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class AjaxLootController extends Controller {

        public function getSum(Request $request): string {
            try {
                $loot_difference = LootValueEstimator::difference($request->get("LOOT_DETAILED"),$request->get("LOOT_DETAILED_BEFORE"));
            } catch (\Error $e ) {
                Log::warning("Failed to calculate difference ".$e->getMessage());
            }

            if ( isset($loot_difference) && isset($loot_difference['totalPrice']) ) {
                $total = $loot_difference['totalPrice'];
            } else {
                $total = 0;
            }


            return json_encode([
                'number' => $total,
                'formatted' => number_format($total, 0, ",", " ")
            ]);
        }
    }
