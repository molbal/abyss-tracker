<?php


	namespace App\Connector\EveAPI\Market;


	use App\Connector\EveAPI\EveAPICore;
    use Illuminate\Support\Facades\Cache;

    class MarketService extends EveAPICore {


        /**
         * Gets EVE ItemID history
         * @param int $id ItemID
         *
         * @return mixed
         */
        public function getItemHistory(int $id) {
            return Cache::remember("ast.markethistory.$id", now()->addHours(12), function() use ($id) {
                $resp = $this->simpleGet(null, "markets/10000002/history/?datasource=tranquility&type_id=$id", true);
                if (!$resp) {
                    $this->logError("markets/10000002/history/?datasource=tranquility&type_id=$id", "getItemHistory failed for [$id].");
                }
                return $resp;
            });
        }
	}
