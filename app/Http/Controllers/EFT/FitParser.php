<?php


	namespace App\Http\Controllers\EFT;


	use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\NotAnItemException;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class FitParser {

        /** @var ItemPriceCalculator */
        private $priceCalculator;

        /**
         * FitParser constructor.
         *
         * @param ItemPriceCalculator $priceCalculator
         */
        public function __construct(ItemPriceCalculator $priceCalculator) {
            $this->priceCalculator = $priceCalculator;
        }


        public function getFitTypes(string $eft) {
            $struct = ['high' => [], 'mid' => [], 'low' => [], 'rig' => [], 'drone' => [], 'ammo' => [], 'cargo' => [], 'booster' => [], 'implant' => []];

            $lines = explode("\n", $eft);
            $first = array_shift($lines);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line == "") continue;

                // Let's get before the comma: strip ammo
                $ammo_id = $this->getAmmoIdFromLine($line);

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
