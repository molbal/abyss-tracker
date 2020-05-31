<?php


	namespace App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\ISingleItemEstimator;
    use GuzzleHttp\Client;

    class FuzzworkMarketDataSingleItemEstimator implements ISingleItemEstimator {

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
        public function getPrice() : ?ItemObject {

            $client = new Client();
            $response = null;
            try {
                $uri = sprintf("%saggregates/?region=%d&types=%d", env('FUZZWORK_API_ROOT'), 60003760, $this->typeId);
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
            if(!isset($resp[$this->typeId]["sell"]["min"])) {
                throw new RemoteAppraisalToolException("Response contained no sell orders ".$response);
            }

            if(!isset($resp[$this->typeId]["buy"]["max"])) {
                throw new RemoteAppraisalToolException("Response contained no buy orders ".$response);
            }

            /** @var ResourceLookupService $resourceLookup */
            $resourceLookup = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');
            $itemObj = new ItemObject();
            $itemObj->setTypeId($this->typeId)
                    ->setName($resourceLookup->getStationName($this->typeId))
                    ->setBuyPrice($resp[$this->typeId]["buy"]["max"])
                    ->setSellPrice($resp[$this->typeId]["sell"]["min"]);

            return $itemObj;
        }
    }
