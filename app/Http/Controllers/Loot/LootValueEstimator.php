<?php


    namespace App\Http\Controllers\Loot;


    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class LootValueEstimator {
        /** @var string */
        private $rawData;

        /** @var EveItem[] */
        private $items;

        /** @var int */
        private $totalPrice;

        /**
         * LootValueEstimator constructor.
         *
         * @param string $rawData
         */
        public function __construct(string $rawData) {
            $this->rawData = $rawData;
            $this->items = [];
            $this->totalPrice = null;
            $this->process();
        }

        public function getItems() {
            return $this->items;
        }

        /**
         * @return int
         */
        public function getTotalPrice(): int {
            return $this->totalPrice;
        }


        private function process() {
            try {

                $data = $this->sendToEvePraisal();

                $this->totalPrice = round(($data->totals->buy + $data->totals->sell) / 2);

                foreach ($data->items as $item) {
                    $eveItem = new EveItem();
                    $eveItem
                        ->setItemName($item->name)
                        ->setItemId($item->typeID)
                        ->setBuyValue($item->prices->buy->max)
                        ->setSellValue($item->prices->sell->min)
                        ->setCount($item->quantity);
                    $this->items[] = $eveItem;
                }
            } catch (\Exception $e) {
                Log::warning($e);
                $this->totalPrice = 0;
                $this->items = [];
            }

        }

        /**
         * Sends the raw data from eve praisal and returns
         *
         * @return mixed
         */
        private function sendToEvePraisal() {

            $ch = curl_init("http://evepraisal.com/appraisal");
            curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_USERAGENT => "Abyss Loot Tracker (https://abyss.eve-nt.uk)", CURLOPT_POST => true, CURLOPT_POSTFIELDS => http_build_query(['visibility' => "private", 'persist' => "yes", 'price_percentage' => "100", 'expire_after' => "3m", 'raw_textarea' => $this->rawData, 'market' => "jita",]), CURLOPT_VERBOSE => true, CURLOPT_HEADER => true]);
            $response = curl_exec($ch);

            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            $body = substr($response, $header_size);

            $headers = explode("\r\n", $header);
            $id = "";
            foreach ($headers as $hdr) {
                $hdd = explode(":", $hdr, 2);
                if ($hdd[0] == "X-Appraisal-Id") {
                    $id = trim($hdd[1]);
                    break;
                }
            }

            $json = @file_get_contents("http://evepraisal.com/a/$id.json");

            return json_decode($json);
        }


        public static function setItemPrice(EveItem $item) {
            if (DB::table("item_prices")->where("ITEM_ID", $item->getItemId())->doesntExist()) {
                Log::info("Inserting " . $item->getItemName());
                $data = json_decode(@file_get_contents("https://esi.evetech.net/latest/universe/types/" . $item->getItemId() . "/?datasource=tranquility&language=en-us"));
                $group_data = json_decode(@file_get_contents("https://esi.evetech.net/latest/universe/groups/" . $data->group_id . "/?datasource=tranquility&language=en-us"));

                if (stripos($item->getItemName().$group_data->name, "blueprint") !== false) {
                    $item->setBuyValue(0);
                    $item->setSellValue(0);
                }

                DB::table("item_prices")->insert([
                    "ITEM_ID" => $item->getItemId(),
                    "NAME" => $item->getItemName(),
                    "PRICE_BUY" => $item->getBuyValue(),
                    "PRICE_SELL" => $item->getSellValue(),
                    "DESCRIPTION" => $data->description,
                    "GROUP_ID" => $data->group_id,
                    "GROUP_NAME" => $group_data->name
                ]);
            } else {
                if (DB::table("item_prices")->where("ITEM_ID", $item->getItemId())->whereRaw("PRICE_LAST_UPDATED < NOW() - INTERVAL 24 HOUR")->exists()) {
                    Log::info("Updating " . $item->getItemName());


                    if (stripos($item->getItemName(), "blueprint") !== false) {
                        $item->setBuyValue(0);
                        $item->setSellValue(0);
                    }

                    DB::table("item_prices")->where("ITEM_ID", $item->getItemId())->update([
                        "PRICE_BUY" => $item->getBuyValue(),
                        "PRICE_SELL" => $item->getSellValue(),
                        "PRICE_LAST_UPDATED" => Carbon::now()
                    ]);
                } else {
                    Log::info("Not updating item " . $item->getItemName());
                }
            }
        }

    }
