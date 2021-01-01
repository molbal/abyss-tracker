<?php


	namespace App\Http\Controllers\Partners;


	use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use App\Http\Controllers\Loot\EveItem;
    use GuzzleHttp\Client;
    use http\Client\Response;
    use http\Exception\RuntimeException;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Str;

    class Janice {


        /**
         * Appraises using Janice
         *
         * @param string $body
         *
         * @return EveItem[]|null
         * @throws \GuzzleHttp\Exception\GuzzleException
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
                     'debug' => fopen("c:\\VM\\resource.txt", "w+")
                 ]);

                if ($resp->getStatusCode() != 200) {
                    throw new RuntimeException("Invalid response code: ".$resp->getStatusCode());
                }

                $contents = $resp->getBody()
                                 ->getContents();
                if (Str::of($contents)->isEmpty()) {
                    throw new RuntimeException("Empty response body");
                }
            }
            catch (\Exception $e) {
                Log::channel('lootvalue')->warning(sprintf("%s %s: Could not appraise [%s] at [%s]", get_class($e), $e->getMessage(), $body, $uri));
                return null;
            }

            $appraised = json_decode($contents);

            if ($appraised->failures != "") {
                throw new RuntimeException("Could not appraise the following item(s): ". $appraised->failures);
            }


            $ret = [];
            foreach ($appraised->items as $item) {
                $eveItem = (new EveItem())
                ->setCount($item->amount)
                ->setBuyValue($item->buyPriceMedian5)
                ->setSellValue($item->sellPriceMedian5)
                ->setItemId($item->itemType->eid)
                ->setItemName($item->itemType->name);


                // Burnt in value for red loot
                if ($eveItem->getItemId() == 48121) {
                    $eveItem->setBuyValue(100000);
                    $eveItem->setSellValue(100000);
                }
                elseif (stripos($eveItem->getItemName(), "blueprint") !== false) {
                    $eveItem->setSellValue(0)
                            ->setBuyValue(0);
                }

                $ret[] = $eveItem;
            }

            Log::channel("lootvalue")->debug('Estimated '.count($ret)." lines with Janice");
            return $ret;

	    }

	}
