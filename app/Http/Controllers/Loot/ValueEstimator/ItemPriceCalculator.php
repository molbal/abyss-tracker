<?php


	namespace App\Http\Controllers\EFT;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use App\Http\Controllers\EFT\Tags\ISingleItemEstimator;
    use GuzzleHttp\Client;
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


        public function getFromTypeId(int $typeId): ItemObject {
            try {
                $dto = $this->appraise($typeId);
            }
            catch (RemoteAppraisalToolException $exc) {
                $dto = null;
            }

            return $dto;
        }



        /**
         * @param string $name
         *
         * @return int
         * @throws \Exception
         */
        public function getFromItemName(string $name): ItemObject {
            $typeId = $this->resourceLookup->itemNameToId($name);
            return $this->getFromTypeId($typeId);
        }

        private function updateItemPricesTable(ItemObject $itemObj):void {
            try {

                if (DB::table("item_prices")->where("ITEM_ID", $itemObj->getTypeId())->exists()) {
                    DB::table("item_prices")->where("ITEM_ID", $itemObj->getTypeId())->update([
                        "NAME"
                    ]);
                }
                else{

                }
            }
            catch (\Exception $exc) {
                Log::channel("itempricecalculator")->warning("Could not persist ".$itemObj->serialize().": ".$exc->getMessage()."\n".$exc->getTraceAsString());
            }
        }

        /**
         * @param int $typeId
         *
         * @return ItemObject
         */
        private function appraise(int $typeId): ItemObject {
            $estimators = $this->getSingleItemEstimators();
            foreach ($estimators as $estimator) {

                /** @var ISingleItemEstimator $estimatorImpl */
                $estimatorImpl = resolve($estimator, ["typeId" => $typeId]);

                try {
                    $itemObj = $estimatorImpl->getPrice();
                    if ($itemObj != null) {
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
            return [
              'App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl\ItemPriceTableSingleItemEstimator',
              'App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl\FuzzworkMarketDataSingleItemEstimator',
              'App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl\EveWorkbenchSingleItemEstimator'
            ];
        }

	}
