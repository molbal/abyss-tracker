<?php


	namespace App\Http\Controllers\EFT;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\ISingleItemEstimator;
//    use DebugBar\DebugBar;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ItemPriceCalculator {


        /** @var ResourceLookupService */
        protected $resourceLookup;

        /**
         * ItemPriceCalculator constructor.
         *
         * @param ResourceLookupService $resourceLookup
         */
        public function __construct(ResourceLookupService $resourceLookup) {
            $this->resourceLookup = $resourceLookup;
        }


        /**
         * @param int $typeId
         *
         * @return ItemObject|null
         */
        public function getFromTypeId(int $typeId): ?ItemObject {
            if ($typeId == 0) return null;
            try {
                $dto = Cache::remember("app.ipc.".$typeId, now()->addMinute(), function() use ($typeId) {
                   return  $this->appraise($typeId);
                });
            }
            catch (RemoteAppraisalToolException $exc) {
                Log::channel("itempricecalculator")->warning("Could not appraise typeId $typeId ".$exc->getMessage()."\n".$exc->getTraceAsString());
                $dto = null;
            }

            if ($dto == null) Log::channel("itempricecalculator")->warning("Could not appraise typeId $typeId");
            return $dto;
        }



        /**
         * @param string $name
         *
         * @return int
         * @throws \Exception
         */
        public function getFromItemName(string $name): ?ItemObject {
            $typeId = $this->resourceLookup->itemNameToId($name);
            if (!$typeId) {
                return null;
            }
            return $this->getFromTypeId($typeId);
        }

        /**
         * Updates item prices table
         * @param ItemObject $itemObj
         */
        private function updateItemPricesTable(ItemObject $itemObj):void {
            try {

                DB::beginTransaction();
                if (DB::table("item_prices")->where("ITEM_ID", $itemObj->getTypeId())->exists()) {
                    DB::table("item_prices")->where("ITEM_ID", $itemObj->getTypeId())->update([
                        "NAME" => $itemObj->getName(),
                        "PRICE_BUY" => $itemObj->getBuyPrice(),
                        "PRICE_SELL" => $itemObj->getSellPrice()
                    ]);
                }
                else{
                    DB::table("item_prices")->insert([
                        "ITEM_ID" => $itemObj->getTypeId(),
                        "NAME" => $itemObj->getName(),
                        "PRICE_BUY" => $itemObj->getBuyPrice(),
                        "PRICE_SELL" => $itemObj->getSellPrice(),
                        "DESCRIPTION" => "",
                        "GROUP_ID" => 0,
                        "GROUP_NAME" => "TBD"
                    ]);
                }
                DB::commit();
            }
            catch (\Exception $exc) {
                DB::rollBack();
                Log::channel("itempricecalculator")->warning("Transaction rolled back - Could not persist ".$itemObj->serialize().": ".$exc->getMessage()."\n".$exc->getTraceAsString());
            }
        }

        private function appraiseBulk(Collection $listOfIds): Collection {

        }

        /**
         * @param int $typeId
         *
         * @return ItemObject
         */
        private function appraise(int $typeId): ?ItemObject {
            $estimators = $this->getSingleItemEstimators();
            foreach ($estimators as $i => $estimator) {

                /** @var ISingleItemEstimator $estimatorImpl */
                $estimatorImpl = resolve($estimator, ["typeId" => $typeId]);

                try {
                    $itemObj = $estimatorImpl->getPrice();

                    if ($itemObj != null) {

                        if ($itemObj->getAveragePrice() == 0 && stripos($itemObj->getName(), "blueprint") === false) {
                            continue;
                        }

                        if ($i>0) {
                            $this->updateItemPricesTable($itemObj);
                        }

                        Cache::put("aft.singleitemestimator." . $typeId, now()->addMinutes(30), $itemObj->serialize());
                        return $itemObj;
                    }
                }
                catch (RemoteAppraisalToolException $retex) {
                    Log::channel("itempricecalculator")->warning("RemoteAppraisalToolException: Error while calculating typeId ".$typeId.": ".$retex->getMessage()."\n".$retex->getTraceAsString());
                }
                catch (\Exception $retex) {
                    Log::channel("itempricecalculator")->error("Unexpected exception: Error while calculating typeId ".$typeId.": ".$retex->getMessage()."\n".$retex->getTraceAsString());
                }
            }

            return null;
        }

        /**
         * Returns the names of ISingleItemEstimator implementation classes, in order
         * @return array
         */
        private function getSingleItemEstimators() {
            return config('tracker.market.estimators.single-item');
        }

        protected function getBulkItemEstimators() {
            return config('tracker.market.estimators.bulk');
        }

	}
