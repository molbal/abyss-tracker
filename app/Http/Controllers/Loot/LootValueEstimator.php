<?php


    namespace App\Http\Controllers\Loot;


    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Exceptions\FitFatalException;
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
        public function getTotalPrice() : int {
            return $this->totalPrice;
        }

        /**
         * Gets the difference between two loot strings.
         *
         * @param string $new
         * @param string $old
         *
         * @return array
         */
        public static function difference(string $new, string $old) : array {
            $newItems = (new LootValueEstimator($new))->getItems();
            $oldItems = (new LootValueEstimator($old))->getItems();

            $lostItems = [];
            $gainedItems = [];

            foreach ($oldItems as $oldItem) {
                $exists = false;
                foreach ($newItems as $newItem) {
                    if ($oldItem->getItemId() == $newItem->getItemId()) {
                        $exists = true;
                        if ($oldItem->getCount() > $newItem->getCount()) {
                            $lostItem = new EveItem();
                            $lostItem->setItemId($oldItem->getItemId())
                                     ->setCount($oldItem->getCount() - $newItem->getCount())
                                     ->setBuyValue($oldItem->getBuyValue())
                                     ->setSellValue($oldItem->getSellValue())
                                     ->setItemName($oldItem->getItemName());
                            $lostItems[] = $lostItem;
                        }
                    }
                }
                if (!$exists) {
                    $lostItems[] = $oldItem;
                }
            }

            foreach ($newItems as $newItem) {
                $exists = false;
                foreach ($oldItems as $oldItem) {
                    if ($oldItem->getItemId() == $newItem->getItemId()) {
                        $exists = true;
                        if ($oldItem->getCount() < $newItem->getCount()) {
                            $gainedItem = new EveItem();
                            $gainedItem->setItemId($newItem->getItemId())
                                       ->setCount($newItem->getCount() - $oldItem->getCount())
                                       ->setBuyValue($newItem->getBuyValue())
                                       ->setSellValue($newItem->getSellValue())
                                       ->setItemName($newItem->getItemName());
                            $gainedItems[] = $gainedItem;
                        }
                    }
                }
                if (!$exists) {
                    $gainedItems[] = $newItem;
                }
            }

            $total_price = 0;

            foreach ($gainedItems as $gainedItem) {
                $total_price += $gainedItem->getCount() * (($gainedItem->getSellValue() + $gainedItem->getBuyValue()) / 2);
            }

//            Log::info("newItems: " . print_r($newItems, 1));
//            Log::info("oldItems: " . print_r($oldItems, 1));
//            Log::info("gainedItems: " . print_r($gainedItems, 1));
//            Log::info("lostItems: " . print_r($lostItems, 1));


            return ["gainedItems" => $gainedItems, "lostItems" => $lostItems, "totalPrice" => round($total_price)];
        }

        /**
         * @throws FitFatalException
         */
        private function process() {
            if ($this->rawData == "") {
                $this->totalPrice = 0;
                $this->items = [];

                return;
            }
            try {

                $data = $this->sendToEvePraisal();
                Log::channel("lootvalue")->info("Regualar loot for evepraisal. Sent: ".print_r($this->rawData, 1)." - returned: ".print_r($data, 1));

                $this->totalPrice = round(($data->totals->buy + $data->totals->sell) / 2);

                foreach ($data->items as $item) {
                    $ex = false;
                    foreach ($this->items as $eitem) {
                        if ($eitem->getItemId() == $item->typeID) {
                            $ex = true;
                            $eitem->setCount($eitem->getCount() + $item->quantity);
                            break;
                        }
                    }
                    if (!$ex) {
                        if ($item->typeID == 0 && $item->name != "") {
                            /** @var ResourceLookupService $res */
                            $res = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');
                            Log::warning("EvePraisal returned faulty reply for " . $item->name . ", attempting to fix it with ESI");
                            $item->typeID = $res->itemNameToId($item->name);
                            Log::warning("Fix: " . $item->typeID);
                        }

                        if (!$item->typeID) {
                            throw new FitFatalException("Unable to recognize module '$item->name'.");
                        }
                        $eveItem = new EveItem();
                        $eveItem->setItemName($item->name)
                                ->setItemId($item->typeID)
                                ->setBuyValue($item->prices->buy->max)
                                ->setSellValue($item->prices->sell->min)
                                ->setCount($item->quantity);


                        if (stripos($eveItem->getItemName(), "blueprint") !== false) {
                            $eveItem->setSellValue(0)
                                    ->setBuyValue(0);
                        }

                        // Burnt in value for red loot
                        if ($eveItem->getItemId() == 48121) {
                            $eveItem->setBuyValue(100000);
                        }
                        $this->items[] = $eveItem;
                    }
                }
            }
            catch (FitFatalException $e) {
                Log::error($e);
                throw $e;
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

        public static function getEvePraisalItem(int $itemId) {
            $raw = file_get_contents(sprintf("https://evepraisal.com/item/%d.json", $itemId));
            $parsed = json_decode($raw, 1);

            return [$parsed['summaries'][0]['prices']['buy']['max'], $parsed['summaries'][0]['prices']['sell']['min']];
        }

        /**
         * Persists item price in the database
         *
         * @param EveItem $item
         */
        public static function setItemPrice(EveItem $item) {
            if (DB::table("item_prices")
                  ->where("ITEM_ID", $item->getItemId())
                  ->doesntExist()) {
                $data = json_decode(@file_get_contents("https://esi.evetech.net/latest/universe/types/" . $item->getItemId() . "/?datasource=tranquility&language=en-us"));
                $group_data = json_decode(@file_get_contents("https://esi.evetech.net/latest/universe/groups/" . $data->group_id . "/?datasource=tranquility&language=en-us"));


                if (stripos($item->getItemName() . $group_data->name, "blueprint") !== false) {
                    $item->setBuyValue(0);
                    $item->setSellValue(0);
                } else if ($item->getBuyValue() == 0 && $item->getSellValue() == 0) {
                    $fixed = self::getEvePraisalItem($item->getItemId());
                    $item->setBuyValue($fixed[0]);
                    $item->setSellValue($fixed[1]);
                }

                DB::table("item_prices")
                  ->insert(["ITEM_ID" => $item->getItemId(), "NAME" => $item->getItemName(), "PRICE_BUY" => $item->getBuyValue(), "PRICE_SELL" => $item->getSellValue(), "DESCRIPTION" => $data->description, "GROUP_ID" => $data->group_id, "GROUP_NAME" => $group_data->name]);
            } else {
                if (DB::table("item_prices")
                      ->where("ITEM_ID", $item->getItemId())
                      ->whereRaw("PRICE_LAST_UPDATED < NOW() - INTERVAL 24 HOUR")
                      ->exists()) {
                    if (stripos($item->getItemName(), "blueprint") !== false) {
                        $item->setBuyValue(0);
                        $item->setSellValue(0);
                    } else if ($item->getBuyValue() == 0 && $item->getSellValue() == 0) {
                        $fixed = self::getEvePraisalItem($item->getItemId());
                        $item->setBuyValue($fixed[0] ?? 0);
                        $item->setSellValue($fixed[1] ?? 0);
                    }

                    DB::table("item_prices")
                      ->where("ITEM_ID", $item->getItemId())
                      ->update(["PRICE_BUY" => $item->getBuyValue(), "PRICE_SELL" => $item->getSellValue(), "PRICE_LAST_UPDATED" => Carbon::now(), 'NAME' => $item->getItemName()]);
                }
            }
        }

    }
