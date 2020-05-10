<?php


	namespace App\Http\Controllers\EFT;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\Cache\DBCacheController;
    use App\Http\Controllers\EFT\Constants\DogmaAttribute;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class FitHelper {

        /** @var ResourceLookupService */
        protected $resourceLookup;


        /**
         * FitHelper constructor.
         *
         * @param ResourceLookupService $resourceLookup
         */
        public function __construct(ResourceLookupService $resourceLookup) {
            $this->resourceLookup = $resourceLookup;
        }

        /**
         * @param string $itemName
         *
         * @return int item ID
         * @throws \Exception When Item ID is not found
         */
        public function getItemID(string $itemName): int {

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
            // Is cached?
            if (DB::table("item_slot")->where("ITEM_ID", $itemID)->exists()) {
                return DB::table("item_slot")->where("ITEM_ID", $itemID)->value("ITEM_SLOT");
            }

            /** @var ItemClassifier $itemClassifier */
            $itemClassifier = resolve("App\Http\Controllers\EFT\ItemClassifier");
            $itemSlot =  $itemClassifier->classify($itemID);
            if ($itemSlot) {
                DB::table("item_slot")->insert([
                    "ITEM_ID" => $itemID, "ITEM_SLOT" => $itemSlot
                ]);
            }
            return $itemSlot;
        }

        /**
         * Inserts 2 lines after the first drone stack found
         * @param string $eft
         *
         * @return string
         * @throws \Exception
         */
        public function pyfaBugWorkaround(string $eft) {

            $lines = explode("\n", $eft);
            $fit = "";
            $drone_happened = false;
            $first_line = array_shift($lines);
            $ship = explode(",", explode("[", $first_line,2)[1], 2)[0];
            $shipId = $this->getShipIDFromEft($eft);
            $availableBandwidth = $this->getShipDroneBandwidth($shipId);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line == "") continue;

                if (!$drone_happened) {

                    // Let's get before the comma: strip ammo
                    $line = explode(',', $line, 2)[0];

                    if (preg_match('/^.+x\d{0,4}$/m', $line)) {
                        $words = explode(' ', $line);
                        $count = intval(str_replace("x", "",array_pop($words)));
                        $line = implode(" ", $words);
                    }
                    else {
                        $count = 1;
                    }

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

                        $fit .= sprintf("%s x%d", $line, $slotCount);

                        if ($availableBandwidth == 0 || $count > $slotCount) {
                            $fit .= "\n\n";
                            $drone_happened = true;
                        }

                        $fit .= sprintf("%s x%d", $line, $count-$slotCount);
                    }
                    else {
                        $fit .= $line."\n";
                    }
                }
                else {
                    $fit .= $line."\n";
                }
            }

            return $fit;
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

                    $itemId = $this->getItemID($line);
                    if (in_array($this->getItemSlot($itemId), ["high", "mid", "low", "rig"])) {
                        $modules[] = $itemId;
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

            $struct = [
                'high' =>[],
                'mid' =>[],
                'low' =>[],
                'rig' =>[],
                'drone' =>[],
                'ammo' =>[],
                'cargo' =>[],
                'booster' =>[],
                'implant' =>[]
            ];

            $lines = explode("\n", $eft);
            array_shift($lines);
            foreach ($lines as $line) {
                $line = trim($line);

                if ($line == "") continue;

                // Let's get before the comma: strip ammo
                $ammo = trim(explode(',', $line, 2)[1] ?? "");
                $ammo_id = DB::table("item_prices")->where("NAME", $ammo)->value("ITEM_ID");
                $line = explode(',', $line, 2)[0];

                $count = 1;
                if (preg_match('/^.+x\d{0,4}$/m', $line)) {
                    $words = explode(' ', $line);
                    $count = intval(str_replace("x", "",array_pop($words)));
                    $line = implode(" ",$words);
                }

                try {
                    $price = (DB::table("item_prices")
                            ->where("NAME", $line)
                            ->value("PRICE_BUY") + DB::table("item_prices")
                                                     ->where("NAME", $line)
                                                     ->value("PRICE_SELL")) / 2;
                }
                catch (\Exception $e) {
                    $price = 0;
                }
                $itemID = $this->getItemID($line);
                $slot = $this->getItemSlot($itemID);

                $struct[$slot][] = [
                    'name' => $line,
                    'id' => $itemID,
                    'ammo' => $ammo,
                    'count' => $count,
                    'price' => $price,
                    'ammo_id' => $ammo_id ?? null,
                    'slot' => $slot
                ];
            }

            return $struct;

        }
    }
