<?php


	namespace App\Http\Controllers\EFT;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\Cache\DBCacheController;
    use App\Http\Controllers\EFT\DTO\Eft;
    use App\Http\Controllers\EFT\DTO\EftLine;
    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\MalformedEFTException;
    use App\Http\Controllers\EFT\Exceptions\NotAnItemException;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class FitParser {

        /** @var ItemPriceCalculator */
        private $priceCalculator;

        /** @var ResourceLookupService */
        private $resourceLookup;

        /** @var ItemClassifier */
        private $itemClassifier;

        /**
         * FitParser constructor.
         *
         * @param ItemPriceCalculator   $priceCalculator
         * @param ResourceLookupService $resourceLookup
         * @param ItemClassifier        $itemClassifier
         */
        public function __construct(ItemPriceCalculator $priceCalculator, ResourceLookupService $resourceLookup, ItemClassifier $itemClassifier) {
            $this->priceCalculator = $priceCalculator;
            $this->resourceLookup = $resourceLookup;
            $this->itemClassifier = $itemClassifier;
        }


        /**
         * @param string $eft
         *
         * @return Eft
         * @throws MalformedEFTException Returns error if a malformed EFT string is entered
         */
        public function getFitTypes(string $eft): Eft {

            $eftObj = new Eft();
            $lines = explode("\n", $eft);
            $first = array_shift($lines);

            try {
                $shipName = explode(",", explode("[", $first,2)[1], 2)[0];
                $eftObj->setShipId($this->getItemID($shipName));
            } catch (\Exception $e) {
                throw new MalformedEFTException("Could not extract ship name or ID from line <$shipName>: ".$e->getMessage());
            }
            try {
                $fitName = explode("]", explode(",", $first, 2)[1])[0];
                $eftObj->setFitName($fitName);
            } catch (\Exception $e) {
                throw new MalformedEFTException("Could not extract fit name from line <$fitName>: ".$e->getMessage());
            }

            $eftLines = collect([]);

            foreach ($lines as $line) {
                $line = trim($line);
                if ($line == "") continue;
                $eftLine = new EftLine();

                // Let's get before the comma: strip ammo
                $ammo_id = $this->getAmmoIdFromLine($line);

                $line = explode(',', $line, 2)[0];

                $count = 1;
                if (preg_match('/^.+x\d{0,4}$/m', $line)) {
                    $words = explode(' ', $line);
                    $count = intval(str_replace("x", "", array_pop($words)));
                    $line = implode(" ", $words);
                }

                $itemID = null;
                try {
                    $itemID = Cache::remember("aft.item-id-from-line." . md5($line), now()->addHour(), function () use ($line) {
                        return $this->getItemID($line);
                    });
                } catch (NotAnItemException $ignored) {
                    continue;
                }

                $eftLine->setAmmoTypeId($ammo_id)
                        ->setTypeId($itemID)
                        ->setCount($count);
                $eftLines->add($eftLine);
            }

            $eftObj->setLines($eftLines);
            return $eftObj;
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

            if (DB::table("item_slot")->where("ITEM_ID", $itemID)->exists()) {
                return DB::table("item_slot")->where("ITEM_ID", $itemID)->value("ITEM_SLOT");
            }

            return Cache::remember("aft.item-slot-from-id." . $itemID, now()->addHour(), function () use ($itemID) {
                $itemSlot =  $this->itemClassifier->classify($itemID);
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
         * Gets the ammo ID from the line.
         * @param string $line
         *
         * @return array
         */
        private function getAmmoIdFromLine(string $line) : ?int {
            $ammo = trim(explode(',', $line, 2)[1] ?? "");
            try {
                $ammoObj = $this->priceCalculator->getFromItemName($ammo);
            } catch (\Exception $e) {
                $ammoObj = null;
            }
            if ($ammoObj) {
                $ammo_id = $ammoObj->getTypeId();
            } else {
                $ammo_id = null;
            }

            return $ammo_id;
        }
    }
