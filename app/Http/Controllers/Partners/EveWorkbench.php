<?php



    namespace App\Http\Controllers\Partners;


	use DOMDocument;
    use DOMXPath;
    use Illuminate\Support\Facades\Http;
    use RuntimeException;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use GuzzleHttp\Client;
    use App\Http\Controllers\Loot\EveItem;

    class EveWorkbench {

        /**
         * Gets the EVE Workbench URL
         * @param string $name
         *
         * @return string
         */
        public static function getProfileUrl(string $name): string {
            $name = preg_replace('/[^a-zA-Z0-9\' ]/', '', $name);
            $name = str_replace("'", '', $name);
            return "https://www.eveworkbench.com/u/".strtolower(str_replace(" ", "-", $name));
	    }


        /**
         * Gets the FIT EFT from EVE Workbench
         * @param string $ewbLink
         *
         * @return string
         * @throws RuntimeException
         */
        public static function getEveWorkbenchFit(string $ewbLink) : string {
            libxml_use_internal_errors(true);
            $DOM = new DOMDocument();
            $source = Http::get($ewbLink);
            if ($source->failed() || !$source->successful()) {
                throw new RuntimeException("Could not get link " . $ewbLink);
            }
            $DOM->loadHTML($source->body());
            $xpath = new DOMXPath($DOM);
            $eft = $xpath->query('//textarea[@id="eftFitting"]')
                         ->item(0)->nodeValue;
            libxml_use_internal_errors(false);

            return $eft;
        }

        /**
         * Sends the raw data from eve praisal and returns
         *
         * @return mixed
         * @throws RemoteAppraisalToolException
         */
        public static function appraise(string $body) {

            $client = new Client();
            $response = null;
            try {
                $response = $client->request('POST', config('tracker.market.eveworkbench.service-root') . "appraisal?Type=1&Station=60003760", [
                    'headers' => [
                        'Authorization' => implode(":", [
                                config('tracker.market.eveworkbench.client-id'),
                                config('tracker.market.eveworkbench.app-key')
                            ]
                        )
                    ],
                    'body' => $body,
                    'timeout' => 12
                ]);

            } catch (\Exception $e) {
                throw new RemoteAppraisalToolException("EVE Workbench connection error: " . $e->getMessage());
            }

            $item = json_decode($response->getBody()->getContents());

            if ($item->error != false) {
                throw new RemoteAppraisalToolException("EVE Workbench returned an error: " . $item->message);
            }
            if ($item->resultCount == 0) {
                throw new RemoteAppraisalToolException("EVE Workbench returned an invalid result count: " . $item->resultCount . ", 0+ expected.");
            }

            $return_data = [];

            foreach( $item->result as $d ) {
                $eveItem = (new EveItem())
                    ->setItemName($d->name)
                    ->setItemId($d->typeID)
                    ->setCount($d->amount)
                    ->setSellValue(($d->sellPrice/$d->amount))
                    ->setBuyValue(($d->buyPrice/$d->amount));
                $return_data[] = $eveItem;
            }

            return $return_data;
        }
	}
