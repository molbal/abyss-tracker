<?php


    namespace App\Http\Controllers\EFT;


    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\Cache\DBCacheController;
    use App\Http\Controllers\EFT\Constants\CategoryID;
    use App\Http\Controllers\EFT\Constants\DogmaAttribute;
    use App\Http\Controllers\EFT\Constants\DogmaEffect;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ItemClassifier {

        /**
         * ItemClassifier constructor.
         *
         * @param ResourceLookupService $resourceLookup
         */
        public function __construct(ResourceLookupService $resourceLookup) {
            $this->resourceLookup = $resourceLookup;
        }


        protected ResourceLookupService $resourceLookup;


        /**
         * Classifies an item, returns which display group it belongs to
         *
         * @param int $id
         *
         * @return string|null can be: high, mid, low, rig, drone, ammo, cargo, booster, implant
         */
        public function classify(int $id) : ?string {
                try {

                    $itemInfo = $this->resourceLookup->getItemInformation($id);
                    if (!isset($itemInfo["type_id"]) || $itemInfo["type_id"] != $id) {
                        throw new \RuntimeException("Invalid item id provided or ESI is down");
                    }

                    // Is high slot?
                    $returned = $this->classifyItemSlots($itemInfo);
                    if ($returned != "") {
                        return $returned;
                    }

                    // Is booster or implant?
                    $returned = $this->recognizeBoosterOrImplant($itemInfo);
                    if ($returned != "") {
                        return $returned;
                    }

                    // Is drone?
                    $droneCategories = $this->resourceLookup->getCategoryGroups(CategoryID::DRONE_CATEGORY_ID);
                    foreach ($droneCategories as $pos => $catGroup) {
                        if (intval($catGroup) == ($itemInfo["group_id"])) {
                            return "drone";
                        }
                    }
                    // Ammo?
                    $ammoCategories = $this->resourceLookup->getCategoryGroups(CategoryID::CHARGE_CATEGORY_ID);
                    foreach ($ammoCategories as $pos => $catGroup) {
                        if (intval($catGroup) == ($itemInfo["group_id"])) {
                            return "ammo";
                        }
                    }

                    return "cargo";
                } catch (\Exception $e) {
                    Log::warning("Could not determine fit slot for item id [$id]" .$e->getMessage(). " ".$e->getFile()." ".$e->getLine());
                    return null;
                }
        }
        /**
        * Classify an item's slot type
         * 
         * @param array $itemInfo An array containing the item's information
         * 
         * @return string The slot type of the item (high, mid, low, rig)
        */

        private function classifyItemSlots($itemInfo) : string {
            if (!isset($itemInfo["dogma_effects"])) {
                return "";
            }
            foreach ($itemInfo["dogma_effects"] as $dogmaEffect) {
                if ($dogmaEffect["effect_id"] == DogmaEffect::IS_LOW_SLOT) {
                    return 'high';
                }
                if ($dogmaEffect["effect_id"] == DogmaEffect::IS_MID_SLOT) {
                    return 'mid';
                }
                if ($dogmaEffect["effect_id"] == DogmaEffect::IS_HIGH_SLOT) {
                    return 'low';
                }
                if ($dogmaEffect["effect_id"] == DogmaEffect::IS_RIG_SLOT) {
                    return 'rig';
                }
            }

            return "";
        }
        /**
        * Recognize if an item is a booster or an implant.
         * 
         * @param array $itemInfo The item information.
         * 
         * @return string 'booster' or 'implant' if the item is a booster or an implant, empty string otherwise.
        */

        private function recognizeBoosterOrImplant($itemInfo) : string {
            if (!isset($itemInfo["dogma_attributes"])) {
                return "";
            }
            foreach ($itemInfo["dogma_attributes"] as $dogmaAttr) {
                if ($dogmaAttr["attribute_id"] == DogmaAttribute::IS_BOOSTER) {
                    return 'booster';
                }
                if ($dogmaAttr["attribute_id"] == DogmaAttribute::IS_IMPLANT) {
                    return 'implant';
                }
            }

            return "";
        }
    }
