<?php


    namespace App\Http\Controllers\EFT;


    use App\Connector\EveAPI\Universe\ResourceLookupService;
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


        /** @var ResourceLookupService */
        protected $resourceLookup;

        /**
         * Dogma effect and attribute IDs
         */
        const LOW_SLOT_EFFECT_ID = 11;
        const MID_SLOT_EFFECT_ID = 13;
        const HIGH_SLOT_EFFECT_ID = 12;
        const RIG_SLOT_EFFECT_ID = 2663;
        const BOOSTER_ATTR_ID = 1087;
        const IMPLANT_ATTR_ID = 311;
        const CHARGE_CATEGORY_ID = 8;
        const DRONE_CATEGORY_ID = 18;

        /**
         * Classifies an item, returns which display group it belongs to
         *
         * @param int $id
         *
         * @return string can be: high, mid, low, rig, drone, ammo, cargo, booster, implant
         * @throws \Exception
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
                $droneCategories = $this->resourceLookup->getCategoryGroups(self::DRONE_CATEGORY_ID);
                foreach ($droneCategories as $pos => $catGroup) {
                    if (intval($catGroup) == ($itemInfo["group_id"])) {
                        return "drone";
                    }
                }
                // Ammo?
                $ammoCategories = $this->resourceLookup->getCategoryGroups(self::CHARGE_CATEGORY_ID);
                foreach ($ammoCategories as $pos => $catGroup) {
                    if (intval($catGroup) == ($itemInfo["group_id"])) {
                        return "ammo";
                    }
                    else {
                        Log::info($id. " group not in ".$catGroup);
                    }
                }

                return "cargo";
            } catch (\Exception $e) {
                Log::warning("Could not determine fit slot for item id [$id]" .$e->getMessage(). " ".$e->getFile()." ".$e->getLine());
                return null;
            }
        }

        /**
         * @param $itemInfo
         *
         * @return string
         */
        private function classifyItemSlots($itemInfo) : string {
            if (!isset($itemInfo["dogma_effects"])) {
                return "";
            }
            foreach ($itemInfo["dogma_effects"] as $dogmaEffect) {
                if ($dogmaEffect["effect_id"] == self::HIGH_SLOT_EFFECT_ID) {
                    return 'high';
                }
                if ($dogmaEffect["effect_id"] == self::MID_SLOT_EFFECT_ID) {
                    return 'mid';
                }
                if ($dogmaEffect["effect_id"] == self::LOW_SLOT_EFFECT_ID) {
                    return 'low';
                }
                if ($dogmaEffect["effect_id"] == self::RIG_SLOT_EFFECT_ID) {
                    return 'rig';
                }
            }

            return "";
        }

        /**
         * @param $itemInfo
         *
         * @return string
         */
        private function recognizeBoosterOrImplant($itemInfo) : string {
            if (!isset($itemInfo["dogma_attributes"])) {
                return "";
            }
            foreach ($itemInfo["dogma_attributes"] as $dogmaAttr) {
                if ($dogmaAttr["attribute_id"] == self::BOOSTER_ATTR_ID) {
                    return 'booster';
                }
                if ($dogmaAttr["attribute_id"] == self::IMPLANT_ATTR_ID) {
                    return 'implant';
                }
            }

            return "";
        }
    }
