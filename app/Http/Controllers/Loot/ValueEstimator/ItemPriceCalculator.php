<?php


	namespace App\Http\Controllers\EFT;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use GuzzleHttp\Client;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

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
            $dto = Cache::remember("aft.item-price." . $typeId, now()->addHour(), function () use ($typeId) {
                $obj = DB::table("item_prices")
                                ->where("ITEM_ID", $typeId)
                                ->where("PRICE_LAST_UPDATED", ">", now()->subDay())
                                ->first();

                $itemObj = new ItemObject();
                $itemObj->setTypeId($typeId)
                        ->setName($obj->NAME)
                        ->setBuyPrice($obj->PRICE_BUY)
                        ->setSellPrice($obj->PRICE_SELL);

                return $itemObj;
            }) ?? null;

            if ($dto == null) {
                try {
                    $dto = $this->appraiseWithEveWorkbench($typeId);
                }
                catch (RemoteAppraisalToolException $exc) {
                    $dto = null;
                }
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


        /**
         * @param int $typeId
         *
         * @return ItemObject
         * @throws RemoteAppraisalToolException
         */
        private function appraiseWithEveWorkbench(int $typeId): ItemObject {
        }
        private function getFromItemPriceTable($name) {

        }
	}
