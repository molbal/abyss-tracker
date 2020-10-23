<?php


	namespace App\Http\Controllers\Loot\ValueEstimator\BulkItemEstimator\Impl;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use App\Http\Controllers\Loot\ValueEstimator\BulkItemEstimator\IBulkItemEstimator;
    use GuzzleHttp\Client;
    use Illuminate\Support\Collection;

    class FuzzworkMarketDataBulkEstimator implements IBulkItemEstimator {
        /** @var Collection */
        private $listOfTypeIds;

        public function __construct(Collection $listOfTypeIds) {
            $this->listOfTypeIds = $listOfTypeIds;
        }

        public function getPrice() : Collection {

//            https://market.fuzzwork.co.uk/aggregates/?region=10000002&types=48112,12005

            $return = collect([]);

            $client = new Client();
            $response = null;
            try {
                $uri = sprintf("%s/aggregates/?region=%d&types=%s", config('tracker.market.fuzzwork-api-root'), config('tracker.market.jita-id', 60003760), $this->listOfTypeIds->implode(","));
                $response = $client->request('GET', $uri, [
                    'timeout' => 12
                ]);

            } catch (\Exception $e) {
                throw new RemoteAppraisalToolException("Fuzzwork Market connection error: " . $e->getMessage());
            }

            if (!$response) {
                throw new RemoteAppraisalToolException("No response received");
            }

            $resp = json_decode($response->getBody()->getContents(),1);

            /** @var ResourceLookupService $resourceLookup */
            $resourceLookup = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');

            foreach ($this->listOfTypeIds as $typeId) {
                if(!isset($resp[$typeId]["sell"]["min"])) {
                    throw new RemoteAppraisalToolException("Response contained no sell orders ".$response->getBody()->getContents());
                }

                if(!isset($resp[$typeId]["buy"]["max"])) {
                    throw new RemoteAppraisalToolException("Response contained no buy orders ".$response->getBody()->getContents());
                }
                $itemObj = new ItemObject();
                $itemObj->setTypeId($typeId)
                        ->setName($resourceLookup->generalNameLookup($typeId) ?? "[Unknown item name for type {$typeId}]")
                        ->setBuyPrice($resp[$typeId]["buy"]["max"])
                        ->setSellPrice($resp[$typeId]["sell"]["min"]);

                $return->add([$typeId => $itemObj]);
            }


            return $return;
        }
    }
