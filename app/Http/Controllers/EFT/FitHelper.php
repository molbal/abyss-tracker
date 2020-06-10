<?php


	namespace App\Http\Controllers\EFT;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\Cache\DBCacheController;
    use App\Http\Controllers\EFT\Constants\DogmaAttribute;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\NotAnItemException;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class FitHelper {

        /** @var ResourceLookupService */
        protected $resourceLookup;

        /** @var ItemPriceCalculator */
        protected $priceCalculator;

        /**
         * FitHelper constructor.
         *
         * @param ResourceLookupService $resourceLookup
         * @param ItemPriceCalculator   $priceCalculator
         */
        public function __construct(ResourceLookupService $resourceLookup, ItemPriceCalculator $priceCalculator) {
            $this->resourceLookup = $resourceLookup;
            $this->priceCalculator = $priceCalculator;
        }


        /**
         * @param string $itemName
         *
         * @return int item ID
         * @throws \Exception When Item ID is not found
         */
        public function getItemID(string $itemName): int {
            if (preg_match('/^\[Empty.+slot\]$/i',trim($itemName))) {
                throw new NotAnItemException("Item $itemName is not an EVE item");
            }

            // Get local
            if (DB::table("item_prices")->where("NAME", $itemName)->exists())
                return DB::table("item_prices")->where("NAME", $itemName)->value("ITEM_ID");

            // Call the API
            return intval($this->resourceLookup->itemNameToId($itemName));
        }

        /**
         * Gets which display group an item belongs to:
         * high, mid, low, rig, drone, ammo, cargo, booster, implant
         * @param int $itemID
         *
         * @return string high, mid, low, rig, drone, ammo, cargo, booster, implant or null if an error was thrown
         * @throws \Exception
         */
        public function getItemSlot(int $itemID):string {

            if ($itemID == -1) {
                throw new NotAnItemException("This is not an EVE Item and has no slot");
            }

           return Cache::remember("aft.item-slot.$itemID", now()->addMinutes(15), function () use ($itemID) {
                if (DB::table("item_slot")->where("ITEM_ID", $itemID)->exists()) {
                    return DB::table("item_slot")->where("ITEM_ID", $itemID)->value("ITEM_SLOT");
                }

                /** @var ItemClassifier $itemClassifier */
                $itemClassifier = resolve("App\Http\Controllers\EFT\ItemClassifier");
                $itemSlot =  $itemClassifier->classify($itemID);
                if ($itemSlot) {

                    if (!DB::table("item_prices")->where("ITEM_ID", $itemID)->exists()) {
                        DB::table("item_prices")->insertOrIgnore([
                            'ITEM_ID' => $itemID,
                            'PRICE_BUY' => 0,
                            'PRICE_SELL' => 0,
                            'PRICE_LAST_UPDATED' => now(),
                            'DESCRIPTION' => '',
                            'GROUP_ID' => 0,
                            'GROUP_NAME' => '',
                            'NAME' => '',
                        ]);
                    }
                    DB::table("item_slot")
                      ->insert(["ITEM_ID" => $itemID, "ITEM_SLOT" => $itemSlot]);
                }
                return $itemSlot;
            });

        }

        /**
         * Inserts 2 lines after the first drone stack found
         *
         * @param string $eft
         *
         * @param int    $shipId
         *
         * @return string
         * @throws \Exception
         */
        public function pyfaBugWorkaround(string $eft, int $shipId) {

            $lines = explode("\n", $eft);
            $fit = "";
            $drone_happened = false;
            $first = array_shift($lines);
            $availableBandwidth = $this->getShipDroneBandwidth($shipId);
            foreach ($lines as $line) {
                $line = trim($line);
                $lineOriginal = $line;
                if ($line == "") {
                    $fit .= "\n";
                    continue;
                };

                if (!$drone_happened) {

                    // Let's get before the comma: strip ammo
                    $all = explode(',', $line, 2);

                    $line = $all[0];
                    if (preg_match('/^.+x\d{0,4}$/m', $line)) {
                        $words = explode(' ', $line);
                        $count = intval(str_replace("x", "",array_pop($words)));
                        $line = implode(" ", $words);
                    }
                    else {
                        $count = 1;
                    }
                    try {
                        $itemID = $this->getItemID($line);
                        $slot = $this->getItemSlot($itemID);
                        if ($slot == "drone") {

                            $slotCount = 0;
                            for ($i = 1; $i<=$count;$i++) {
                                $droneBandwidthUsage = $this->getDroneBandwidthUsage($itemID);
                                if ($availableBandwidth >= $droneBandwidthUsage) {
                                    $slotCount++;
                                    $availableBandwidth-=$droneBandwidthUsage;
                                }
                            }

                            $fit .= sprintf("%s x%d\n", $line, $slotCount);

                            if ($availableBandwidth == 0 || $count > $slotCount) {
                                $fit .= "\n\nTritanium\n";
                                $drone_happened = true;
                            }

                            $fit .= sprintf("%s x%d\n", $line, $count-$slotCount);
                        }
                        else {
                            $fit .= $lineOriginal."\n";
                        }
                    }
                    catch (NotAnItemException $ignored) {
                        $fit .= $lineOriginal."\n";
                    }
                }
                else {
                    $fit .= $lineOriginal."\n";
                }
            }

            return $first."\n".$fit;
        }

        /**
         * Gets a fit hash that is very similar
         *
         * @param string $eft
         *
         * @return string
         */
        public function getFitFFH(string $eft): string {

            return DBCacheController::remember("hash_links", md5($eft), function() use ($eft) {
                $lines = explode("\n", trim($eft));
                $first_line = array_shift($lines);
                $ship = explode(",", explode("[", $first_line,2)[1], 2)[0];
                $modules = [];
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line == "") {
                        continue;
                    }
                    $line = explode(',', $line, 2)[0];
                    if (preg_match('/^.+x\d{0,4}$/m', $line)) {
                        $words = explode(' ', $line);
                        $last = array_pop($words);
                        $count = intval(str_replace("x", "", $last));
                        $line = implode(" ", $words);
                    }
                    try {
                        $itemId = $this->getItemID($line);
                        if (in_array($this->getItemSlot($itemId), ["high", "mid", "low", "rig"])) {
                            $modules[] = $itemId;
                        }
                    }
                    catch (NotAnItemException $ignored) {
                        $itemId = -1;
                    }
                }
                sort($modules);
                $str = $ship . ";" . implode(";", $modules);
                return md5($str);
            });
        }

        /**
         * Gets the maximum drone bandwidth of a ship
         * @param int $item_id
         *
         * @return mixed|null
         */
        public function getShipDroneBandwidth(int $item_id) {
            return DBCacheController::remember("drone_bandwidth", $item_id, function () use ($item_id) {
                $itemInfo = $this->resourceLookup->getItemInformation($item_id);
                $item = new ItemInfoParser($itemInfo);
                try {
                    return $item->getDogmaAttribute(DogmaAttribute::DRONE_BANDWIDTH_AVAILABLE);
                }
                catch (\Exception $e) {
                    return 0;
                }
            });
        }

        /**
         * Gets bandwidth usage of a drone
         * @param int $item_id
         *
         * @return mixed|null
         */
        public function getDroneBandwidthUsage(int $item_id) {

            return DBCacheController::remember("drone_bandwidth", $item_id, function () use ($item_id) {
                $itemInfo = $this->resourceLookup->getItemInformation($item_id);
                $item = new ItemInfoParser($itemInfo);
                try {
                    return $item->getDogmaAttribute(DogmaAttribute::DRONE_BANDWIDTH_USED);
                }
                catch (\Exception $e) {
                    return 0;
                }
            });
        }

        /**
         * Quick parses the EFT fit.
         *
         * @param string $eft
         *
         * @return array
         * @throws \Exception
         */
        public function quickParseEft(string $eft) {

            return Cache::remember("aft.fit-parsed.".md5($eft), now()->addHour(1), function () use ($eft) {

                $struct = ['high' => [], 'mid' => [], 'low' => [], 'rig' => [], 'drone' => [], 'ammo' => [], 'cargo' => [], 'booster' => [], 'implant' => []];

                $lines = explode("\n", $eft);
                array_shift($lines);
                foreach ($lines as $line) {
                    $line = trim($line);

                    if ($line == "") continue;

                    $price = 0;

                    // Let's get before the comma: strip ammo
                    $ammo = trim(explode(',', $line, 2)[1] ?? "");
                    $ammo_id = Cache::remember("aft.item-price." . md5($line), now()->addHour(), function () use ($ammo) {
                        return DB::table("item_prices")
                                 ->where("NAME", $ammo)
                                 ->value("ITEM_ID");
                    });

                    $line = explode(',', $line, 2)[0];

                    $count = 1;
                    if (preg_match('/^.+x\d{0,4}$/m', $line)) {
                        $words = explode(' ', $line);
                        $count = intval(str_replace("x", "", array_pop($words)));
                        $line = implode(" ", $words);
                    }

                    try {
                        $price = $this->priceCalculator->getFromItemName($line);
                        if ($price == null) {
                            Log::warning("Item price calculator got 0 ISK result for [$line]");
                        }
                    } catch (\Exception $e) {
                        Log::warning($e);
                        $price = (new ItemObject())->setTypeId(0)
                                                   ->setName($line)
                                                   ->setSellPrice(0)
                                                   ->setSellPrice(0);
                    }
                    try {
                        $itemID = Cache::remember("aft.item-id-from-line." . md5($line), now()->addHour(), function () use ($line) {
                            return $this->getItemID($line);
                        });
                    } catch (NotAnItemException $ignored) {
                        continue;
                    }
                    $slot = Cache::remember("aft.item-slot-from-id." . $itemID, now()->addHour(), function () use ($itemID) {
                        return $this->getItemSlot($itemID);
                    });

                    $struct[$slot][] = ['name' => $line, 'id' => $itemID, 'ammo' => $ammo, 'count' => $count, 'price' => $price, 'ammo_id' => $ammo_id ?? null, 'slot' => $slot];
                }

                return $struct;

            });
        }

    }
