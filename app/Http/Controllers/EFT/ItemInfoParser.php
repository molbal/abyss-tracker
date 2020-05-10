<?php


	namespace App\Http\Controllers\EFT;


	use App\Http\Controllers\EFT\Constants\DogmaEffect;
    use App\Http\Controllers\EFT\Exceptions\EffectNotFoundException;
    use Illuminate\Support\Facades\DB;

    class ItemInfoParser {

	    private $itemInfo;

        /**
         * ItemInfoParser constructor.
         *
         * @param $itemInfo
         */
        public function __construct($itemInfo) {
            $this->itemInfo = $itemInfo;
        }

        /**
         * @return mixed
         */
        public function getItemInfo() {
            return $this->itemInfo;
        }

        /**
         * @param mixed $itemInfo
         *
         * @return ItemInfoParser
         */
        public function setItemInfo($itemInfo) {
            $this->itemInfo = $itemInfo;

            return $this;
        }

        /**
         * Returns the Item ID
         * @return int item id
         */
        public function getItemId(): int {
            return $this->itemInfo["type_id"] ?? 0;
        }

        /**
         * Gets the item name
         * @return string item name
         */
        public function getItemName(): string {
            return $this->itemInfo["name"] ?? "";
        }

        /**
         * Gets the local row from the ITEM_PRICES table
         * @return mixed|null
         */
        public function getLocalRecord() {
            if (isset($this->itemInfo["item_id"]))
            return DB::table("item_prices")->where("ITEM_ID", $this->getItemId())->get()->get(0);
                else
                    return null;
        }

        /**
         * @param int $effectId
         *
         * @return mixed
         * @throws EffectNotFoundException
         */
        public function getDogmaEffect(int $effectId) {
            if (!isset($this->itemInfo["dogma_effects"])) {
                throw new EffectNotFoundException("Dogma effect $effectId is not present in this item.");
            }
            foreach ($this->itemInfo["dogma_effects"] as $dogmaEffect) {
                if ($dogmaEffect["effect_id"] == $effectId) {
                    return $dogmaEffect["value"];
                }
            }
            throw new EffectNotFoundException("Dogma effect $effectId is not present in this item.");
        }

        /**
         * @param int $effectId
         *
         * @return mixed
         * @throws EffectNotFoundException
         */
        public function getDogmaAttribute(int $effectId) {
            if (!isset($this->itemInfo["dogma_attributes"])) {
                throw new EffectNotFoundException("Dogma effect $effectId is not present in this item.");
            }
            foreach ($this->itemInfo["dogma_attributes"] as $dogmaEffect) {
                if ($dogmaEffect["attribute_id"] == $effectId) {
                    return $dogmaEffect["value"];
                }
            }
            throw new EffectNotFoundException("Dogma effect $effectId is not present in this item.");
        }

    }
