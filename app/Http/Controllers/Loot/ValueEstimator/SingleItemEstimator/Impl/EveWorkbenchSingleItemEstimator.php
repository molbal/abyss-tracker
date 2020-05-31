<?php


	namespace App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\ISingleItemEstimator;
    use GuzzleHttp\Client;

    class EveWorkbenchSingleItemEstimator implements ISingleItemEstimator {

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

            /** @var ResourceLookupService $resourceLookup */
            $resourceLookup = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');

            $client = new Client();
            $response = null;
            try {
                $response = $client->request('POST', env('EVEWORKBENCH_API_ROOT') . "appraisal?Station=60003760&Type=1", [
                    'auth' => [
                        env('EVEWORKBENCH_API_CLIENT_ID'),
                        env('EVEWORKBENCH_API_APP_KEY')],
                    'body' => $resourceLookup->generalNameLookup($this->typeId),
                    'timeout' => 12
                ]);

            } catch (\Exception $e) {
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
                $itemObj->setTypeId($this->typeId)
                        ->setName($item->name)
                        ->setBuyPrice($item->buyPrice)
                        ->setSellPrice($item->sellPrice);

                return $itemObj;
            } catch (\Exception $e) {
                dd($e);
                throw new RemoteAppraisalToolException("EVE Workbench connection error: " . $e->getMessage());
            }


        }
    }
