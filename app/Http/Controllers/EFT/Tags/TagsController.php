<?php


    namespace App\Http\Controllers\EFT\Tags;


    use App\Http\Controllers\EFT\Tags\IFitTag;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class TagsController {

        /**
         * Calculates and applies tags
         *
         * @param int    $id
         * @param string $eft
         * @param array  $stats
         */
        public function applyTags(int $id, string $eft, array $stats) {
            $tags = $this->getTags($eft, $stats);
            foreach ($tags as $tag => $match) {
                DB::table("fit_tags")
                  ->updateOrInsert(["FIT_ID" => $id, "TAG_NAME" => $tag], ["TAG_VALUE" => $match]);
            }
        }

        protected function getTags(string $eft, array $stats) {
            $tagsToCheck = $this->getTagList();

            $tags = [];

            foreach ($tagsToCheck as $tag) {
                try {
                    /** @var IFitTag $checker */
                    $checker = resolve(sprintf("App\\Http\\Controllers\\EFT\\Tags\\Impl\\%s", $tag), ["eft" => $eft, "stats" => $stats]);
                    $tags[$tag] = $checker->calculate();
                } catch (\Exception $e) {
                    Log::warning("Could not calculate $tag - " . $e->getMessage() . " " . $e->getFile() . "@" . $e->getLine());
                }
            }

            return $tags;
        }

        /**
         * @return array
         */
        public function getTagList() : array {
            return ["TagAfterburner", "TagArmorActive", "TagDroneCentric", "TagEnergyWeapons", "TagHybridWeapons", "TagMicrowarpdrive", "TagMissileWeapons", "TagPrecursorWeapons", "TagProjectileWeapons", "TagShieldActive", "TagShieldPassive", "TagStrongCapacitor"];
        }

    }
