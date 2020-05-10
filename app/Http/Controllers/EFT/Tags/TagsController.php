<?php


	namespace App\Http\Controllers\EFT\Tags;


	use App\Http\Controllers\EFT\Tags\IFitTag;

    class TagsController {

        public function getTags(string $eft, array $stats) {
            $tagsToCheck = [
                "TagAfterburner",
                "TagArmorActive",
                "TagDroneCentric",
                "TagEnergyWeapons",
                "TagHybridWeapons",
                "TagMicrowarpdrive",
                "TagMissileWeapons",
                "TagPrecursorWeapons",
                "TagProjectileWeapons",
                "TagShieldActive",
                "TagShieldPassive"
            ];

            $tags = [];

            foreach ($tagsToCheck as $tag) {
                /** @var IFitTag $checker */
                $checker = resolve(sprintf("App\\Http\\Controllers\\EFT\\Tags\\Impl\\%s", $tag), ["eft" => $eft, "stats" => $stats]);
                $tags[$tag] = $checker->calculate();
            }

            return $tags;
	    }

	}
