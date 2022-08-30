<?php


	namespace App\Http\Controllers\Partners;


	use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use App\Http\Controllers\Loot\EveItem;
    use Exception;
    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\GuzzleException;
    use http\Client\Response;
    use http\Exception\RuntimeException;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Str;
    use Illuminate\Support\Collection;

    class Janice {


        /**
         * Appraises using Janice
         *
         * @param string $body
         *
         * @return EveItem[]|null
         * @throws GuzzleException
         */
        public static function appraise(string $body): ?array {
            $http = new Client([
                'headers' => [
                        'Content-Type' => 'text/plain',
                        'Accept' => 'application/json',
                        'User-Agent' => config('tracker.esi.useragent')]
            ]);

            $resp = null;
            try {
                $uri = sprintf("%sappraisal?key=%s&market=2&designation=100&pricing=200&persist=false", config('tracker.market.janice.service-root'), config('tracker.market.janice.app-key'));
                $resp = $http->request(
                 'POST',
                 $uri,
                 [
                     'body' => $body,
                     'timeout' => 12,
//                     'debug' => fopen("c:\\VM\\resource.txt", "w+")
                 ]);

                if ($resp->getStatusCode() != 200) {
                    throw new Exception("Invalid response code: ".$resp->getStatusCode());
                }

                $contents = $resp->getBody()
                                 ->getContents();
                if (Str::of($contents)->isEmpty()) {
                    throw new Exception("Empty response body");
                }
            }
            catch (Exception $e) {
                Log::channel('lootvalue')->warning(sprintf("%s %s: Could not appraise [%s] at [%s]", get_class($e), $e->getMessage(), $body, $uri));
                return null;
            }

            $appraised = json_decode($contents);

            if ($appraised->failures != "") {
                throw new Exception("Could not appraise the following item(s): ". $appraised->failures);
            }

            $ret = collect();
            foreach ($appraised->items as $item) {

                $eveItem = (new EveItem())
                    ->setCount($item->amount)
                    ->setBuyValue($item->buyPriceMedian5)
                    ->setSellValue($item->sellPriceMedian5)
                    ->setItemId($item->itemType->eid)
                    ->setItemName($item->itemType->name);

                $ret->add($eveItem);
            }

            //Update Cache!
            $ret_collection = new Collection($ret->toArray());
            $ipc = resolve('App\Http\Controllers\EFT\ItemPriceCalculator');
            $ipc->updateBulkTablePrices($ret_collection);

            Log::channel("lootvalue")->debug('Estimated '.count($ret)." lines with Janice");
            return $ret->toArray();

	    }

	}
