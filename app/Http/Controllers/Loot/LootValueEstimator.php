<?php


    namespace App\Http\Controllers\Loot;


    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Exceptions\FitFatalException;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\ItemPriceCalculator;
    use App\Http\Controllers\Partners\Janice;
    use App\Http\Controllers\Partners\EveWorkbench;
    use Carbon\Carbon;
    use GuzzleHttp\Client;
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

            $rawData = collect(explode("\n", $rawData))->reject(function ($value, $key) {
                 return trim($value) == "" ? true : false;
            })->implode("\n");


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
                $total_price += $gainedItem->getStackAverageValue();
            }

            foreach ($lostItems as $lostItem) {
                $total_price -= $lostItem->getStackAverageValue();
            }


            return ["gainedItems" => $gainedItems, "lostItems" => $lostItems, "totalPrice" => round($total_price)];
        }

        /**
         * @throws FitFatalException
         */
        private function process() {
            // Notes.  First tries Janice, then tries EWB, else empty array
            // Then does math and returns result! -- if both fail, it's an empty array and returns 0
            if ($this->rawData == "") {
                $this->totalPrice = 0;
                $this->items = [];

                return;
            }

            // Try Janice
            try {
                $this->items = Janice::appraise($this->rawData);
            }
            catch (\Exception $e) {
                Log::warning("Janice appraisal failed - using EWB: ".$e->getMessage());
            }

            // Try EWB
            if ($this->items == null || count($this->items) == 0) {
                Log::channel("lootvalue")->warning("Janice failed, trying Eve Workbench");
                // Try EWB
                try {
                    $this->items = EveWorkbench::appraise($this->rawData);
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

            // Try Table_Prices / Fuzzy / EWB Single
            if ($this->items == null || count($this->items) == 0) {
                try {
                    $ipc = resolve('App\Http\Controllers\EFT\ItemPriceCalculator');
                    $raw_by_line = explode("\n",$this->rawData);
                    $_tmp = [];
                    $_tmp_bps = [];
                    foreach ( $raw_by_line as $line ) {
                        try {
                            $line_exploded = explode("\t",$line);
                            $name = $line_exploded[0];
                            $itemObj = $ipc->getFromItemName($name);

                            // blueprints are silly and don't stack and don't include a number >.>
                            // blueprints are silly and don't stack and don't include a number >.>
                            if (stripos($name, "blueprint") !== false) {
                                $_tmp_bps[] = (new EveItem())
                                ->setCount(1)
                                ->setItemId($itemObj->getTypeId())
                                ->setItemName($name);
                                continue;
                            }

                            // CHECK if we already have placed item into $_tmp!
                            if ( isset($_tmp[ $itemObj->getTypeId() ] ) ) {
                                $cur_eveitem = $_tmp[ $itemObj->getTypeId() ];
                                $_tmp[ $cur_eveitem->getItemId() ]->setCount( $cur_eveitem->getCount()+$line_exploded[1]);
                            //First add!
                            } else {
                                $_tmp[ $itemObj->getTypeId() ] = (new EveItem())
                                ->setCount($line_exploded[1])
                                ->setBuyValue($itemObj->getBuyPrice())
                                ->setSellValue($itemObj->getSellPrice())
                                ->setItemId($itemObj->getTypeId())
                                ->setItemName($name);
                            }

                        } catch (\InvalidArgumentException $e) {
                            //not found... at this point just ignore and move on with life
                        } catch (\Error $e) {
                            Log::error($e);
                        }
                    }


                    $this->items = array_merge($_tmp,$_tmp_bps);
                } catch (\Error $e ) {
                    Log::error($e);
                    $this->totalPrice = 0;
                    $this->items = [];
                }
            }


            foreach ($this->items as $eveItem) {
                //Do overrides on either Janice or EWB data as they are in the same format.
                //Burnt in value for red loot
                if ($eveItem->getItemId() == 48121) {
                    $eveItem->setBuyValue(100000)
                            ->setSellValue(100000);
                } else if (stripos($eveItem->getItemName(), "blueprint") !== false) {
                    $eveItem->setSellValue(0)
                            ->setBuyValue(0);
                }

                $this->totalPrice+=$eveItem->getStackAverageValue();
            }
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
//                    $fixed = self::getEvePraisalItem($item->getItemId());
//                    $item->setBuyValue($fixed[0]);
//                    $item->setSellValue($fixed[1]);
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
//                        $fixed = self::getEvePraisalItem($item->getItemId());
//                        $item->setBuyValue($fixed[0] ?? 0);
//                        $item->setSellValue($fixed[1] ?? 0);
                    }

                    DB::table("item_prices")
                      ->where("ITEM_ID", $item->getItemId())
                      ->update(["PRICE_BUY" => $item->getBuyValue(), "PRICE_SELL" => $item->getSellValue(), "PRICE_LAST_UPDATED" => Carbon::now(), 'NAME' => $item->getItemName()]);
                }
            }
        }

    }
