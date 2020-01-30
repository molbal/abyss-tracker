<?php


    namespace App\Http\Controllers\Loot;


    class LootValueEstimator
    {
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
        public function __construct(string $rawData)
        {
            $this->rawData = $rawData;
            $this->items = [];
            $this->totalPrice = null;
            $this->process();
        }

        public function getItems()
        {
            return $this->items;
        }

        /**
         * @return int
         */
        public function getTotalPrice() : int
        {
            return $this->totalPrice;
        }



        private function process()
        {
            $data = $this->sendToEvePraisal();

            $this->totalPrice = round(($data->totals->buy+$data->totals->sell)/2);

            foreach ($data->items as $item) {
                $eveItem = new EveItem();
                $eveItem
                    ->setItemName($item->name)
                    ->setItemId($item->typeID)
                    ->setBuyValue($item->prices->buy->max)
                    ->setSellValue($item->prices->sell->min);
                $this->items[] = $eveItem;
            }

        }

        /**
         * Sends the raw data from eve praisal and returns
         *
         * @return mixed
         */
        private function sendToEvePraisal()
        {
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

            $json = file_get_contents("http://evepraisal.com/a/$id.json");

            return json_decode($json);
        }

    }
