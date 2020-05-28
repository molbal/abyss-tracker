<?php


	namespace App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use App\Http\Controllers\EFT\Tags\ISingleItemEstimator;
    use GuzzleHttp\Client;
    use Illuminate\Support\Facades\DB;

    class ItemPriceTableSingleItemEstimator implements ISingleItemEstimator {

        private $typeId;

        /**
         * EveWorkbenchSingleItemEstimator constructor.
         *
         * @param $typeId
         */
        public function __construct($typeId) {
            $this->typeId = $typeId;
        }

        /**
         * @return ItemObject
         * @throws RemoteAppraisalToolException
         */
        public function getPrice() : ItemObject {
            if (!DB::table("item_prices")
                  ->where("ITEM_ID", $this->typeId)
                  ->where("PRICE_LAST_UPDATED", ">", now()->subDay())->exists()) {
                return null;
            }

            $obj = DB::table("item_prices")
                     ->where("ITEM_ID", $this->typeId)
                     ->where("PRICE_LAST_UPDATED", ">", now()->subDay())
                     ->first();

            $itemObj = new ItemObject();
            $itemObj->setTypeId($this->typeId)
                    ->setName($obj->NAME)
                    ->setBuyPrice($obj->PRICE_BUY)
                    ->setSellPrice($obj->PRICE_SELL);

            return $itemObj ?? null;
        }
	}
