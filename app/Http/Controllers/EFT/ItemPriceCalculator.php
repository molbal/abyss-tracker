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
            $client = new Client();
            $response = null;
            try {
                $response = $client->request('POST', env('EVEWORKBENCH_API_ROOT') . "appraisal?Station=60003760&Type=1", [
                    'auth' => [
                        env('EVEWORKBENCH_API_CLIENT_ID'),
                        env('EVEWORKBENCH_API_APP_KEY')],
                    'body' => $this->resourceLookup->generalNameLookup($typeId),
                    'timeout' => 12
                ]);

            } catch (\Exception $e) {
                dd($e);
                throw new RemoteAppraisalToolException("EVE Workbench connection error: " . $e->getMessage());
            }

            try {
                $item = json_decode($response->getBody()
                                             ->getContents());
                if ($item->error != false) {
                    dd("error: ", $item);
                    throw new RemoteAppraisalToolException("EVE Workbench returned an error: " . $item->message);
                }
                if ($item->resultCount != 1) {
                    dd("iv res co: ", $item);
                    throw new RemoteAppraisalToolException("EVE Workbench returned an invalid result count: " . $item->resultCount . ", 1 expected.");
                }

                $item = $item->result->items[0] ?? null;

                if (!isset($item->buyPrice) || !isset($item->sellPrice)) {
                    throw new RemoteAppraisalToolException("EVE Workbench returned an entry without buy or sell price: ".print_r($item, 1));
                }

                $itemObj = new ItemObject();
                $itemObj->setTypeId($typeId)
                    ->setName($item->name)
                    ->setBuyPrice($item->buyPrice)
                    ->setSellPrice($item->sellPrice);

                return $itemObj;
            } catch (\Exception $e) {
                dd($e);
                throw new RemoteAppraisalToolException("EVE Workbench connection error: " . $e->getMessage());
            }


        }
        private function getFromItemPriceTable($name) {

        }
	}
